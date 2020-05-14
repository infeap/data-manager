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
    'invokables' => [
        \Infeav\Foundation\Template\Twig\AssetExtension::class => \Infeav\Foundation\Template\Twig\AssetExtension::class,
        \Infeav\Foundation\Template\Twig\StringExtension::class => \Infeav\Foundation\Template\Twig\StringExtension::class,
        \Infeav\Foundation\Template\Twig\TypeExtension::class => \Infeav\Foundation\Template\Twig\TypeExtension::class,
    ],
    'factories' => [
        \Infeav\Foundation\Template\Twig\ServerRequestExtension::class => \Infeav\Foundation\Template\Twig\ServerRequestExtensionFactory::class,
        \Infeav\Foundation\Template\Twig\TranslationExtension::class => \Infeav\Foundation\Template\Twig\TranslationExtensionFactory::class,
    ],
];
