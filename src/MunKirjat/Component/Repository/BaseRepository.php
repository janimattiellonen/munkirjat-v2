<?php
namespace MunKirjat\Component\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;



class BaseRepository extends EntityRepository
{
    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param int $hydrationMode
     * @return mixed|null
     */
    public function getSingleResult(QueryBuilder $qb, $hydrationMode = AbstractQuery::HYDRATE_OBJECT)
    {
        try
        {
            return $qb->getQuery()->getSingleResult($hydrationMode);
        }
        catch(NoResultException $nre)
        {
            return null;
        }
    }
}
