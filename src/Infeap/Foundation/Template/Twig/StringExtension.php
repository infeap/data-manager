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

use Infeap\Foundation\String\UnicodeString;
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

    public function createUnicodeString(?string $text): UnicodeString
    {
        return new UnicodeString($text ?? '');
    }

}
