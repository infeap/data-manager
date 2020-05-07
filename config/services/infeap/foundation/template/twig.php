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
    'invokables' => [
        \Infeap\Foundation\Template\Twig\AssetExtension::class => \Infeap\Foundation\Template\Twig\AssetExtension::class,
        \Infeap\Foundation\Template\Twig\StringExtension::class => \Infeap\Foundation\Template\Twig\StringExtension::class,
        \Infeap\Foundation\Template\Twig\TypeExtension::class => \Infeap\Foundation\Template\Twig\TypeExtension::class,
    ],
    'factories' => [
        \Infeap\Foundation\Template\Twig\ServerRequestExtension::class => \Infeap\Foundation\Template\Twig\ServerRequestExtensionFactory::class,
        \Infeap\Foundation\Template\Twig\TranslationExtension::class => \Infeap\Foundation\Template\Twig\TranslationExtensionFactory::class,
    ],
];
