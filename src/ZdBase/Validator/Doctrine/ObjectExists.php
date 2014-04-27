<?php
namespace ZdBase\Validator\Doctrine;

use Traversable;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;
use Zend\Stdlib\ArrayUtils;
use Doctrine\Common\Persistence\ObjectManager;

class ObjectExists extends AbstractValidator
{
    /**
     * Error constants
     */
    const ERROR_NO_OBJECT_FOUND = 'noObjectFound';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = array(
        self::ERROR_NO_OBJECT_FOUND => "No object matching '%value%' was found",
    );
    
    protected $entityManager = null;
    
    protected $targetClass;
    
    protected $field;
    
    protected $exclude = null;

    public function __construct(array $options)
    {
        parent::__construct($options);
        
        if($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }
        
        if(!array_key_exists('entityManager', $options) || !$options['entityManager'] instanceof ObjectManager) {
            if(!array_key_exists('entityManager', $options)) {
                $provided = 'nothing';
            } else {
                if(is_object($options['entityManager'])) {
                    $provided = get_class($options['entityManager']);
                } else {
                    $provided = getType($options['entityManager']);
                }
            }

            throw new Exception\InvalidArgumentException(
                sprintf(
                    'Option "entityManager" is required and must be an instance of'
                    . ' Doctrine\Common\Persistence\ObjectManager, %s given',
                    $provided
                )
            );
        }
        
        if(!array_key_exists('targetClass', $options)) {
            throw new Exception\InvalidArgumentException('Option "targetClass" is required!');
        }
        
        if(!array_key_exists('field', $options)) {
            throw new Exception\InvalidArgumentException('Option "field" is required!');
        }
    }
    
    public function setEntityManager(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
 
        return $this;
    }
 
    public function getEntityManager()
    {
        return $this->entityManager;
    }
    
    public function setTargetClass($targetClass)
    {
        $this->targetClass = (string) $targetClass;
 
        return $this;
    }
 
    public function getTargetClass()
    {
        return $this->targetClass;
    }
    
    public function setField($field)
    {
        $this->field = (string) $field;
 
        return $this;
    }
 
    public function getField()
    {
        return $this->field;
    }
    
    public function setExclude($exclude)
    {
        if(is_array($exclude)) {
            if(array_key_exists('field', $exclude) && array_key_exists('value', $exclude)) {
                $this->exclude[] = array(
                    'field' => $exclude['field'],
                    'value' => $exclude['value']
                );
            } else {
                $this->exclude = $exclude;
            }
        }
 
        return $this;
    }
 
    public function getExclude()
    {
        return $this->exclude;
    }
    
    public function getQuery()
    {
        $repository   = $this->getEntityManager()->getRepository($this->getTargetClass());
        $queryBuilder = $repository->createQueryBuilder('u');
        $queryBuilder->where('u.' . $this->getField() . ' = :value');
        $queryBuilder->setParameter(':value', $this->getValue());
        
        if($this->exclude !== null) {
            if(is_array($this->exclude)) {
                foreach($this->exclude as $i => $exc) {
                    if($exc['value'] !== null) {
                        $queryBuilder->andWhere('u.' . $exc['field'] . ' != :exclude_' . $i);
                        $queryBuilder->setParameter('exclude_' . $i, $exc['value']);
                    }
                }
            }
        }
        
        return $queryBuilder->getQuery();
    }

    public function isValid($value)
    {
        $this->setValue($value);
        $query = $this->getQuery()->setMaxResults(1);
        
        if(is_object($query->getOneOrNullResult())) {
            return true;
        }
        
        $this->error(self::ERROR_NO_OBJECT_FOUND, $value);

        return false;
    }
}
