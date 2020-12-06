<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config;

class DataFieldList implements \IteratorAggregate
{

    public function __construct(
        protected array $fields = [],
    ) { }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->fields);
    }

    public function toResponse(): array
    {
        $response = [];

        /** @var DataField $field */
        foreach ($this->fields as $field) {
            $response[] = $field->toResponse();
        }

        return $response;
    }

}
