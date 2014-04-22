<?php
namespace ZdBase\Module;

use Zend\ModuleManager\Feature;
use ZfcBase\Module\AbstractModule as ZfcBaseAbstractModule;

abstract class AbstractModule extends ZfcBaseAbstractModule implements
    Feature\ServiceProviderInterface,
    Feature\ViewHelperProviderInterface,
    Feature\ConfigProviderInterface,
    Feature\ControllerProviderInterface,
    Feature\ControllerPluginProviderInterface,
    Feature\FormElementProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                $this->getDir() . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    $this->getNamespace()           => $this->getDir() . '/src/' . $this->getNamespace(),
                    $this->getNamespace() . 'Admin' => $this->getDir() . '/src/' . $this->getNamespace() . 'Admin',
                ),
            ),
        );
    }

    public function getConfig()
    {
        $config      = array();
        $configFiles = array(
            'module.config.php',
            'routes.config.php',
            'navigation.config.php',
        );
        foreach ($configFiles as $configFile) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include $this->getDir() . '/config/' . $configFile);
        }

        return $config;
    }

    public function getServiceConfig()
    {
        return include $this->getDir() . '/config/services.config.php';
    }

    public function getViewHelperConfig()
    {
        return include $this->getDir() . '/config/view-helpers.config.php';
    }

    public function getControllerConfig()
    {
        return include $this->getDir() . '/config/controllers.config.php';
    }
    
    public function getControllerPluginConfig()
    {
        return include $this->getDir() . '/config/controller-plugins.config.php';
    }

    public function getFormElementConfig()
    {
        return include $this->getDir() . '/config/form-elements.config.php';
    }
}
