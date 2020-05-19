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

use Infeav\Data\Config\AccessControl\User\UserAuthentication;
use Infeav\Data\Config\AccessControl\User\UserAuthenticationManager;
use Infeav\Data\Config\AccessControl\User\UserDataStore;
use Infeav\Data\Config\AccessControl\User\UserDataStoreManager;
use Infeav\Data\Config\AccessControl\User\UserFilter;
use Infeav\Data\Config\AccessControl\User\UserFilterManager;
use Infeav\Data\Config\AccessControl\User\UserIdentification;
use Infeav\Data\Config\AccessControl\User\UserIdentificationManager;
use Infeav\Data\Config\AccessControl\User\UserSession;
use Infeav\Data\Config\AccessControl\User\UserSessionManager;

class UserProxyManager
{

    protected array $userProxiesConfig;
    protected UserFilterManager $userFilterManager;
    protected UserDataStoreManager $userDataStoreManager;
    protected UserIdentificationManager $userIdentificationManager;
    protected UserAuthenticationManager $userAuthenticationManager;
    protected UserSessionManager $userSessionManager;

    protected ?array $userProxies = null;

    public function __construct(
        array $userProxiesConfig,
        UserFilterManager $userFiltersManager,
        UserDataStoreManager $userDataStoreManager,
        UserIdentificationManager $userIdentificationManager,
        UserAuthenticationManager $userAuthenticationManage,
        UserSessionManager $userSessionManager)
    {
        $this->userProxiesConfig = $userProxiesConfig;
        $this->userFilterManager = $userFiltersManager;
        $this->userDataStoreManager = $userDataStoreManager;
        $this->userIdentificationManager = $userIdentificationManager;
        $this->userAuthenticationManager = $userAuthenticationManage;
        $this->userSessionManager = $userSessionManager;
    }

    public function getUserProxies(): array
    {
        if ($this->userProxies === null) {
            $this->userProxies = [];

            foreach ($this->userProxiesConfig as $userProxyConfig) {
                if (is_array($userProxyConfig)) {

                    /*
                     * Filters
                     */
                    $filters = [];
                    $filtersConfig = $userProxyConfig['filters'] ?? null;

                    if (is_iterable($filtersConfig)) {
                        foreach ($filtersConfig as $filterConfig) {
                            if (is_array($filterConfig)) {
                                $filterType = $filterConfig['type'] ?? null;

                                if ($filterType && $this->userFilterManager->has($filterType)) {
                                    $filterTypeConfig = $filterConfig['config'] ?? null;

                                    if (! is_array($filterTypeConfig)) {
                                        $filterTypeConfig = [];
                                    }

                                    /** @var UserFilter $filter */
                                    $filter = $this->userFilterManager->build($filterType, $filterTypeConfig);

                                    $filters[] = $filter;
                                }
                            }
                        }
                    }

                    /*
                     * Data Store
                     */
                    $dataStore = null;
                    $dataStoreConfig = $userProxyConfig['data_store'] ?? null;

                    if (is_array($dataStoreConfig)) {
                        $dataStoreType = $dataStoreConfig['type'] ?? null;

                        if ($dataStoreType && $this->userDataStoreManager->has($dataStoreType)) {
                            $dataTypeConfig = $dataStoreConfig['config'] ?? null;

                            if (! is_array($dataTypeConfig)) {
                                $dataTypeConfig = [];
                            }

                            /** @var UserDataStore $dataStore */
                            $dataStore = $this->userDataStoreManager->build($dataStoreType, $dataTypeConfig);
                        }
                    }

                    /*
                     * Identification
                     */
                    $identification = null;
                    $identificationConfig = $userProxyConfig['identification'] ?? null;

                    if (is_array($identificationConfig)) {
                        $identificationType = $identificationConfig['type'] ?? null;

                        if ($identificationType && $this->userIdentificationManager->has($identificationType)) {
                            $identificationTypeConfig = $identificationConfig['config'] ?? null;

                            if (! is_array($identificationTypeConfig)) {
                                $identificationTypeConfig = [];
                            }

                            /** @var UserIdentification $identification */
                            $identification = $this->userIdentificationManager->build($identificationType, $identificationTypeConfig);
                        }
                    }

                    /*
                     * Authentication
                     */
                    $authentication = null;
                    $authenticationConfig = $userProxyConfig['authentication'] ?? null;

                    if (is_array($authenticationConfig)) {
                        $authenticationType = $authenticationConfig['type'] ?? null;

                        if ($authenticationType && $this->userAuthenticationManager->has($authenticationType)) {
                            $authenticationTypeConfig = $authenticationConfig['config'] ?? null;

                            if (! is_array($authenticationTypeConfig)) {
                                $authenticationTypeConfig = [];
                            }

                            /** @var UserAuthentication $authentication */
                            $authentication = $this->userAuthenticationManager->build($authenticationType, $authenticationTypeConfig);
                        }
                    }

                    /*
                     * Session
                     */
                    $session = null;
                    $sessionConfig = $userProxyConfig['session'] ?? null;

                    if (is_array($sessionConfig)) {
                        $sessionType = $sessionConfig['type'] ?? null;

                        if ($sessionType && $this->userSessionManager->has($sessionType)) {
                            $sessionTypeConfig = $sessionConfig['config'] ?? null;

                            if (! is_array($sessionTypeConfig)) {
                                $sessionTypeConfig = [];
                            }

                            /** @var UserSession $session */
                            $session = $this->userSessionManager->build($sessionType, $sessionTypeConfig);
                        }
                    }

                    /*
                     * Finally, the Proxy
                     */
                    $userProxy = new UserProxy($filters, $dataStore, $identification, $authentication, $session);

                    $this->userProxies[] = $userProxy;
                }
            }
        }

        return $this->userProxies;
    }

}
