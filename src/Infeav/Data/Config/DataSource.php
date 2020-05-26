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

use Symfony\Component\String\Slugger\AsciiSlugger;

abstract class DataSource
{

    protected ?array $meta = null;

    protected ?string $id = null;
    protected ?string $slug = null;

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
        if ($this->id === null) {
            $name = $this->getMetaValue('name');

            if ($name) {
                $this->id = $name;
            } else {
                $type = $this->getMetaValue('type');

                if ($type) {
                    $this->id = $type;
                }
            }

            if (! $this->id) {
                throw new \BadMethodCallException('Data Source meta data contains no identification key');
            }
        }

        return $this->id;
    }

    public function getSlug(): string
    {
        if ($this->slug === null) {
            $this->slug = (new AsciiSlugger())->slug($this->id);
        }

        return $this->slug;
    }

    public function getLabel(): string
    {
        $label = $this->getMetaValue('label');

        if ($label) {
            return $label;
        }

        return $this->getId();
    }

    public function toResponseArray(): array
    {
        return [
            'id' => $this->getId(),
            'slug' => $this->getSlug(),
            'type' => $this->getMetaValue('type'),
            'label' => $this->getLabel(),
        ];
    }

}
