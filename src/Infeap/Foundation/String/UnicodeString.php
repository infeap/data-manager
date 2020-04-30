<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\String;

use Symfony\Component\String\UnicodeString as SymfonyUnicodeString;

class UnicodeString extends SymfonyUnicodeString
{

    public function words(int $count): string
    {
        return implode(' ', array_slice(explode(' ', $this->string), 0, $count));
    }

}
