<?php
namespace MunKirjat\BookBundle\Controller;

use MunKirjat\Component\Controller\Controller;

class StatisticsController extends Controller
{
    public function statisticsAction()
    {
        $stats = $this->getStatisticsService()->getBookStatistics();

        return $this->getJsonResponse($stats);
    }

    public function chartsAction()
    {
        $stats = $this->getStatisticsService()->getCharts();

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
