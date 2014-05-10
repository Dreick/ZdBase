<?php
namespace ZdBase;
 
return array(    
    /**
     * Doctrine
     */
    'doctrine' => array(
        'configuration' => array(
            'orm_default' => array(
                'string_functions' => array(
                    'MATCH_AGAINST' => 'ZdBase\Extension\Doctrine\MatchAgainst',
                ),
            ),
        ),
    ),
);
