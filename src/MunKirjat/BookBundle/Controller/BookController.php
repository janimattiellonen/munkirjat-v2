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
        return $this->process();
    }

    public function updateAction($id)
    {
        return $this->process($this->getBookService()->getBook($id) );
    }

    protected function process(Book $book = null)
    {
        $service    = $this->getBookService();
        $form       = $service->getBookForm($book);
        $self       = $this;

        return $this->processForm($form, function() use($form, $service, $self) {

                $book = $form->getData();
                $book->setBookRead($self->getRequest()->request->get('bookRead') );

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