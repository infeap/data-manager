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

    protected array $dataViews;
    protected ?bool $isComplete;

    public function __construct(array $dataViews, ?bool $isComplete = null)
    {
        $this->dataViews = $dataViews;
        $this->isComplete = $isComplete;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->dataViews);
    }

    public function isComplete(): ?bool
    {
        return $this->isComplete;
    }

    public function toOverviewArray(): array
    {
        $response = [];

        /** @var DataView $dataView */
        foreach ($this->dataViews as $dataView) {
            $response[] = $dataView->toOverviewArray();
        }

        return $response;
    }

}
