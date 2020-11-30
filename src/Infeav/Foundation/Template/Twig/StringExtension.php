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

use Infeav\Foundation\String\UnicodeString;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StringExtension extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new TwigFilter('unicode_string', [$this, 'createUnicodeString']),
        ];
    }

    public function createUnicodeString(string $text): UnicodeString
    {
        return new UnicodeString($text);
    }

}
