<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Template\Twig;

use Infeap\Foundation\I18n\LanguageService;
use Infeap\Foundation\I18n\Translator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TranslationExtension extends AbstractExtension
{

    protected $translator;
    protected $languageService;

    public function __construct(Translator $translator, LanguageService $languageService)
    {
        $this->translator = $translator;
        $this->languageService = $languageService;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('trans', [$this, 'translate']),
            new TwigFilter('trans_list', [$this, 'translateList']),
            new TwigFilter('trans_plural', [$this, 'translatePlural']),
            new TwigFilter('trans_plural_list', [$this, 'translatePluralList']),
        ];
    }

    public function translate(string $key, string $textDomain = 'foundation', ?string $languageTag = null): string
    {
        return $this->translator->translate($key, $textDomain, $languageTag);
    }

    public function translateList(string $key, string $textDomain = 'foundation', ?string $languageTag = null): array
    {
        return $this->translator->translateList($key, $textDomain, $languageTag);
    }

    public function translatePlural(string $key, int $number, string $textDomain = 'foundation', ?string $languageTag = null): string
    {
        return $this->translator->translatePlural($key, $number, $textDomain, $languageTag);
    }

    public function translatePluralList(string $key, int $number, string $textDomain = 'foundation', ?string $languageTag = null): array
    {
        return $this->translator->translatePluralList($key, $number, $textDomain, $languageTag);
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('supported_languages', [$this, 'getSupportedLanguages']),
            new TwigFunction('current_language', [$this, 'getCurrentLanguage']),
        ];
    }

    public function getSupportedLanguages(): array
    {
        return $this->languageService->getSupportedLanguages();
    }

    public function getCurrentLanguage(): string
    {
        return $this->languageService->getCurrentLanguage() ?: $this->languageService->getFallbackLanguage();
    }

}
