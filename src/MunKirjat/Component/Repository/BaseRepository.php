<?php
namespace MunKirjat\Component\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

class BaseRepository extends EntityRepository
{
    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @return mixed|null
     */
    public function getSingleResult(QueryBuilder $qb)
    {
        try
        {
            return $qb->getQuery()->getSingleResult();
        }
        catch(NoResultException $nre)
        {
            return null;
        }
    }
}
