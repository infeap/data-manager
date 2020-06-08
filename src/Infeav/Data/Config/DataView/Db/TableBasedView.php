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

use Infeav\Data\Config\DataView\DbBasedView;
use Laminas\Db\Adapter\Adapter as DbAdapter;
use Laminas\Db\Metadata\MetadataInterface;
use Laminas\Db\TableGateway\TableGateway;

abstract class TableBasedView extends DbBasedView
{

    protected TableGateway $table;

    public function __construct(DbAdapter $dbAdapter, MetadataInterface $dbMeta, TableGateway $table)
    {
        parent::__construct($dbAdapter, $dbMeta);

        $this->table = $table;
    }

}
