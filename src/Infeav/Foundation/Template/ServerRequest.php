<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Template;

use Infeav\Foundation\Http\Request\Helper\ServerRequestHelper;

class ServerRequest
{

    protected $requestHelper;

    public function __construct(ServerRequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function getQueryParams(): array
    {
        if ($this->requestHelper->getRequest()) {
            return $this->requestHelper->getRequest()->getQueryParams();
        } else {
            return [];
        }
    }

}
