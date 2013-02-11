<?php
namespace MunKirjat\BookBundle\Service;

use Doctrine\ORM\EntityManager;

use MunKirjat\BookBundle\Entity\Author;
use MunKirjat\BookBundle\Repository\AuthorRepository;

class AuthorService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var AuthorRepository
     */
    protected $authorRepository;

    /**
     * @param EntityManager     $em
     * @param AuthorRepository  $authorRepository
     */
    public function __construct(EntityManager $em, AuthorRepository $authorRepository)
    {
        $this->em               = $em;
        $this->authorRepository = $authorRepository;
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
     * @return int
     */
    public function getAuthorCount()
    {
        return $this->authorRepository->getAuthorCount();
    }
}
