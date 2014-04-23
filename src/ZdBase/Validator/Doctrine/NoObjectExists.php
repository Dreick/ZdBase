<?php
namespace ZdBase\Validator\Doctrine;

class NoObjectExists extends ObjectExists
{
    /**
     * Error constants
     */
    const ERROR_OBJECT_FOUND    = 'objectFound';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = array(
        self::ERROR_OBJECT_FOUND    => "An object matching '%value%' was found",
    );

    public function isValid($value)
    {
        $this->setValue($value);
        $query = $this->getQuery()->setMaxResults(1);
        
        if(is_object($query->getOneOrNullResult())) {
            $this->error(self::ERROR_OBJECT_FOUND, $value);
            
            return false;
        }

        return true;
    }
}
