<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\AccessControl\User\UserDataStore;

use Infeav\Data\Config\AccessControl\User\UserData;
use Infeav\Data\Config\AccessControl\User\UserDataStore;

class PlainDataStore extends UserDataStore
{

    protected array $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function getData(?string $key = null, ?string $value = null): ?UserData
    {
        if ($key === null) {
            if ($this->isValidConfig($this->config)) {
                return new UserData($this->config);
            }
        } else {
            if ($this->isValidConfig($this->config)) {
                if (isset($this->config[$key]) && $this->config[$key] === $value) {
                    return new UserData($this->config);
                }
            } else {
                foreach ($this->config as $configKey => $configValue) {
                    if (is_numeric($configKey) && is_array($configValue)) {
                        if (isset($configValue[$key]) && $configValue[$key] === $value) {
                            if ($this->isValidConfig($configValue)) {
                                return new UserData($configValue);
                            }
                        }
                    }
                }
            }
        }

        return null;
    }

    protected function isValidConfig(array $config)
    {
        foreach (array_keys($this->config) as $key) {
            if (is_numeric($key)) {
                return false;
            }
        }

        return true;
    }

}
