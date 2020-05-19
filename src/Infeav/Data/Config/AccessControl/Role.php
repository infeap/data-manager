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

class Role
{

    protected array $config;

    public function __construct(array $config)
    {
        if (! static::isValidConfig($config)) {
            throw new \DomainException('Role constructed with invalid config');
        }

        $this->config = $config;
    }

    public static function isValidConfig(array $config)
    {
        if (! (isset($config['name']) && is_string($config['name']))) {
            return false;
        }

        return true;
    }

    public function getName(): string
    {
        return $this->config['name'];
    }

}
