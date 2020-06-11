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

use Infeav\Data\Config\DataPartial\SubViewsPartial;

abstract class DataView
{

    protected ?array $meta = null;
    protected ?DataPartialList $partials = null;

    public function setMeta(array $meta): void
    {
        $this->meta = $meta;
    }

    public function getMeta(): array
    {
        if ($this->meta === null) {
            return [];
        }

        return $this->meta;
    }

    public function getMetaValue(string $key, $defaultValue = null)
    {
        return $this->getMeta()[$key] ?? $defaultValue;
    }

    public function getId(): ?string
    {
        return $this->getMetaValue('id') ?: $this->getMetaValue('name');
    }

    public function getIcon(): ?string
    {
        return $this->getMetaValue('icon');
    }

    public function getLabel(): ?string
    {
        return $this->getMetaValue('label') ?: $this->getId();
    }

    public function getDescription(): ?string
    {
        return $this->getMetaValue('description');
    }

    public function toOverview(): array
    {
        return [
            'id' => $this->getId(),
            'icon' => $this->getIcon(),
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
        ];
    }

    protected function assembleSubViews(): ?array
    {
        return null;
    }

    protected function assemblePartials(): array
    {
        $partials = [];

        $subViews = $this->assembleSubViews();

        if (is_array($subViews)) {
            $partials[] = new SubViewsPartial(new DataViewList($subViews));
        }

        return $partials;
    }

    public function getPartials(): DataPartialList
    {
        if ($this->partials === null) {
            $this->partials = new DataPartialList($this->assemblePartials());
        }

        return $this->partials;
    }

    public function findSubView(string $id): ?DataView
    {
        return $this->getPartials()->findSubView($id);
    }

}
