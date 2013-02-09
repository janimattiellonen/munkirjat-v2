<?php
namespace MunKirjat\BookBundle\Service;

use MunKirjat\BookBundle\Repository\StatisticsRepository;

class StatisticsService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var \MunKirjat\BookBundle\Repository\StatisticsRepository
     */
    protected $statisticsRepository;

    /**
     * @param EntityManager             $em
     * @param StatisticsRepository      $statisticsRepository
     */
    public function __construct(EntityManager $em, StatisticsRepository $statisticsRepository)
    {
        $this->em                       = $em;
        $this->statisticsRepository     = $statisticsRepository;
    }

    /**
     * Groups several book statistics.
     *
     * @return array
     */
    public function getBookStatistics()
    {
        $stats = array(
            'author_count'                  => $this->statisticsRepository->getAuthorCount(),
            'read_page_count'               => $this->statisticsRepository->getReadPageCount(),
            'book_count'                    => $this->statisticsRepository->getBookCount(),
            'unread_book_count'             => $this->statisticsRepository->getUnreadBookCount(),
            'unrated_book_count'            => $this->statisticsRepository->getUnratedBookCount(),
            'average_pace'                  => $this->statisticsRepository->getAverageBookReadPace(),
            'slowest_pace'                  => $this->statisticsRepository->getSlowestBookReadPace(),
            'fastest_pace'                  => $this->statisticsRepository->getFastestBookReadPace(),
            'average_rating'                => $this->statisticsRepository->getAverageRating(),
            'estimated_time_to_read_all'    => $this->getEstimatedTimeToReadAllUnreadBooks(),
        );

        return $stats;
    }

    /**
     * @return double
     */
    protected function getEstimatedTimeToReadAllUnreadBooks()
    {
        $pace       = (double)$this->statisticsRepository->getAverageBookReadPace();
        $amount     = (int)$this->statisticsRepository->getUnreadBookCount();
        $timeLeft   = round($amount  * $pace, 2);

        return round($timeLeft / 365, 2);
    }
}
