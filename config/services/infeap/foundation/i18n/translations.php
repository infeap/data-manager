<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

/*
 * See init/app-array.php for available $app keys
 */
return function (array $app): array {

    $config = [
        'factories' => [
            \Infeap\Foundation\I18n\Translator::class => \Infeap\Foundation\I18n\TranslatorFactory::class,
        ],
        'services' => [
            'app_config' => [
                'l10n_dir' => $app['dir'] . '/resources/l10n/',
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
        $fallbackLanguage = $languagesConfig['services']['app_config']['fallback_language'];

        $languageDir = $l10nDir . $fallbackLanguage . DIRECTORY_SEPARATOR;

        if (is_dir($languageDir)) {
            foreach (new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($languageDir,
                FilesystemIterator::CURRENT_AS_PATHNAME | FilesystemIterator::SKIP_DOTS)) as $iteratedFile) {

                if (preg_match('~\.ini$~', $iteratedFile)) {
                    $relativeIteratedFile = str_replace($languageDir, '', $iteratedFile);

                    $config['services']['app_config']['l10n_files'][] = $relativeIteratedFile;
                }
            }
        }
    }

    return $config;
};
