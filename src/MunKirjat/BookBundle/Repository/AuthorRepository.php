<?php
namespace MunKirjat\BookBundle\Repository;

use Doctrine\ORM\AbstractQuery;

use MunKirjat\Component\Repository\BaseRepository;

class AuthorRepository extends BaseRepository
{
    /**
     * @return array
     */
    public function getAuthors()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a')
            ->from('MunKirjat\BookBundle\Entity\Author', 'a');

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    /**
     * @param int $minBooks the minimum amount of books by an author
     * @param int $limit
     * @return array
     */
    public function getFavouriteAuthors($minBooks = 3, $limit = 20)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('a, count(b.id) as amount')
            ->from('MunKirjat\BookBundle\Entity\Author', 'a')
            ->leftJoin('a.books', 'b')
            ->groupBy('a.id')
            ->orderBy('amount', 'DESC');

        if($minBooks > 0)
        {
            $qb->having('count(b.id) >= :min')
                ->setParameter('min', $minBooks);
        }

        if($limit > 0)
        {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    /**
     * @return int
     */
    public function getAuthorCount()
    {
        $qb = $this->getQueryBuilder();

        $qb->select('count(a.id) AS amount')
            ->from('MunKirjat\BookBundle\Entity\Author', 'a');

        $authors = $qb->getQuery()->getSingleResult();

        return isset($authors['amount']) ? $authors['amount'] : 0;
    }
}
