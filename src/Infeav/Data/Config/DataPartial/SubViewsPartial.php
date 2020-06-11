<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataPartial;

use Infeav\Data\Config\DataPartial;
use Infeav\Data\Config\DataView;
use Infeav\Data\Config\DataViewList;

class SubViewsPartial extends DataPartial
{

    protected DataViewList $subViews;

    public function __construct($subViews)
    {
        if (is_array($subViews)) {
            $subViews = new DataViewList($subViews);
        }

        $this->subViews = $subViews;
    }

    public function findSubView(string $id): ?DataView
    {
        /** @var DataView $subView */
        foreach ($this->subViews as $subView) {
            if ($subView->getId() === $id) {
                return $subView;
            }
        }

        return null;
    }

    public function getType(): string
    {
        return 'sub_views';
    }

    public function toResponse(): array
    {
        return [
            'type' => $this->getType(),
            'subViews' => $this->subViews->toOverview(),
        ];
    }

}
