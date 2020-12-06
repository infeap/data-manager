<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataSource\Db;

use Infeav\Data\Config\DataSource\DbSource;
use Infeav\Data\Config\DataView\Db\TablesView;
use Laminas\Db\Adapter\Adapter as DbAdapter;
use Laminas\Db\Metadata\MetadataInterface;

abstract class LaminasDbSource extends DbSource
{

    public function __construct(
        protected DbAdapter $dbAdapter,
        protected MetadataInterface $dbMeta,
    ) { }

    public function getDbAdapter(): DbAdapter
    {
        return $this->dbAdapter;
    }

    public function getDbMeta(): MetadataInterface
    {
        return $this->dbMeta;
    }

    public function assembleSubViews(): array
    {
        return [
            new TablesView($this->dbAdapter, $this->dbMeta),
        ];
    }

}
