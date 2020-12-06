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

abstract class DataSource extends DataView
{

    protected ?string $defaultIcon = 'file';

    protected ?DataSource $annotationsDataSource = null;

    public function isUsableForAnnotations(): bool
    {
        return false;
    }

    public function setAnnotationsDataSource(DataSource $dataSource): void
    {
        if ($dataSource->isUsableForAnnotations()) {
            $this->annotationsDataSource = $dataSource;
        }
    }

    public function hasAnnotationsSupport(): bool
    {
        return (bool) $this->getAnnotationsDataSource();
    }

    public function getAnnotationsDataSource(): ?DataSource
    {
        return $this->annotationsDataSource;
    }

}
