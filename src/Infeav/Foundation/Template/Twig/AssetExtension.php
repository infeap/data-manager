<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Template\Twig;

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
        $filePath = $this->getFilePath($context, $url);

        if ($context['app']['config']['debug'] && is_file($filePath)) {
            return $url;
        } else {
            if (str_contains($url, '?')) {
                $regexLimiter = '?)';
            } else if (str_contains($url, '#')) {
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
        $filePath = $this->getFilePath($context, $url);

        if (is_file($filePath) && is_readable($filePath)) {
            $anchorPos = strpos($url, '#');

            if ($anchorPos) {
                $anchor = substr($url, $anchorPos);
                $versionedUrl = substr($url, 0, $anchorPos);
            } else {
                $anchor = null;
                $versionedUrl = $url;
            }

            $fileVersion = filemtime($filePath);

            if (str_contains($versionedUrl, '?')) {
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
        $publicPath = substr($url, strlen($context['app']['base_path']));

        if (str_contains($publicPath, '?')) {
            $publicPath = substr($publicPath, 0, strpos($publicPath, '?'));
        } else if (str_contains($publicPath, '#')) {
            $publicPath = substr($publicPath, 0, strpos($publicPath, '#'));
        }

        return $context['app']['dir'] . '/public' . $publicPath;
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
        return $this->getCompiledUrl($env, $context, $path, fileType: 'css');
    }

    public function getCompiledJsUrl(Environment $env, array $context, string $path): string
    {
        return $this->getCompiledUrl($env, $context, $path, fileType: 'js');
    }

    protected function getCompiledUrl(Environment $env, array $context, string $path, string $fileType): string
    {
        $compiledPath = sprintf('%1$s/compiled/%2$s.%1$s',
            $fileType, $path);

        if ($context['app']['config']['develop']) {
            $compiledUrl = $context['app']['config']['dev_server_url'] . $compiledPath;
        } else {
            $compiledUrl = $env->getFunction('asset')->getCallable()($compiledPath);

            $compiledUrl = $this->minifyAssetUrl($context, $compiledUrl);
            $compiledUrl = $this->appendFileVersion($context, $compiledUrl);
        }

        return $compiledUrl;
    }

}
