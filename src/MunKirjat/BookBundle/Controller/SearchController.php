<?php
namespace MunKirjat\BookBundle\Controller;

use MunKirjat\Component\Controller\Controller;

class SearchController extends Controller
{
    public function searchAction()
    {
        $term = $this->getRequest()->get('term');


    }

    /**
     * @return \MunKirjat\BookBundle\Service\SearchService
     */
    public function getSearchService()
    {
        return $this->get('munkirjat_book.service.search');
    }
}
