<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

use Mezzio\Application;
use Mezzio\Router\Middleware\DispatchMiddleware;

/*
 * See init/app-array.php for available $app keys
 */
return function (array $app, array $routesConfig, Application $application): void {

    $middlewarePipeline = require '../config/middleware-pipeline.php';

    if (is_callable($middlewarePipeline)) {
        $middlewarePipeline = $middlewarePipeline($app);
    }

    if (! is_array($middlewarePipeline)) {
        return;
    }

    $wrapMiddleware = [
        'start' => [],
        'end' => [],
    ];

    foreach ($routesConfig as $key => $routeConfig) {
        if (! (is_string($key) && is_array($routeConfig))) {
            continue;
        }

        $startMidleware = $routeConfig['start'] ?? null;
        $beforeMidleware = $routeConfig['before'] ?? null;
        $afterMidleware = $routeConfig['after'] ?? null;
        $endMidleware = $routeConfig['end'] ?? null;

        if (! ($startMidleware || $beforeMidleware || $afterMidleware || $endMidleware)) {
            continue;
        }

        $target = null;

        if (isset($routeConfig['path'])) {
            $key = '^' . $routeConfig['path'] . '$';
            $target = DispatchMiddleware::class;
        }

        if (isset($routeConfig['target'])) {
            $target = $routeConfig['target'];
        }

        if ($target) {
            if (is_array($target)) {
                $target = current($target);
            }
        }

        if ($beforeMidleware || $afterMidleware) {
            if (! $target) {
                continue;
            }

            if (! is_string($target)) {
                continue;
            }
        }

        if (preg_match('~' . $key . '~', $app['request_path'])) {
            if ($target) {
                if (! isset($wrapMiddleware[$target])) {
                    $wrapMiddleware[$target] = [
                        'before' => [],
                        'after' => [],
                    ];
                }
            }

            if ($startMidleware) {
                if (is_string($startMidleware)) {
                    $startMidleware = [$startMidleware];
                }

                $wrapMiddleware['start'] = [...$wrapMiddleware['start'], ...$startMidleware];
            }

            if ($beforeMidleware) {
                if (is_string($beforeMidleware)) {
                    $beforeMidleware = [$beforeMidleware];
                }

                $wrapMiddleware[$target]['before'] = [...$wrapMiddleware[$target]['before'], ...$beforeMidleware];
            }

            if ($afterMidleware) {
                if (is_string($afterMidleware)) {
                    $afterMidleware = [$afterMidleware];
                }

                $wrapMiddleware[$target]['after'] = [...$afterMidleware, ...$wrapMiddleware[$target]['after']];
            }

            if ($endMidleware) {
                if (is_string($endMidleware)) {
                    $endMidleware = [$endMidleware];
                }

                $wrapMiddleware['end'] = [...$endMidleware, ...$wrapMiddleware['end']];
            }
        }
    }

    if ($app['config']['debug']) {
        $middlewarePipelineLog = [];

        $pipe = function ($middleware) use ($application, &$middlewarePipelineLog) {
            $middlewarePipelineLog[] = $middleware;
            $application->pipe($middleware);
        };
    } else {
        $pipe = function ($middleware) use ($application) {
            $application->pipe($middleware);
        };
    }

    $pipeLine = function (array $middlewarePipeline) use (&$pipeLine, $pipe, $wrapMiddleware): void {
        foreach ($middlewarePipeline as $middleware) {
            if (isset($wrapMiddleware[$middleware])) {
                $pipeLine($wrapMiddleware[$middleware]['before']);
            }

            $pipe($middleware);

            if (isset($wrapMiddleware[$middleware])) {
                $pipeLine($wrapMiddleware[$middleware]['after']);
            }
        }
    };

    $pipeLine($wrapMiddleware['start']);
    $pipeLine($middlewarePipeline);
    $pipeLine($wrapMiddleware['end']);

    if ($app['config']['debug']) {
        $middlewarePipelineLogFile = sprintf('%s/debug/last-middleware-pipeline.php',
            $app['config']['log_dir']);

        if ((is_file($middlewarePipelineLogFile) && is_writable($middlewarePipelineLogFile)) ||
            (! is_file($middlewarePipelineLogFile) && is_writable(dirname($middlewarePipelineLogFile)))) {

            file_put_contents($middlewarePipelineLogFile, "<?php\n\nreturn " . var_export($middlewarePipelineLog, true) . ";\n");
        }
    }
};
