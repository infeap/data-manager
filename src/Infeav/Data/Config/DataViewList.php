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

class DataViewList implements \IteratorAggregate
{

    /**
     * @param $dataViews DataView[]
     * @param bool|null $isComplete
     */
    public function __construct(
        protected array $dataViews = [],
        protected ?bool $isComplete = null,
    ) { }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->dataViews);
    }

    public function isComplete(): ?bool
    {
        return $this->isComplete;
    }

    public function toOverview(): array
    {
        $overview = [];

        foreach ($this->dataViews as $dataView) {
            $overview[] = $dataView->toOverview();
        }

        return $overview;
    }

}
