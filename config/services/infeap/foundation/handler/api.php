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
    'factories' => [
        \Infeap\Foundation\Handler\Api\AuthHandler::class => \Infeap\Foundation\Handler\Api\AuthHandlerFactory::class,
        \Infeap\Foundation\Handler\Api\TranslationsHandler::class => \Infeap\Foundation\Handler\Api\TranslationsHandlerFactory::class,
    ],
];
