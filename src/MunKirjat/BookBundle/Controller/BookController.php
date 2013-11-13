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
        $this->assertHasAccess();

        return $this->process($this->getBookService()->getBook($id) );
    }

    public function booksByAuthorAction($authorId)
    {
        $author = $this->getAuthorService()->getAuthor($authorId);

        $books = $this->getBookService()->getBooksByAuthor($author);

        return $this->getJsonResponse($books);
    }

    public function booksByGenreAction($genreId)
    {
        $genre = null;
        $books = $this->getBookService()->getBooksByGenre($genre);

        return $this->getJsonResponse($books);
    }

    public function listAction()
    {
        return $this->getJsonResponse($this->getBookService()->getBooks());
    }

    public function genresAction()
    {
        return $this->getJsonResponse($this->getBookService()->getActiveGenres());
    }

    public function uploadCoverAction()
    {
       // $filename = basename($_FILES['file']['name']);

        //die($filename);
        $request = $this->getRequest();

        $data = $request->getContent();

        file_put_contents('/opt/local/nginx/wwwroot/munkirjat-v2/app/data/kuva.jpg', $data);

        print_r($_SERVER);die;
        //die($data);
    }

    protected function process(Book $book = null)
    {
        $service    = $this->getBookService();
        $form       = $service->getBookForm($book);
        $self       = $this;

        return $this->processForm($form, function() use($form, $service, $self) {

                $book = $form->getData();

                $book->setIsRead($self->getRequest()->request->get('isRead') );

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
