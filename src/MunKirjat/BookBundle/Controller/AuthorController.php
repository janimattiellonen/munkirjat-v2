<?php
namespace MunKirjat\BookBundle\Controller;

use MunKirjat\Component\Controller\Controller;

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

    public function createAction()
    {
        $service    = $this->getAuthorService();
        $form       = $service->getAuthorForm(null);
        $self       = $this;

        return $this->processForm($form, function() use($form, $service, $self) {

                $service->saveByForm($form);

                return $self->createJsonSuccessResponse(array('success' => true) );
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
