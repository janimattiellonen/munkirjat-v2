<?php
namespace MunKirjat\BookBundle\Service;

use Doctrine\ORM\EntityManager;

use MunKirjat\BookBundle\Form\Type\AuthorType;
use MunKirjat\BookBundle\Entity\Author;
use MunKirjat\BookBundle\Repository\AuthorRepository;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;

class AuthorService
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \MunKirjat\BookBundle\Repository\AuthorRepository
     */
    protected $authorRepository;

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * @param \Doctrine\ORM\EntityManager                       $em
     * @param \MunKirjat\BookBundle\Repository\AuthorRepository $authorRepository
     * @param \Symfony\Component\Form\FormFactory               $formFactory
     */
    public function __construct(EntityManager       $em,
                                AuthorRepository    $authorRepository,
                                FormFactory         $formFactory)
    {
        $this->em               = $em;
        $this->authorRepository = $authorRepository;
        $this->formFactory      = $formFactory;
    }

    /**
     * @param int $id
     * @return \MunKirjat\BookBundle\Entity\Author
     */
    public function getAuthor($id)
    {
        return $this->authorRepository->find($id);
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getAuthorsById(array $ids = array() )
    {
        return $this->authorRepository->getAuthorsById($ids);
    }

    /**
     * @param string $fullName
     *
     * @return array
     */
    public function searchAuthors($fullName)
    {
        $parts = explode(' ', $fullName);

        if(count($parts) == 1)
        {
            return $this->authorRepository->searchByName($parts[0]);
        }
        else if(count($parts) == 2)
        {
            return $this->authorRepository->searchByName($parts[0], $parts[1]);
        }

        return array();
    }

    /**
     * @param array $authors
     *
     * @return array
     */
    public function formatResults(array $authors = array() )
    {
        $formatted = array();


        return $formatted;
    }

    /**
     * @param \MunKirjat\BookBundle\Entity\Author $author
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function getAuthorForm(Author $author = null)
    {
        return $this->formFactory->create(new AuthorType(), $author);
    }

    /**
     * @param \Symfony\Component\Form\Form $form
     * @return \MunKirjat\BookBundle\Entity\Author
     */
    public function saveByForm(Form $form)
    {
        $author = $form->getData();

        $this->em->persist($author);
        $this->em->flush();

        return $author;
    }

    /**
     * @param int $minBooks the minimum amount of books by an author
     * @param int $limit
     * @return array
     */
    public function getFavouriteAuthors($minBooks = 3, $limit = 20)
    {
        return $this->authorRepository->getFavouriteAuthors($minBooks, $limit);
    }

    /**
     * @return array
     */
    public function getAuthors()
    {
        return $this->authorRepository->getAuthors();
    }

    /**
     * @return int
     */
    public function getAuthorCount()
    {
        return $this->authorRepository->getAuthorCount();
    }
}
