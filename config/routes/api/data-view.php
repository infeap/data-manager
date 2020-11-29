<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

return [
    'api/v1/data-view' => [
        'path' => '/api/v1/data-view',
        'GET' => [
            \Infeav\Data\Handler\Api\DataViewHandler::class,
        ],
    ],
];
