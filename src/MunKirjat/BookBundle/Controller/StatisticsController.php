<?php
namespace MunKirjat\BookBundle\Controller;

use MunKirjat\Component\Controller\Controller;

class StatisticsController extends Controller
{
    public function statisticsAction()
    {
        $stats = $this->getStatisticsService()->getBookStatistics();

        $this->getCurrentUser();

        return $this->getJsonResponse($stats);
    }

    /**
     * @return \MunKirjat\BookBundle\Service\StatisticsService
     */
    protected function getStatisticsService()
    {
        return $this->get('munkirjat_book.service.statistics');
    }
}
