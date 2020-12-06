<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataView\Infeav\Data\Create;

use Infeav\Data\Config\DataField;
use Infeav\Data\Config\DataField\TextField;
use Infeav\Data\Config\DataPartial\FieldsPartial;
use Infeav\Data\Config\DataView\DbBasedView;
use Laminas\EventManager\EventInterface;

class RecordView extends DbBasedView
{

    protected ?string $name = 'record';
    protected ?string $icon = 'box';
    protected ?string $label = 'trans:data_views.infeav.data.record.label';

    protected function getFields(): array
    {
        return [
            new TextField([
                'name' => 'title',
                'label' => 'trans:data_partials.fields.title.label',
            ]),
        ];
    }

    protected function assembleDataPartials(): array
    {
        $fieldsPartial = new FieldsPartial($this->getFields());

        $fieldsPartial->getEventManager()->attach('create_fields', [$this, 'createRecord']);
        $fieldsPartial->getEventManager()->attach('edit_fields', [$this, 'editRecord']);

        return [
            $fieldsPartial,
        ];
    }

    protected function matchFields(array $passedFields): array
    {
        $matchedFields = [];

        $viewFields = $this->getFields();

        foreach ($passedFields as $passedField) {
            if (! (is_array($passedField) && isset($passedField['name']) && isset($passedField['value']))) {
                continue;
            }

            foreach ($viewFields as $viewField) {
                if ($viewField instanceof DataField) {
                    if ($viewField->getName() === $passedField['name']) {
                        $viewField->setValue($passedField['value']);

                        $matchedFields[] = $viewField;
                    }
                }
            }
        }

        return $matchedFields;
    }

    public function createRecord(EventInterface $event) // ToDo: Return type?
    {
        $fields = $this->matchFields($event->getParams());

        // ToDo ...
    }

    public function editRecord(EventInterface $event) // ToDo: Return type?
    {
        $fields = $this->matchFields($event->getParams());

        // ToDo ...
    }

}
