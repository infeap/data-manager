<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Middleware\Page;

use Infeav\Foundation\Http\Response\BasicMessageResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BasicMessageMiddleware implements MiddlewareInterface
{

    protected $template;

    public function __construct(TemplateRendererInterface $templateRenderer)
    {
        $this->template = $templateRenderer;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if ($response instanceof BasicMessageResponse) {
            $response = new HtmlResponse(
                $this->template->render('page::basic-message', [
                    'message' => [
                        'heading' => $response->getHeading(),
                        'descriptionLines' => $response->getDescriptionLines(),
                        'type' => $response->getType(),
                    ],
                ]),
                $response->getStatusCode(),
                $response->getHeaders(),
            );
        }

        return $response;
    }

}
