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

abstract class DataSource
{

    protected ?array $meta = null;

    public function setMeta(array $meta): void
    {
        if ($this->meta !== null) {
            throw new \BadMethodCallException('Data Source meta data can only be set once during initialization');
        }

        $this->meta = $meta;
    }

    public function getMeta(): array
    {
        if ($this->meta === null) {
            throw new \BadMethodCallException('Data Source meta data have not been set during initialization');
        }

        return $this->meta;
    }

    public function getMetaValue(string $key, $defaultValue = null)
    {
        return $this->getMeta()[$key] ?? $defaultValue;
    }

    public function getId(): string
    {
        $name = $this->getMetaValue('name');

        if ($name) {
            return $name;
        }

        $type = $this->getMetaValue('type');

        if ($type) {
            return $type;
        }

        throw new \BadMethodCallException('Data Source meta data contains no identification key');
    }

    public function toResponseArray(): array
    {
        return [
            'id' => $this->getId(),
        ];
    }

}
