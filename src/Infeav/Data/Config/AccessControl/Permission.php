<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\AccessControl;

class Permission
{

    protected array $config;

    public function __construct(array $config)
    {
        if (! static::isValidConfig($config)) {
            throw new \DomainException('Permission constructed with invalid config');
        }

        $this->config = $config;
    }

    public static function isValidConfig(array $config): bool
    {
        if (! (isset($config['data_source']) && is_string($config['data_source']))) {
            return false;
        }

        if (! (isset($config['type']) && is_string($config['type']))) {
            return false;
        }

        if (! in_array($config['type'], ['read', 'create', 'edit', 'delete'])) {
            return false;
        }

        if (! (isset($config['role']) && is_string($config['role']))) {
            return false;
        }

        return true;
    }

    public function getDataSource(): string
    {
        return $this->config['data_source'];
    }

    public function getType(): string
    {
        return $this->config['type'];
    }

    public function getRole(): string
    {
        return $this->config['role'];
    }

}
