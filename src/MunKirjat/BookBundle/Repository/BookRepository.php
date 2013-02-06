<?php

namespace MunKirjat\BookBundle\Repository;

use MunKirjat\Component\Repository\BaseRepository;
use MunKirjat\Component\Utils\Name;

class BookRepository extends BaseRepository
{
    /**
     * @param int $diff
     * @param int $limit
     * @return mixed
     */
    public function getRecentlyReadBooks($diff = 183, $limit = 20)
    {
        $dateStr = date('Y-m-d H:i:s');

        $qb = $this->getEntityManager()->createQueryBuilder();

        $q = $qb->select('b')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->where('b.isRead = 1')
            ->where('b.finishedReading IS NOT NULL')
            ->where('DATEDIFF(:date, b.finishedReading) <= :diff')
            ->setParameter('date', $dateStr)
            ->setparameter('diff', $diff)
            ->orderBy('b.finishedReading', 'DESC')
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getUnreadBooks($limit = 20)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('b')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->where('b.isRead != 1')
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $authorIds
     * @return mixed
     */
    public function findBooksByAuthor($authorIds)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('b')
            ->addSelect('SIZE(a.books) as amount')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->join('b.authors', 'a');

        $i = 0;
        foreach((array)$authorIds as $authorId)
        {
            $qb->orWhere('a.id = :author' . $i)
                ->setParameter('author' . $i++, $authorId);
        }
        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function findBooksBy(array $params = array() )
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('b')
            ->addSelect('SIZE(a.books) as amount')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->leftJoin('b.authors', 'a');

        if(isset($params['read']) )
        {
            $qb->andWhere('b.isRead = :read')
                ->setParameter('read', $params['read']);
        }

        if(isset($params['rated']) )
        {
            if($params['rated'] == 0)
            {
                $qb->andWhere('b.rating = 0')
                    ->andWhere('b.isRead = 1');
            }
            else
            {
                $qb->andWhere('b.rating != 0');
            }
        }

        if(isset($params['search']) )
        {
            $value = $params['search'];

            $qb->where('b.title LIKE :title')
                ->setParameter('title', '%' . $value . '%');

            $parts = Name::splitName($value);

            if($parts)
            {
                if(count($parts) == 1)
                {
                    $qb->orWhere('a.firstname LIKE :firstname')
                        ->setParameter('firstname', '%' . $parts[0] . '%')
                        ->orWhere('a.lastname LIKE :lastname')
                        ->setParameter('lastname', '%' . $parts[0] . '%');
                }
                else
                {
                    $qb->orWhere('a.firstname LIKE :firstname')
                        ->setParameter('firstname', '%' . $parts[0] . '%')
                        ->orWhere('a.lastname LIKE :lastname')
                        ->setParameter('lastname', '%' . $parts[1] . '%');
                }
            }
        }

        $qb->orderBy('a.lastname, a.firstname, b.title');

        return $qb->getQuery()->getResult();
    }

    /**
     * @return mixed|null
     */
    public function getOneUnratedBook()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('b')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->where('b.rating = 0')
            ->andWhere('b.isRead = 1')
            ->setMaxResults(1);

        return $this->getSingleResult($qb);
    }

    /**
     * @return \MunKirjat\BookBundle\Entity\Book|null
     */
    public function getLatestReadBook()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('b')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->where('b.isRead = 1')
            ->orderBy('b.finishedReading', 'DESC')
            ->setMaxResults(1);

        return $this->getSingleResult($qb);
    }

    /**
     * @return \MunKirjat\BookBundle\Entity\Book
     */
    public function getLatestAddedBook()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('b')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->orderBy('b.created', 'DESC')
            ->setMaxResults(1);

        return $this->getSingleResult($qb);
    }
}
