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
            new TwigFilter('t', [$this, 'translate']),
            new TwigFilter('tp', [$this, 'translatePlural']),
        ];
    }

    public function translate(string $key, string $languageTag = null): string
    {
        return $this->translator->translate($key, $languageTag);
    }

    public function translatePlural(string $key, int $number, string $languageTag = null): string
    {
        return $this->translator->translatePlural($key, $number, $languageTag);
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('current_language', [$this, 'getCurrentLanguage']),
        ];
    }

    public function getCurrentLanguage(): string
    {
        return $this->languageService->getCurrentLanguage();
    }

}
