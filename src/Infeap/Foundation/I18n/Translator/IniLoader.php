<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * It is a modified version of
 * @see \Laminas\I18n\Translator\Loader\Ini
 *
 * @see       https://github.com/laminas/laminas-i18n for the canonical source repository
 * @copyright https://github.com/laminas/laminas-i18n/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-i18n/blob/master/LICENSE.md New BSD License
 */

namespace Infeap\Foundation\I18n\Translator;

use Laminas\I18n\Exception;
use Laminas\I18n\Translator\Loader\AbstractFileLoader;
use Laminas\I18n\Translator\TextDomain;

class IniLoader extends AbstractFileLoader
{

    /**
     * load(): defined by FileLoaderInterface.
     *
     * @see    FileLoaderInterface::load()
     * @param  string $locale
     * @param  string $filename
     * @return TextDomain
     * @throws Exception\InvalidArgumentException
     */
    public function load($locale, $filename)
    {
        $resolvedIncludePath = stream_resolve_include_path($filename);
        $fromIncludePath = ($resolvedIncludePath !== false) ? $resolvedIncludePath : $filename;
        if (! $fromIncludePath || ! is_file($fromIncludePath) || ! is_readable($fromIncludePath)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Could not find or open file %s for reading',
                $filename
            ));
        }

        $iniReader = new IniReader();

        /*
         * Infeap modifications:
         * - Do not nest INI keys by (default) dots
         * - Streamline translation message mapping
         */

        $iniReader->setNestSeparator('/');
        $iniReader->setProcessSections(false);

        $messages = $iniReader->fromFile($fromIncludePath);

        $textDomain = new TextDomain($messages);

        return $textDomain;
    }

}
