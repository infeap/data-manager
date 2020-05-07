<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

return [
    'api/v1/translations' => [
        'path' => '/api/v1/translations/{language-tag}/{text-domain}',
        'get' => [
            \Infeap\Foundation\Handler\Api\TranslationsHandler::class,
        ],
    ],
];
