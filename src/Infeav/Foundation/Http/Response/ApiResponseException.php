<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Http\Response;

class ApiResponseException extends \RuntimeException
{

    protected array $apiResponseOptions;

    public function __construct(array $apiResponseOptions = [], int $code = 0, \Throwable $previous = null)
    {
        $this->apiResponseOptions = $apiResponseOptions;

        parent::__construct($apiResponseOptions['details']['message'] ?? '', $code, $previous);
    }

    public function getApiResponseOptions(): array
    {
        return $this->apiResponseOptions;
    }

}
