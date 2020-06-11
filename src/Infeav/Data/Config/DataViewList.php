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

    protected array $views;
    protected ?bool $isComplete;

    public function __construct(array $views = [], ?bool $isComplete = null)
    {
        $this->views = $views;
        $this->isComplete = $isComplete;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->views);
    }

    public function isComplete(): ?bool
    {
        return $this->isComplete;
    }

    public function toOverview(): array
    {
        $overview = [];

        /** @var DataView $dataView */
        foreach ($this->views as $dataView) {
            $overview[] = $dataView->toOverview();
        }

        return $overview;
    }

}
