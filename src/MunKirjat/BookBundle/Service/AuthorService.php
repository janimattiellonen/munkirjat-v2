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
     * @return int
     */
    public function getAuthorCount()
    {
        return $this->authorRepository->getAuthorCount();
    }
}
