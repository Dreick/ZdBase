<?php
namespace ZdBase\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Выводит текщий роутер
 */
class getRoute extends AbstractHelper
{
    public function __invoke()
    {
        $serviceManager = $this->getView()->getHelperPluginManager()->getServiceLocator();
        $routeMatch     = $serviceManager->get('Application')->getMvcEvent()->getRouteMatch();
        
        return $routeMatch->getMatchedRouteName();
    }
}
