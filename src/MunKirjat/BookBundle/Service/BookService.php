<?php
namespace MunKirjat\BookBundle\Service;

use Doctrine\ORM\EntityManager;

use MunKirjat\BookBundle\Entity\Book;
use MunKirjat\BookBundle\Repository\BookRepository;

class BookService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var \MunKirjat\BookBundle\Repository\BookRepository
     */
    protected $bookRepository;

    /**
     * @param EntityManager     $em
     * @param BookRepository    $bookRepository
     */
    public function __construct(EntityManager $em, BookRepository $bookRepository)
    {
        $this->em               = $em;
        $this->bookRepository   = $bookRepository;
    }

    /**
     * @return \MunKirjat\BookBundle\Entity\Book|null
     */
    public function getLatestReadBook()
    {
        return $this->bookRepository->getLatestReadBook();
    }
}
