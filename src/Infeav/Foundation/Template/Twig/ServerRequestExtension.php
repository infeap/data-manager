<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Template\Twig;

use Infeav\Foundation\Http\Request\Helper\ServerRequestHelper;
use Infeav\Foundation\Template\ServerRequest as TemplateServerRequest;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ServerRequestExtension extends AbstractExtension
{

    protected TemplateServerRequest $templateServerRequest;

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

    public function getTemplateServerRequest(?string $property = null)
    {
        switch ($property) {
            case 'query_params':
                return $this->templateServerRequest->getQueryParams();
            default:
                return $this->templateServerRequest;
        }
    }

}
