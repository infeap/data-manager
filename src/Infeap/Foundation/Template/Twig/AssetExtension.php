<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Template\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AssetExtension extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new TwigFilter('minify_asset_url', [$this, 'minifyAssetUrl'], ['needs_context' => true]),
            new TwigFilter('file_version', [$this, 'appendFileVersion'], ['needs_context' => true]),
        ];
    }

    public function minifyAssetUrl(array $context, string $url): string
    {
        $file = $this->getFilePath($context, $url);

        if ($context['app']['config']['debug'] && is_file($file)) {
            return $url;
        } else {
            if (strpos($url, '?')) {
                $regexLimiter = '?)';
            } else if (strpos($url, '#')) {
                $regexLimiter = '#)';
            } else {
                $regexLimiter = ')$';
            }

            $minifiedUrl = preg_replace('~\.([a-z0-9]+' . $regexLimiter . '~i', '.min.$1', $url);

            $minifiedFile = $this->getFilePath($context, $minifiedUrl);

            if (is_file($minifiedFile)) {
                return $minifiedUrl;
            } else {
                return $url;
            }
        }
    }

    public function appendFileVersion(array $context, string $url): string
    {
        $file = $this->getFilePath($context, $url);

        if (is_file($file)) {
            $anchorPos = strpos($url, '#');

            if ($anchorPos) {
                $anchor = substr($url, $anchorPos);
                $versionedUrl = substr($url, 0, $anchorPos);
            } else {
                $anchor = null;
                $versionedUrl = $url;
            }

            $fileVersion = filemtime($file);

            if (strpos($versionedUrl, '?')) {
                $versionedUrl .= '&v=' . $fileVersion;
            } else {
                $versionedUrl .= '?v=' . $fileVersion;
            }

            if ($anchor) {
                $versionedUrl .= $anchor;
            }

            return $versionedUrl;
        } else {
            return $url;
        }
    }

    protected function getFilePath(array $context, string $url): string
    {
        $basePath = $context['app']['base_path'];
        $publicPath = substr($url, strpos($url, $basePath) + strlen($basePath));

        if (strpos($publicPath, '?')) {
            $publicPath = substr($publicPath, 0, strpos($publicPath, '?'));
        } else if (strpos($publicPath, '#')) {
            $publicPath = substr($publicPath, 0, strpos($publicPath, '#'));
        }

        $file = $context['app']['dir'] . '/public/' . $publicPath;

        return $file;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('compiled_css', [$this, 'getCompiledCssUrl'], [
                'needs_context' => true,
                'needs_environment' => true,
            ]),
            new TwigFunction('compiled_js', [$this, 'getCompiledJsUrl'], [
                'needs_context' => true,
                'needs_environment' => true,
            ]),
        ];
    }

    public function getCompiledCssUrl(Environment $env, array $context, string $path): string
    {
        return $this->getCompiledUrl($env, $context, 'css', $path);
    }

    public function getCompiledJsUrl(Environment $env, array $context, string $path): string
    {
        return $this->getCompiledUrl($env, $context, 'js', $path);
    }

    protected function getCompiledUrl(Environment $env, array $context, string $filenameExtension, string $path): string
    {
        $compiledPath = sprintf('%1$s/compiled/%2$s.%1$s',
            $filenameExtension, $path);

        if ($context['app']['config']['develop']) {
            $compiledUrl = $context['app']['config']['dev_server_url'] . $compiledPath;
        } else {
            $compiledUrl = $env->getFunction('asset')->getCallable()($compiledPath);
        }

        $compiledUrl = $this->minifyAssetUrl($context, $compiledUrl);
        $compiledUrl = $this->appendFileVersion($context, $compiledUrl);

        return $compiledUrl;
    }

}
