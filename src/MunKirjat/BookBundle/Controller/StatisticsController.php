<?php
namespace MunKirjat\BookBundle\Controller;

use MunKirjat\Component\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class StatisticsController extends Controller
{
    /**
     * @Cache(maxage="86400", expires="tomorrow", public="true")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function statisticsAction()
    {
        $stats = $this->getStatisticsService()->getBookStatistics();

        $this->getCurrentUser();

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
