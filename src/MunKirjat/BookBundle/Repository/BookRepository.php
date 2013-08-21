<?php

namespace MunKirjat\BookBundle\Repository;

use Doctrine\ORM\AbstractQuery;

use MunKirjat\Component\Repository\BaseRepository;
use MunKirjat\Component\Utils\Name;
use Xi\Bundle\TagBundle\Entity\Tag;

class BookRepository extends BaseRepository
{
    /**
     * @param int $limit
     * @param int $diff
     * @return mixed
     */
    public function getRecentlyReadBooks($limit = 20, $diff = 183)
    {
        $dateStr = date('Y-m-d H:i:s');

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('b')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->where('b.isRead = 1')
            ->where('b.finishedReading IS NOT NULL')
            ->where('DATEDIFF(:date, b.finishedReading) <= :diff')
            ->setParameter('date', $dateStr)
            ->setparameter('diff', $diff)
            ->orderBy('b.finishedReading', 'DESC')
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
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

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    /**
     * @param array $authorIds
     * @return mixed
     */
    public function findBooksByAuthor($authorIds)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('b')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->join('b.authors', 'a');

        $i = 0;

        foreach((array)$authorIds as $authorId)
        {
            $qb->orWhere('a.id = :author' . $i)
                ->setParameter('author' . $i++, $authorId);
        }

        $qb->orderBy('b.created', 'desc');

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    /**
     * @param Tag $genre
     *
     * @return array
     */
    public function findBooksByGenre(Tag $genre)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('b')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->join('b.authors', 'a');
    }

    /**
     * @param string $title
     * @return array
     */
    public function findBooksByTitle($title)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('b')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->where('b.title LIKE :title')
            ->setParameter('title', '%' . $title . '%');

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function findBooksBy(array $params = array() )
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('b')
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
                    $qb->orWhere('a.firstName LIKE :firstName')
                        ->setParameter('firstBame', '%' . $parts[0] . '%')
                        ->orWhere('a.lastBame LIKE :lastName')
                        ->setParameter('lastName', '%' . $parts[0] . '%');
                }
                else
                {
                    $qb->orWhere('a.firstName LIKE :firstName')
                        ->setParameter('firstName', '%' . $parts[0] . '%')
                        ->orWhere('a.lastName LIKE :lastName')
                        ->setParameter('lastName', '%' . $parts[1] . '%');
                }
            }
        }

        $qb->orderBy('b.title');

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
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

        return $this->getSingleResult($qb, AbstractQuery::HYDRATE_ARRAY);
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

        return $this->getSingleResult($qb, AbstractQuery::HYDRATE_ARRAY);
    }

    /**
     * @return int
     */
    public function getBookCount()
    {
        $qb = $this->getQueryBuilder();

        $qb->select('count(b.id) AS amount')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b');

        $book = $qb->getQuery()->getSingleResult();

        return isset($book['amount']) ? $book['amount'] : 0;
    }

    /**
     * @return int
     */
    public function getUnreadBookCount()
    {
        $qb = $this->getQueryBuilder();

        $qb->select('count(b.id) AS unread_amount')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->where('b.isRead IS NULL OR b.isRead = 0');

        $book = $qb->getQuery()->getSingleResult();

        return isset($book['unread_amount']) ? $book['unread_amount'] : 0;
    }

    /**
     * @return int
     */
    public function getUnratedBookCount()
    {
        $qb = $this->getQueryBuilder();

        $qb->select('count(b.id) AS unrated_amount')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->where('b.rating = 0');

        $book = $qb->getQuery()->getSingleResult();

        return isset($book['unrated_amount']) ? $book['unrated_amount'] : 0;
    }

    /**
     * @return int
     */
    public function getReadPageCount()
    {
        $qb = $this->getQueryBuilder();

        $qb->select('sum(b.pageCount) as page_count')
            ->from('MunKirjat\BookBundle\Entity\Book', 'b')
            ->where('b.isRead = 1');

        $book = $qb->getQuery()->getSingleResult();

        return isset($book['page_count']) ? $book['page_count'] : 0;
    }

    /**
     * @return array
     */
    public function getBookStatistics()
    {
        $stats = array(
            'author_count'          => $this->getAuthorCount(),
            'read_page_count'       => $this->getReadPageCount(),
            'book_count'            => $this->getBookCount(),
            'unread_book_count'     => $this->getUnreadBookCount(),
            'unrated_book_count'    => $this->getUnratedBookCount(),
            'average_pace'          => $this->getAverageBookReadPace(),
            'slowest_pace'          => $this->getSlowestBookReadPace(),
            'fastest_pace'          => $this->getFastestBookReadPace(),
            'average_rating'        => $this->getAverageRating(),
        );

        return $stats;
    }

    /**
     * @param int $date (unix timestamp)
     * @param int $range
     *
     * @return array
     */
    public function getAddedBookCountBetween($date = null, $range = 10)
    {
        $now = time();

        if($range > 6)
        {
            $range = 6;
        }
        else if($range < 1)
        {
            $range = 1;
        }

        if(!isset($date) || $date > $now)
        {
            $startDateStr = date('Y-m-d 00:00:00', strtotime('-' . ($range * 2) . ' months') );
            $endDateStr = date('Y-m-d 23:59:59');
        }
        else
        {
            $startDateStr = date('Y-m-d 00:00:00', strtotime('-' . $range . ' months', $date) );
            $endDateStr = date('Y-m-d 23:59:59', strtotime('+' . $range . ' months', $date) );
        }

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare("SELECT
                  COUNT(*) AS amount,
                  MONTH(created_at) AS month,
                  YEAR(created_at) AS year,
                  UNIX_TIMESTAMP(created_at) * 1000 AS created_at
                FROM
                  book
                WHERE
                  created_at BETWEEN :start AND :end
                GROUP BY
                  MONTH(created_at),
                  YEAR(created_at)
                ORDER BY
                	created_at");

        $stmt->bindValue('start', $startDateStr);
        $stmt->bindValue('end', $endDateStr);

        $stmt->execute();

        $rows = array();

        while($row = $stmt->fetch() )
        {
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * @return float
     */
    public function getAverageBookReadPace()
    {
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare("
		SELECT
          AVG(DATEDIFF(finished_Reading, started_reading)) AS pace
        FROM
          book
        WHERE
          is_read = 1
          AND started_reading IS NOT NULL
          AND finished_reading IS NOT NULL");

        $stmt->execute();

        $row = $stmt->fetch();

        if(isset($row['pace']) )
        {
            return $row['pace'];
        }
    }

    /**
     * @return float
     */
    public function getFastestBookReadPace()
    {
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare("
		SELECT
          MIN(DATEDIFF(finished_Reading, started_reading)) AS pace
        FROM
          book
        WHERE
          is_read = 1
          AND started_reading IS NOT NULL
          AND started_reading > '2000-01-01 00:00:00'
          AND finished_reading IS NOT NULL
          AND finished_reading > '2000-01-01 00:00:00'");

        $stmt->execute();

        $row = $stmt->fetch();

        if(isset($row['pace']) )
        {
            return $row['pace'];
        }
    }

    /**
     * @return float
     */
    public function getSlowestBookReadPace()
    {
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare("
		SELECT
          MAX(DATEDIFF(finished_Reading, started_reading)) AS pace
        FROM
          book
        WHERE
          is_read = 1
          AND started_reading IS NOT NULL
          AND finished_reading IS NOT NULL");

        $stmt->execute();

        $row = $stmt->fetch();

        if(isset($row['pace']) )
        {
            return $row['pace'];
        }
    }

    /**
     * @return double
     */
    public function getAverageRating()
    {
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare("
		SELECT
          AVG(rating) AS rating
        FROM
          book
        WHERE
          rating != 0 && rating IS NOT NULL");

        $stmt->execute();

        $row = $stmt->fetch();

        if(isset($row['rating']) )
        {
            return $row['rating'];
        }
    }

    /**
     * @return double
     */
    public function getBookCountByLanguages()
    {
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare("
		SELECT
          b.language_id,
          count(b.language_id) AS amount
        FROM
          book AS b
        GROUP BY
          b.language_id
        ORDER BY
          b.language_id");

        $stmt->execute();

        $rows = array();

        while($row = $stmt->fetch() )
        {
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * @return array
     */
    public function getActiveGenres()
    {
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare("SELECT
            t.id,
            t.name,
            count(t.id) as amount
        FROM
            xi_tag AS t
            LEFT JOIN xi_tagging AS xt
            ON t.id = xt.tag_id
        WHERE
            xt.resource_type = 'book'
        GROUP BY
            t.name
        ORDER BY
            amount DESC");

        $stmt->execute();

        $rows = array();

        while($row = $stmt->fetch() )
        {
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * @return array
     */
    public function getAverageBookPrice()
    {
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare("SELECT
            COUNT(*) AS amount,
            AVG(price) AS average_price
        FROM
            book
        WHERE
            price > 0");

        $stmt->execute();

        if($row = $stmt->fetch() )
        {
            return $row;
        }

        return array('amount' => 0, 'average_price' => 0);
    }

    /**
     * @return array
     */
    public function getMoneySpentOnBooks()
    {
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare("SELECT
            COUNT(*) AS amount,
            SUM(price) AS book_sum
        FROM
            book
        WHERE
            price > 0");

        $stmt->execute();

        if($row = $stmt->fetch() )
        {
            return $row;
        }

        return array('amount' => 0, 'sum' => 0);
    }
}
