<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Http\Response;

class BasicMessageResponse extends KeyedResponse
{

    protected ?string $heading;
    protected ?array $descriptionLines;

    protected ?string $type;

    /**
     * @param $options ['heading']: string
     *                 ['description']: string
     *                 ['type']: string
     *
     *                 ['key']: string
     *                 ['details']: array
     *                 ['debug']: array
     *
     *                 ['status']: int
     *                 ['headers']: array
     */
    public function __construct(array $options = [])
    {
        $this->heading = $options['heading'] ?? null;

        $description = $options['description'] ?? null;

        if ($description) {
            if (is_string($description)) {
                $this->descriptionLines = [$description];
            } else if (is_array($description)) {
                $this->descriptionLines = $description;
            }
        }

        $this->type = $options['type'] ?? null;

        parent::__construct($options);
    }

    public function getHeading(): ?string
    {
        return $this->heading;
    }

    public function getDescriptionLines(): ?array
    {
        return $this->descriptionLines;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

}
