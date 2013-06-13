<?php
namespace MunKirjat\BookBundle\Service;

use Doctrine\ORM\EntityManager;

use MunKirjat\BookBundle\Form\Type\GenreType;
use MunKirjat\BookBundle\Entity\Genre;
use MunKirjat\BookBundle\Repository\GenreRepository;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;

class GenreService
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \MunKirjat\BookBundle\Repository\GenreRepository
     */
    protected $genreRepository;

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * @param \Doctrine\ORM\EntityManager                       $em
     * @param \MunKirjat\BookBundle\Repository\GenreRepository  $genreRepository
     * @param \Symfony\Component\Form\FormFactory               $formFactory
     */
    public function __construct(EntityManager       $em,
                                GenreRepository     $genreRepository,
                                FormFactory         $formFactory)
    {
        $this->em               = $em;
        $this->genreRepository  = $genreRepository;
        $this->formFactory      = $formFactory;
    }

    /**
     * @param int $id
     * @return \MunKirjat\BookBundle\Entity\Genre
     */
    public function getGenre($id)
    {
        return $this->genreRepository->find($id);
    }

    /**
     * @return array
     */
    public function getGenres()
    {
        return $this->genreRepository->getgenres();
    }

    /**
     * @param \MunKirjat\BookBundle\Entity\Genre $genre
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function getGenreForm(Genre $genre = null)
    {
        return $this->formFactory->create(new GenreType(), $genre);
    }

    /**
     * @param \Symfony\Component\Form\Form $form
     * @return \MunKirjat\BookBundle\Entity\Genre
     */
    public function saveByForm(Form $form)
    {
        $genre = $form->getData();

        $this->em->persist($genre);
        $this->em->flush();

        return $genre;
    }
}