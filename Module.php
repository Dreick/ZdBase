<?php
namespace ZdBase;

use Zend\ModuleManager\Feature;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\ServiceProviderInterface
{
    public function init()
    {
        $namespace = 'Gedmo\Mapping\Annotation';
        $lib       = 'vendor/gedmo/doctrine-extensions/lib';
        
        AnnotationRegistry::registerAutoloadNamespace($namespace, $lib);
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/services.config.php';
    }
}
