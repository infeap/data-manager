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

use Infeav\Data\Config\DataView;
use Laminas\Db\Adapter\Adapter as DbAdapter;
use Laminas\Db\Metadata\MetadataInterface;

class TablesView extends DataView
{

    protected DbAdapter $dbAdapter;
    protected MetadataInterface $dbMeta;

    public function __construct(DbAdapter $dbAdapter, MetadataInterface $dbMeta)
    {
        $this->dbAdapter = $dbAdapter;
        $this->dbMeta = $dbMeta;

        $this->setMeta([
            'name' => 'trans:data_views.db.tables.label',
        ]);
    }

    public function assembleChildDataViews(): array
    {
        $childDataViews = [];

        foreach ($this->dbMeta->getTableNames() as $tableName) {
            $childDataViews[] = new TableView($this->dbAdapter, $this->dbMeta, $tableName);
        }

        return $childDataViews;
    }

}
