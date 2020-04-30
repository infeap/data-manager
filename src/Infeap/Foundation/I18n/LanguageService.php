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

class LanguageService
{

    protected $supportedLanguages;
    protected $fallbackLanguage;

    protected $currentLanguage;

    public function __construct(array $supportedLanguages, string $fallbackLanguage)
    {
        $this->supportedLanguages = array_map(function (string $languageTag) {
            return $this->normalizeLanguageTag($languageTag);
        }, $supportedLanguages);

        $this->fallbackLanguage = $this->normalizeLanguageTag($fallbackLanguage);

        if (class_exists('Locale')) {
            \Locale::setDefault($fallbackLanguage);
        }
    }

    public function getSupportedLanguages(): array
    {
        return $this->supportedLanguages;
    }

    public function getFallbackLanguage(): string
    {
        return $this->fallbackLanguage;
    }

    public function getCurrentLanguage(): ?string
    {
        return $this->currentLanguage;
    }

    public function setCurrentLanguage(string $languageTag): bool
    {
        if (! $this->isSupportedLanguage($languageTag)) {
            return false;
        }

        $this->currentLanguage = $this->normalizeLanguageTag($languageTag);

        if (class_exists('Locale')) {
            \Locale::setDefault($this->currentLanguage);
        }

        return true;
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
