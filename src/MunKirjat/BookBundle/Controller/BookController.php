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

    public function createAction()
    {

    }

    public function updateAction($id)
    {
        $service    = $this->getBookService();
        $book       = $service->getBook($id);
        $form       = $service->getBookForm($book);
        $self       = $this;

        return $this->processForm($form, function() use($form, $service, $self) {

                $book = $service->saveByForm($form);

                return $self->createJsonSuccessResponse(array('id' => $book->getId() ) );
            }
        );
    }

    /**
     * @return \MunKirjat\BookBundle\Service\BookService
     */
    public function getBookService()
    {
        return $this->get('munkirjat_book.service.book');
    }
}
