<?php
namespace MunKirjat\BookBundle\Controller;

use MunKirjat\Component\Controller\Controller;
use MunKirjat\BookBundle\Entity\Genre;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class GenreController extends Controller
{
    public function viewAction($id)
    {
        throw new ResourceNotFoundException();
        $service    = $this->getGenreService();
        $genre     = $service->getGenre($id);

        return $this->getJsonResponse($genre->toArray() );
    }

    public function createAction()
    {
        throw new ResourceNotFoundException();
        $service    = $this->getGenreService();
        $form       = $service->getGenreForm(null);
        $self       = $this;

        return $this->processForm($form, function() use($form, $service, $self) {

                $genre = $service->saveByForm($form);

                return $self->createJsonSuccessResponse(array('id' => $genre->getId() ) );
            }
        );
    }

    public function updateAction($id)
    {
        throw new ResourceNotFoundException();
        $service    = $this->getGenreService();

        return $this->process($service->getGenre($id) );
    }

    public function listAction()
    {
        return $this->getJsonResponse($this->getGenreService()->getGenres() );
    }

    /**
     * @param Genre $genre
     * @return mixed
     */
    protected function process(Genre $genre = null)
    {
        $service    = $this->getGenreService();
        $form       = $service->getGenreForm($genre);
        $self       = $this;

        return $this->processForm($form, function() use($form, $service, $self) {

                $genre = $service->saveByForm($form);

                return $self->createJsonSuccessResponse(array('id' => $genre->getId() ) );
            }
        );
    }

    /**
     * @return \MunKirjat\BookBundle\Service\GenreService
     */
    public function getGenreService()
    {
        return $this->get('munkirjat_book.service.genre');
    }
}