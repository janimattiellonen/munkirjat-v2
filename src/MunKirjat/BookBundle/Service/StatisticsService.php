<?php
namespace MunKirjat\BookBundle\Service;

use Doctrine\ORM\EntityManager;

use MunKirjat\BookBundle\Service\AuthorService;
use MunKirjat\BookBundle\Service\BookService;

class StatisticsService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var BookService
     */
    protected $bookService;

    /**
     * @var AuthorService
     */
    protected $authorService;

    /**
     * @param EntityManager $em
     * @param BookService   $bookService
     * @param AuthorService $authorService
     */
    public function __construct(EntityManager $em, BookService $bookService, AuthorService $authorService)
    {
        $this->em               = $em;
        $this->bookService      = $bookService;
        $this->authorService    = $authorService;
    }

    /**
     * Groups several book statistics.
     *
     * @return array
     */
    public function getBookStatistics()
    {
        $stats = array(
            'latest_read_book'              => $this->bookService->getLatestReadBook(),
            'latest_added_book'             => $this->bookService->getLatestAddedBook(),
            'author_count'                  => $this->authorService->getAuthorCount(),
            'read_page_count'               => $this->bookService->getReadPageCount(),
            'book_count'                    => $this->bookService->getBookCount(),
            'unread_book_count'             => $this->bookService->getUnreadBookCount(),
            'unrated_book_count'            => $this->bookService->getUnratedBookCount(),
            'average_pace'                  => $this->bookService->getAverageBookReadPace(),
            'slowest_pace'                  => $this->bookService->getSlowestBookReadPace(),
            'fastest_pace'                  => $this->bookService->getFastestBookReadPace(),
            'average_rating'                => $this->bookService->getAverageRating(),
            'estimated_time_to_read_all'    => $this->getEstimatedTimeToReadAllUnreadBooks(),
            'favourite_authors'             => $this->authorService->getFavouriteAuthors(1, 10),
            'recently_read'                 => $this->bookService->getRecentlyReadBooks(10),
            'unread_books'                  => $this->bookService->getUnreadBooks(10),
        );

        return $stats;
    }

    public function getCharts()
    {
        $stats = array(
            'genres' => $this->bookService->getActiveGenres(),
            'books_by_languages' => $this->bookService->getBookCountByLanguages(),
        );

        return $stats;

        // hakee kirjojen lukumäärän kielen mukaan
        // SELECT language_id, count(language_id) FROM `book` GROUP BY language_id

        // hakee kirjojen lukumäärän genren mukaan

        /*
         SELECT
            t.name,
            count(xt.tag_id)
        FROM
            xi_tag AS t
            LEFT JOIN xi_tagging AS xt ON t.id = tag_id
        GROUP BY
            xt.tag_id
         */
    }

    /**
     * @return double
     */
    protected function getEstimatedTimeToReadAllUnreadBooks()
    {
        $pace       = (double)$this->bookService->getAverageBookReadPace();
        $amount     = (int)$this->bookService->getUnreadBookCount();
        $timeLeft   = round($amount  * $pace, 2);

        return round($timeLeft / 365, 2);
    }
}
