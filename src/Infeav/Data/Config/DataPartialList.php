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

    protected array $partials;

    public function __construct(array $partials = [])
    {
        $this->partials = $partials;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->partials);
    }

    public function findSubView(string $id): ?DataView
    {
        foreach ($this->partials as $partial) {
            if ($partial instanceof SubViewsPartial) {
                $subView = $partial->findSubView($id);

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

        /** @var DataPartial $partial */
        foreach ($this->partials as $partial) {
            $response[] = $partial->toResponse();
        }

        return $response;
    }

}
