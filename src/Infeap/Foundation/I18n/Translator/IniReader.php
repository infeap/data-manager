<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * It is an extension of
 * @see \Laminas\Config\Reader\Ini
 * that disables parse_ini_string()'s value parsing
 *
 * @see       https://github.com/laminas/laminas-config for the canonical source repository
 * @copyright https://github.com/laminas/laminas-config/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-config/blob/master/LICENSE.md New BSD License
 */

namespace Infeap\Foundation\I18n\Translator;

use Laminas\Config\Exception;
use Laminas\Config\Reader\Ini as LaminasIniReader;

class IniReader extends LaminasIniReader
{

    /**
     * fromFile(): defined by Reader interface.
     *
     * @see    ReaderInterface::fromFile()
     * @param  string $filename
     * @return array
     * @throws Exception\RuntimeException
     */
    public function fromFile($filename)
    {
        if (! is_file($filename) || ! is_readable($filename)) {
            throw new Exception\RuntimeException(sprintf(
                "File '%s' doesn't exist or not readable",
                $filename
            ));
        }

        $this->directory = dirname($filename);

        set_error_handler(
            function ($error, $message = '') use ($filename) {
                throw new Exception\RuntimeException(
                    sprintf('Error reading INI file "%s": %s', $filename, $message),
                    $error
                );
            },
            E_WARNING
        );
        $ini = parse_ini_file($filename, $this->getProcessSections(), INI_SCANNER_RAW);
        restore_error_handler();

        return $this->process($ini);
    }

}
