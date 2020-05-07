<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * It is a modified version of
 * @see \Mezzio\Middleware\ErrorResponseGenerator
 *
 * @see       https://github.com/mezzio/mezzio for the canonical source repository
 * @copyright https://github.com/mezzio/mezzio/blob/master/COPYRIGHT.md
 * @license   https://github.com/mezzio/mezzio/blob/master/LICENSE.md New BSD License
 */

namespace Infeap\Foundation\Middleware\Page;

use Laminas\Stratigility\Utils;
use Mezzio\Response\ErrorResponseGeneratorTrait;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class ErrorResponseGenerator
{
    use ErrorResponseGeneratorTrait;

    public const TEMPLATE_DEFAULT = 'error::error';
    public const LAYOUT_DEFAULT = 'layout::default';

    /**
     * @todo Allow nullable $layout
     */
    public function __construct(
        bool $isDevelopmentMode = false,
        TemplateRendererInterface $renderer = null,
        string $template = self::TEMPLATE_DEFAULT,
        string $layout = self::LAYOUT_DEFAULT
    ) {
        $this->debug     = $isDevelopmentMode;
        $this->renderer  = $renderer;
        $this->template  = $template;
        $this->layout    = $layout;
    }

    public function __invoke(
        Throwable $e,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) : ResponseInterface {
        $response = $response->withStatus(Utils::getStatusCode($e, $response));

        /*
         * Infeap modifications:
         * - Add (sufficiently) unique error ID to response headers and template
         */
        $errorId = uniqid();

        $response = $response->withHeader('Inf-Error-ID', $errorId);

        if ($this->renderer) {
            return $this->prepareTemplatedResponse(
                $e,
                $this->renderer,
                [
                    'error_id' => $errorId,

                    'response' => $response,
                    'request'  => $request,
                    'uri'      => (string) $request->getUri(),
                    'status'   => $response->getStatusCode(),
                    'reason'   => $response->getReasonPhrase(),
                    'layout'   => $this->layout,
                ],
                $this->debug,
                $response
            );
        }

        return $this->prepareDefaultResponse($e, $this->debug, $response);
    }

}
