<?php
namespace MunKirjat\BookBundle\Controller;

use MunKirjat\Component\Controller\Controller;
use MunKirjat\BookBundle\Entity\Book;

class BookController extends Controller
{
    public function viewAction($id)
    {
        $service    = $this->getBookService();
        $book     = $service->getBook($id);

        return $this->getJsonResponse($book->toArray() );
    }

    /**
     * @return \MunKirjat\BookBundle\Service\BookService
     */
    public function getBookService()
    {
        return $this->get('munkirjat_book.service.book');
    }
}
