<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

/*
 * See init/app-array.php for available $app keys
 */
return function (array $app): array {

    $config = [
        'factories' => [
            \Infeav\Foundation\I18n\Translator::class => \Infeav\Foundation\I18n\TranslatorFactory::class,
        ],
        'services' => [
            'app_config' => [
                'l10n_dir' => $app['dir'] . '/resources/l10n',
                'l10n_files' => [],
            ],
        ],
    ];

    $languagesConfig = include 'languages.php';

    if (is_callable($languagesConfig)) {
        $languagesConfig = $languagesConfig($app);
    }

    if (is_array($languagesConfig)) {
        $l10nDir = $config['services']['app_config']['l10n_dir'];

        $scanLanguageTag =
            $languagesConfig['services']['app_config']['fallback_language'] ??
                ($languagesConfig['services']['app_config']['supported_languages'][0] ?? null);

        $scanLanguageDir = $l10nDir . '/' . $scanLanguageTag;

        if (is_dir($scanLanguageDir) && is_readable($scanLanguageDir)) {
            foreach (new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($scanLanguageDir,
                FilesystemIterator::CURRENT_AS_PATHNAME | FilesystemIterator::SKIP_DOTS)) as $iteratedFile) {

                if (str_ends_with($iteratedFile, '.ini')) {
                    $normalizedIteratedFile = strtr($iteratedFile, [
                        DIRECTORY_SEPARATOR => '/',
                    ]);

                    $relativeIteratedFile = substr($normalizedIteratedFile, strlen($scanLanguageDir) + 1);

                    $config['services']['app_config']['l10n_files'][] = $relativeIteratedFile;
                }
            }
        }
    }

    return $config;
};
