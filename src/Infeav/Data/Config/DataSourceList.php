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

class DataSourceList
{

    protected array $dataSources;
    protected ?bool $isComplete;

    public function __construct(array $dataSources, ?bool $isComplete = null)
    {
        $this->dataSources = $dataSources;
        $this->isComplete = $isComplete;
    }

    public function isComplete(): ?bool
    {
        return $this->isComplete;
    }

    public function toResponseArray(): array
    {
        $response = [];

        /** @var DataSource $dataSource */
        foreach ($this->dataSources as $dataSource) {
            $response[] = $dataSource->toResponseArray();
        }

        return $response;
    }

}
