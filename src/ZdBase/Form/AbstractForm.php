<?php
namespace ZdBase\Form;

use ZfcBase\Form\ProvidesEventsForm;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AbstractForm extends ProvidesEventsForm implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;
    
    protected $entityManager;
    
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
