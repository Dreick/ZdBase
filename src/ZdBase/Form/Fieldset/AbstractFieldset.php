<?php
namespace ZdBase\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

abstract class AbstractFieldset extends Fieldset implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;
    
    protected $entityManager;
    
    abstract public function init();
    
    public function setDoctrineHydrator($classEntity)
    {
        $this->setHydrator(new DoctrineHydrator($this->getEntityManager(), $classEntity));
        
        return $this;
    }
    
    public function setServiceLocator(ServiceLocatorInterface $sl)
    {
        $this->serviceLocator = $sl->getServiceLocator();
        
        return $this;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    
    public function setEntityManager(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
 
        return $this;
    }
 
    public function getEntityManager()
    {
        if(!$this->entityManager instanceof ObjectManager) {
            $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        }
        
        return $this->entityManager;
    }
}
