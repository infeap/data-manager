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

class LanguageService
{

    protected ?array $supportedLanguages = null;
    protected ?string $fallbackLanguage = null;

    protected string $currentLanguage;

    public function __construct(?array $supportedLanguages = null, ?string $fallbackLanguage = null)
    {
        if ($supportedLanguages) {
            $this->supportedLanguages = array_map(function (string $languageTag): string {
                return $this->normalizeLanguageTag($languageTag);
            }, $supportedLanguages);
        }

        if ($fallbackLanguage) {
            $this->fallbackLanguage = $this->normalizeLanguageTag($fallbackLanguage);
        }

        $this->setCurrentLanguage('en');
    }

    public function getSupportedLanguages(): ?array
    {
        return $this->supportedLanguages;
    }

    public function getFallbackLanguage(): ?string
    {
        return $this->fallbackLanguage;
    }

    public function getCurrentLanguage(): string
    {
        return $this->currentLanguage;
    }

    protected function setCurrentLanguage(string $languageTag): void
    {
        $this->currentLanguage = $this->normalizeLanguageTag($languageTag);

        if (class_exists('Locale')) {
            \Locale::setDefault($this->currentLanguage);
        }
    }

    public function updateCurrentLanguage(string $languageTag): bool
    {
        if ($this->isSupportedLanguage($languageTag)) {
            $this->setCurrentLanguage($languageTag);

            return true;
        } else {
            return false;
        }
    }

    public function isSupportedLanguage(string $languageTag): bool
    {
        return in_array($this->normalizeLanguageTag($languageTag), $this->supportedLanguages);
    }

    public function normalizeLanguageTag(string $languageTag): string
    {
        $languageTag = str_replace('_', '-', $languageTag);
        $languageTag = trim($languageTag, ' -');

        return $languageTag;
    }

}
