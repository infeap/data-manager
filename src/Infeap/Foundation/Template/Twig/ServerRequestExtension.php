<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Template\Twig;

use Infeap\Foundation\Http\Message\Helper\ServerRequestHelper;
use Infeap\Foundation\Template\ServerRequest as TemplateServerRequest;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ServerRequestExtension extends AbstractExtension
{

    protected $templateServerRequest;

    public function __construct(ServerRequestHelper $requestHelper)
    {
        $this->templateServerRequest = new TemplateServerRequest($requestHelper);
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('server_request', [$this, 'getTemplateServerRequest']),
        ];
    }

    public function getTemplateServerRequest(string $property = null)
    {
        switch ($property) {
            case 'query_params':
                return $this->templateServerRequest->getQueryParams();
            default:
                return $this->templateServerRequest;
        }
    }

}
