<?php
namespace MunKirjat\BookBundle\Repository;

use Doctrine\ORM\AbstractQuery;

use MunKirjat\Component\Repository\BaseRepository;

class GenreRepository extends BaseRepository
{
    /**
     * @return array
     */
    public function getGenres()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('g')
            ->from('MunKirjat\BookBundle\Entity\Genre', 'g')
            ->orderBy('g.name');

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    /**
     * @return int
     */
    public function getGenreCount()
    {
        $qb = $this->getQueryBuilder();

        $qb->select('count(g.id) AS amount')
            ->from('MunKirjat\BookBundle\Entity\Genre', 'g');

        $authors = $qb->getQuery()->getSingleResult();

        return isset($authors['amount']) ? $authors['amount'] : 0;
    }
}
