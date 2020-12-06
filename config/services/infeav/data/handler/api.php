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
    'factories' => [
        \Infeav\Data\Handler\Api\User\AuthenticateHandler::class => \Infeav\Data\Handler\Api\User\AuthenticateHandlerFactory::class,
        \Infeav\Data\Handler\Api\User\SessionHandler::class => \Infeav\Data\Handler\Api\User\SessionHandlerFactory::class,
        \Infeav\Data\Handler\Api\DataFieldsHandler::class => \Infeav\Data\Handler\Api\DataFieldsHandlerFactory::class,
        \Infeav\Data\Handler\Api\DataViewHandler::class => \Infeav\Data\Handler\Api\DataViewHandlerFactory::class,
    ],
];
