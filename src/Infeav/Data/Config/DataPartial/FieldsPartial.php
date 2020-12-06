<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataPartial;

use Infeav\Data\Config\DataFieldList;
use Infeav\Data\Config\DataPartial;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;

class FieldsPartial extends DataPartial implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    protected ?string $type = 'fields';

    protected DataFieldList $fields;

    public function __construct($fields)
    {
        if (is_array($fields)) {
            $fields = new DataFieldList($fields);
        }

        $this->fields = $fields;
    }

    public function toResponse(): array
    {
        return [
            'type' => $this->getType(),
            'fields' => $this->fields->toResponse(),
        ];
    }

}
