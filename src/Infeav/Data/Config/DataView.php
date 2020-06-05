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

abstract class DataView
{

    protected ?array $meta = null;
    protected ?DataViewList $childDataViews = null;

    public function setMeta(array $meta): void
    {
        if ($this->meta !== null) {
            throw new \BadMethodCallException('Data View meta data can only be set once during initialization');
        }

        $this->meta = $meta;
    }

    public function getMeta(): array
    {
        if ($this->meta !== null) {
            return $this->meta;
        } else {
            return [];
        }
    }

    public function getMetaValue(string $key, $defaultValue = null)
    {
        return $this->getMeta()[$key] ?? $defaultValue;
    }

    public function getId(): ?string
    {
        return $this->getMetaValue('id') ?: $this->getMetaValue('name');
    }

    public function getLabel(): ?string
    {
        return $this->getMetaValue('label') ?: $this->getId();
    }

    public function getDescription(): ?string
    {
        return $this->getMetaValue('description');
    }

    public function toOverviewArray(): array
    {
        return [
            'id' => $this->getId(),
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
        ];
    }

    public function assembleChildDataViews(): array
    {
        return [];
    }

    public function getChildDataViews(): DataViewList
    {
        if ($this->childDataViews === null) {
            $this->childDataViews = new DataViewList($this->assembleChildDataViews());
        }

        return $this->childDataViews;
    }

    public function toDetailsArray(): array
    {
        return [
            'childDataViews' => $this->getChildDataViews()->toOverviewArray(),
        ];
    }

}
