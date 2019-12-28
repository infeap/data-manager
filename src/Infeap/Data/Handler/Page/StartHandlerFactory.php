<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Data\Handler\Page;

use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\ServiceManager\ServiceManager;

class StartHandlerFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        return new StartHandler(
            $serviceManager->get(TemplateRendererInterface::class));
    }

}
