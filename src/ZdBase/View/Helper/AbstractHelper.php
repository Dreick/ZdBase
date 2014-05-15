<?php
namespace ZdBase\View\Helper;

use Zend\View\Helper\AbstractHelper as Helper;
use Zend\ServiceManager\ServiceManager;

class AbstractHelper extends Helper
{
    protected $serviceManager;
    
    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        if(!$this->serviceManager instanceof ServiceManager) {
            $this->setServiceManager($this->getView()->getHelperPluginManager()->getServiceLocator());
        }
        
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $serviceManager
     * @return AbstractHelper
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
}
