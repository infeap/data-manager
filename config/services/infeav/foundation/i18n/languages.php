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
        \Infeav\Foundation\I18n\LanguageService::class => \Infeav\Foundation\I18n\LanguageServiceFactory::class,
    ],
    'services' => [
        'app_config' => [
            'supported_languages' => [
                'en',
                'de',
            ],
            'fallback_language' => 'en',
        ],
    ],
];
