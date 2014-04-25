<?php
namespace ZdBase\Repository;

use Zend\Paginator\Paginator;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;

class AbstractRepository extends EntityRepository
{
    public function findAllPaginated($page = 1, $limit =10)
    {
        $queryBuilder = $this->createQueryBuilder('a');
        
        $paginator = $this->getPaginator($queryBuilder->getQuery(), false);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($limit);
        
        return $paginator;
    }
    
    public function getPaginator(Query $query, $fetchJoinCollection = true)
    {
        $paginator = new ORMPaginator($query, $fetchJoinCollection);
        $adapter   = new DoctrinePaginator($paginator);

        return new Paginator($adapter);
    }
}
