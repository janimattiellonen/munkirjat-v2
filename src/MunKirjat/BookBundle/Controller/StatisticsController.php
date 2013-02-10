<?php
namespace MunKirjat\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class StatisticsController extends Controller
{
    public function statisticsAction()
    {
        $stats = $this->getStatisticsService()->getBookStatistics();

        $response = new JsonResponse($stats);

        return $response;
    }

    /**
     * @return \MunKirjat\BookBundle\Service\StatisticsService
     */
    protected function getStatisticsService()
    {
        return $this->get('munkirjat_book.service.statistics');
    }
}
