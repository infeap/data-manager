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

use Infeav\Data\Config\DataPartial\FieldsPartial;
use Infeav\Data\Config\DataView\DbBasedView;

class SchemaView extends DbBasedView
{

    protected ?string $name = 'schema';
    protected ?string $icon = 'bounding-box';
    protected ?string $label = 'trans:data_views.infeav.data.schema.label';

    protected function assembleDataPartials(): array
    {
        return [
            new FieldsPartial([
                [
                    'type' => 'text',
                    'name' => 'title',
                    'label' => 'trans:data_partials.fields.title.label',
                ],
            ]),
        ];
    }

}
