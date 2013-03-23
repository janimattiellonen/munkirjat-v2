<?php
namespace MunKirjat\BookBundle\Controller;

use MunKirjat\Component\Controller\Controller;
use MunKirjat\BookBundle\Entity\Author;

class AuthorController extends Controller
{
    public function newAction()
    {
        $service    = $this->getAuthorService();
        $form       = $service->getAuthorForm(null);
        return $this->render('MunKirjatBookBundle:Author:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function viewAction($id)
    {
        $service    = $this->getAuthorService();
        $author     = $service->getAuthor($id);

        return $this->getJsonResponse($author->toArray() );
    }

    public function createAction()
    {
        return $this->process();
    }

    public function updateAction($id)
    {
        $service    = $this->getAuthorService();

        return $this->process($service->getAuthor($id) );
    }

    public function listAction()
    {
        return $this->getJsonResponse($this->getAuthorService()->getAuthors() );
    }

    public function searchAction()
    {
        return $this->createJsonSuccessResponse($this->getAuthorService()->searchAuthors($this->getRequest()->get('term') ) );
    }

    /**
     * @param Author $author
     * @return mixed
     */
    protected function process(Author $author = null)
    {
        $service    = $this->getAuthorService();
        $form       = $service->getAuthorForm($author);
        $self       = $this;

        return $this->processForm($form, function() use($form, $service, $self) {

                $author = $service->saveByForm($form);

                return $self->createJsonSuccessResponse(array('id' => $author->getId() ) );
            }
        );
    }

    /**
     * @return \MunKirjat\BookBundle\Service\AuthorService
     */
    public function getAuthorService()
    {
        return $this->get('munkirjat_book.service.author');
    }
}
