<?php
namespace MunKirjat\BookBundle\Controller;

use MunKirjat\Component\Controller\Controller;

class SearchController extends Controller
{
    public function searchAction()
    {
        $term = $this->getRequest()->get('term');
        $languages = $this->getRequest()->get('languages', array());

        return $this->getJsonResponse($this->getSearchService()->searchByTerm($term, $languages) );
    }

    /**
     * @return \MunKirjat\BookBundle\Service\SearchService
     */
    public function getSearchService()
    {
        return $this->get('munkirjat_book.service.search');
    }
}
