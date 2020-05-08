<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * It is a copy of
 * @see \Mezzio\Container\ErrorResponseGeneratorFactory
 * that instantiates an ErrorResponseGenerator from the Infeav namespace
 *
 * @see       https://github.com/mezzio/mezzio for the canonical source repository
 * @copyright https://github.com/mezzio/mezzio/blob/master/COPYRIGHT.md
 * @license   https://github.com/mezzio/mezzio/blob/master/LICENSE.md New BSD License
 */

namespace Infeav\Foundation\Middleware\Page;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

use function array_key_exists;

class ErrorResponseGeneratorFactory
{

    public function __invoke(ContainerInterface $container) : ErrorResponseGenerator
    {
        $config = $container->has('config') ? $container->get('config') : [];

        $debug = $config['debug'] ?? false;

        $errorHandlerConfig = $config['mezzio']['error_handler'] ?? [];

        $template = $errorHandlerConfig['template_error'] ?? ErrorResponseGenerator::TEMPLATE_DEFAULT;
        $layout   = array_key_exists('layout', $errorHandlerConfig)
            ? (string) $errorHandlerConfig['layout']
            : ErrorResponseGenerator::LAYOUT_DEFAULT;

        $renderer = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : ($container->has(\Zend\Expressive\Template\TemplateRendererInterface::class)
                ? $container->get(\Zend\Expressive\Template\TemplateRendererInterface::class)
                : null);

        return new ErrorResponseGenerator($debug, $renderer, $template, $layout);
    }

}
