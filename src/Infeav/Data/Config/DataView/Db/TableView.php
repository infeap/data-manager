<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataView\Db;

use Infeav\Data\Config\DataView\Db\Table\RowsView;
use Infeav\Data\Config\DataView\Db\Table\StructureView;
use Infeav\Data\Config\DataView\DbBasedView;
use Laminas\Db\Adapter\Adapter as DbAdapter;
use Laminas\Db\Metadata\MetadataInterface;
use Laminas\Db\TableGateway\TableGateway;

class TableView extends DbBasedView
{

    protected string $tableName;

    public function __construct(DbAdapter $dbAdapter, MetadataInterface $dbMeta, string $tableName)
    {
        parent::__construct($dbAdapter, $dbMeta);

        $this->tableName = $tableName;
        $this->name = $tableName;
    }

    public function toOverview(): array
    {
        // ToDo: Add extra data like size (or via details view?)
        return parent::toOverview();
    }

    public function assembleSubViews(): array
    {
        $table = new TableGateway($this->tableName, $this->dbAdapter);

        return [
            new StructureView($this->dbAdapter, $this->dbMeta, $table),
            new RowsView($this->dbAdapter, $this->dbMeta, $table),
        ];
    }

}
