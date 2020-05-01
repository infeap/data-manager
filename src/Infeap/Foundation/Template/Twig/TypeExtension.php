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

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TypeExtension extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new TwigFilter('type', [$this, 'getType']),
        ];
    }

    public function getType($var): string
    {
        $type = gettype($var);

        if ($type == 'object') {
            $type = get_class($var);
        }

        return $type;
    }

}
