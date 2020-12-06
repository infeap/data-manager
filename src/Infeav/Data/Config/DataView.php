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

    protected ?string $name = null;
    protected ?string $slug = null;
    protected ?string $icon = null;
    protected ?string $defaultIcon = null;
    protected ?string $label = null;
    protected ?string $defaultLabel = null;
    protected ?string $description = null;
    protected ?string $defaultDescription = null;

    protected ?DataPartialList $dataPartials = null;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getSlug(): ?string
    {
        return $this->slug ?: /* ToDo: Slugify */ $this->getName();
    }

    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    public function getIcon(): ?string
    {
        return $this->icon ?: $this->defaultIcon;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getLabel(): ?string
    {
        return ($this->label ?: $this->defaultLabel) ?: $this->getName();
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description ?: $this->defaultDescription;
    }

    public function toOverview(): array
    {
        return [
            'name' => $this->getName(),
            'slug' => $this->getSlug(),
            'icon' => $this->getIcon(),
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
        ];
    }

    protected function assembleSubViews(): ?array
    {
        return null;
    }

    protected function assembleDataPartials(): array
    {
        $dataPartials = [];

        $subViews = $this->assembleSubViews();

        if (is_array($subViews)) {
            $dataPartials[] = new SubViewsPartial(new DataViewList($subViews));
        }

        return $dataPartials;
    }

    public function getDataPartials(): DataPartialList
    {
        if ($this->dataPartials === null) {
            $this->dataPartials = new DataPartialList($this->assembleDataPartials());
        }

        return $this->dataPartials;
    }

    public function findSubView(string $slug): ?DataView
    {
        return $this->getDataPartials()->findSubView($slug);
    }

}
