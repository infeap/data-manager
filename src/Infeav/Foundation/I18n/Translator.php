<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\I18n;

use Infeav\Foundation\I18n\Translator\IniLoader;
use Infeav\Foundation\Log\LogManager;
use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Cache\StorageFactory;
use Laminas\EventManager\EventInterface;
use Laminas\I18n\Translator\Translator as TranslationEngine;

class Translator
{

    protected ?TranslationEngine $engine = null;
    protected ?array $textDomains = null;

    public function __construct(
        protected LanguageService $languageService,
        protected array $appConfig,
        protected ?LogManager $logManager = null,
    ) { }

    public function getEngine(): TranslationEngine
    {
        if (! $this->engine) {
            $this->engine = new TranslationEngine();

            $this->textDomains = [];

            foreach ($this->appConfig['l10n_files'] as $l10nFile) {
                $textDomain = explode('/', $l10nFile, 2)[0];
                $this->textDomains[] = $textDomain;

                $this->engine->addTranslationFilePattern(
                    type: IniLoader::class,
                    baseDir: $this->appConfig['l10n_dir'],
                    pattern: '%s/' . $l10nFile,
                    textDomain: $textDomain,
                );
            }

            if ($this->languageService->getCurrentLanguage()) {
                $this->engine->setLocale($this->languageService->getCurrentLanguage());
            }

            $this->engine->setFallbackLocale($this->languageService->getFallbackLanguage());

            /*
             * Setup caching
             */
            $l10nCacheDir = $this->appConfig['cache_dir'] . '/resources/l10n/';

            if (! is_dir($l10nCacheDir)) {
                mkdir($l10nCacheDir, $this->appConfig['dir_permissions_mode'], true);
            }

            $this->engine->setCache(StorageFactory::factory([
                'adapter' => [
                    'name' => Filesystem::class,
                    'options' => [
                        'cache_dir' => $l10nCacheDir,
                        'dir_level' => 0,
                        'namespace' => '',
                    ],
                ],
                'plugins' => ['serializer'],
            ]));

            if ($this->appConfig['debug'] || $this->appConfig['develop']) {
                if ($this->languageService->getCurrentLanguage()) {
                    foreach ($this->textDomains as $textDomain) {
                        $this->engine->clearCache($textDomain, $this->languageService->getCurrentLanguage());
                    }
                }

                foreach ($this->textDomains as $textDomain) {
                    $this->engine->clearCache($textDomain, $this->languageService->getFallbackLanguage());
                }
            }

            /*
             * Setup missing translations logging (if not in debug mode)
             */
            if ($this->logManager) {
                $this->engine->enableEventManager()->getEventManager()->attach('missingTranslation', function (EventInterface $event) {
                    $this->logManager->logMissingTranslation(
                        key: $event->getParam('message'),
                        textDomain: $event->getParam('text_domain'),
                        languageTag: $event->getParam('locale'),
                    );
                });
            }
        }

        return $this->engine;
    }

    public function hasTextDomain(string $textDomain): bool
    {
        return in_array($textDomain, $this->getTextDomains());
    }

    public function getTextDomains(): array
    {
        $this->getEngine(); // Initialize text domains if necessary

        return $this->textDomains;
    }

    public function getAllMessages(string $textDomain = 'foundation', ?string $languageTag = null)
    {
        return $this->getEngine()->getAllMessages($textDomain, $languageTag);
    }

    public function translate(string $key, string $textDomain = 'foundation', ?string $languageTag = null): string
    {
        if ($languageTag && ! $this->languageService->isSupportedLanguage($languageTag)) {
            $languageTag = null;
        }

        $translation = $this->getEngine()->translate($key, $textDomain, $languageTag);

        if ($translation === $key) {
            $translation = '[' . $translation . ']';
        }

        return $translation;
    }

    public function translateOnDemand(string $key, string $textDomain = 'foundation', ?string $languageTag = null): string
    {
        if (str_starts_with($key, 'trans:')) {
            return $this->translate(substr($key, strlen('trans:')), $textDomain, $languageTag);
        } else {
            return $key;
        }
    }

    public function translateList(string $key, string $textDomain = 'foundation', ?string $languageTag = null): array
    {
        $translationList = [];

        $i = 1;

        while ($i < 1024) {
            $translationKey = $key . '.' . $i;
            $translation = $this->translate($translationKey, $textDomain, $languageTag);

            if ($translation != '[' . $translationKey . ']') {
                $translationList[] = $translation;
                $i++;
            } else {
                break;
            }
        }

        return $translationList;
    }

    public function translatePlural(string $key, int $number, string $textDomain = 'foundation', ?string $languageTag = null): string
    {
        if ($number == 1) {
            $key .= '.singular';
        } else {
            $key .= '.plural';
        }

        return $this->translate($key, $textDomain, $languageTag);
    }

    public function translatePluralList(string $key, int $number, string $textDomain = 'foundation', ?string $languageTag = null): array
    {
        $translationList = [];

        $i = 1;

        while ($i < 1024) {
            if ($number == 1) {
                $translationKey = $key . '.singular.' . $i;
            } else {
                $translationKey = $key . '.plural.' . $i;
            }

            $translation = $this->translate($translationKey, $textDomain, $languageTag);

            if ($translation != '[' . $translationKey . ']') {
                $translationList[] = $translation;
                $i++;
            } else {
                break;
            }
        }

        return $translationList;
    }

}
