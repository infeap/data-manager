<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\I18n;

use Infeap\Foundation\I18n\Translator\IniLoader;
use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Cache\StorageFactory;
use Laminas\I18n\Translator\Translator as TranslationEngine;

class Translator
{

    protected $languageService;
    protected $appConfig;

    protected ?TranslationEngine $engine = null;

    public function __construct(LanguageService $languageService, array $appConfig)
    {
        $this->languageService = $languageService;
        $this->appConfig = $appConfig;
    }

    public function getEngine(): TranslationEngine
    {
        if (! $this->engine) {
            $this->engine = new TranslationEngine();

            foreach ($this->appConfig['l10n_files'] as $l10nFile) {
                $this->engine->addTranslationFilePattern(IniLoader::class, $this->appConfig['l10n_dir'], '%s/' . $l10nFile);
            }

            if ($this->languageService->getCurrentLanguage()) {
                $this->engine->setLocale($this->languageService->getCurrentLanguage());
            }

            $this->engine->setFallbackLocale($this->languageService->getFallbackLanguage());

            $l10n_cache_dir = $this->appConfig['cache_dir'] . '/resources/l10n/';

            if (! is_dir($l10n_cache_dir)) {
                mkdir($l10n_cache_dir, 0775, true);
            }

            $this->engine->setCache(StorageFactory::factory([
                'adapter' => [
                    'name' => Filesystem::class,
                    'options' => [
                        'cache_dir' => $l10n_cache_dir,
                        'dir_level' => 0,
                        'namespace' => '',
                    ],
                ],
                'plugins' => ['serializer'],
            ]));

            if ($this->appConfig['debug'] || $this->appConfig['develop']) {
                if ($this->languageService->getCurrentLanguage()) {
                    $this->engine->clearCache('default', $this->languageService->getCurrentLanguage());
                }

                $this->engine->clearCache('default', $this->languageService->getFallbackLanguage());
            }
        }

        return $this->engine;
    }

    public function translate(string $key, string $languageTag = null): string
    {
        if ($languageTag && ! $this->languageService->isSupportedLanguage($languageTag)) {
            $languageTag = null;
        }

        $translation = $this->getEngine()->translate($key, 'default', $languageTag);

        if ($translation === $key) {
            $translation = '[' . $translation . ']';
        }

        return $translation;
    }

    public function translatePlural(string $key, int $number, string $languageTag = null): string
    {
        if ($number == 1) {
            $key .= '.singular';
        } else {
            $key .= '.plural';
        }

        return $this->translate($key, $languageTag);
    }

}
