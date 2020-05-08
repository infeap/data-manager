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
        \Infeav\Foundation\Middleware\Error\Logging\Listener::class => \Infeav\Foundation\Middleware\Error\Logging\ListenerFactory::class,
    ],
    'delegators' => [
        \Infeav\Foundation\Middleware\Page\ErrorHandler::class => [
            \Infeav\Foundation\Middleware\Error\Logging\ListenerDelegatorFactory::class,
        ],
    ],
];
