<?php
namespace MunKirjat\BookBundle\Service;

use Doctrine\ORM\EntityManager;

use MunKirjat\BookBundle\Repository\BookRepository;

class StatisticsService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var \MunKirjat\BookBundle\Repository\BookRepository
     */
    protected $bookRepository;

    /**
     * @param EntityManager     $em
     * @param BookRepository    $bookRepository
     */
    public function __construct(EntityManager $em, BookRepository $bookRepository)
    {
        $this->em               = $em;
        $this->bookRepository   = $bookRepository;
    }

    /**
     * Groups several book statistics.
     *
     * @return array
     */
    public function getBookStatistics()
    {
        $stats = array(
            'latest_read_book'              => $this->bookRepository->getLatestReadBook(),
            'latest_added_book'             => $this->bookRepository->getLatestReadBook(),
            'author_count'                  => $this->bookRepository->getAuthorCount(),
            'read_page_count'               => $this->bookRepository->getReadPageCount(),
            'book_count'                    => $this->bookRepository->getBookCount(),
            'unread_book_count'             => $this->bookRepository->getUnreadBookCount(),
            'unrated_book_count'            => $this->bookRepository->getUnratedBookCount(),
            'average_pace'                  => $this->bookRepository->getAverageBookReadPace(),
            'slowest_pace'                  => $this->bookRepository->getSlowestBookReadPace(),
            'fastest_pace'                  => $this->bookRepository->getFastestBookReadPace(),
            'average_rating'                => $this->bookRepository->getAverageRating(),
            'estimated_time_to_read_all'    => $this->getEstimatedTimeToReadAllUnreadBooks(),
        );

        return $stats;
    }

    /**
     * @return double
     */
    protected function getEstimatedTimeToReadAllUnreadBooks()
    {
        $pace       = (double)$this->bookRepository->getAverageBookReadPace();
        $amount     = (int)$this->bookRepository->getUnreadBookCount();
        $timeLeft   = round($amount  * $pace, 2);

        return round($timeLeft / 365, 2);
    }
}
