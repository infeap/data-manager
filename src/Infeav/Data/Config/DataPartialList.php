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

class DataPartialList implements \IteratorAggregate
{

    /**
     * @param DataPartial[] $dataPartials
     */
    public function __construct(
        protected array $dataPartials = [],
    ) { }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->dataPartials);
    }

    public function findSubView(string $slug): ?DataView
    {
        foreach ($this->dataPartials as $dataPartial) {
            if ($dataPartial instanceof SubViewsPartial) {
                $subView = $dataPartial->findSubView($slug);

                if ($subView) {
                    return $subView;
                }
            }
        }

        return null;
    }

    public function toResponse(): array
    {
        $response = [];

        foreach ($this->dataPartials as $dataPartial) {
            $response[] = $dataPartial->toResponse();
        }

        return $response;
    }

}
