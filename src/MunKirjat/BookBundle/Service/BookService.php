<?php
namespace MunKirjat\BookBundle\Service;

use Doctrine\ORM\EntityManager;

use MunKirjat\BookBundle\Form\Type\BookType;
use MunKirjat\BookBundle\Entity\Book;
use MunKirjat\BookBundle\Repository\BookRepository;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;

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
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * @param EntityManager     $em
     * @param BookRepository    $bookRepository
     * @param FormFactory       $formFactory
     */
    public function __construct(EntityManager   $em,
                                BookRepository  $bookRepository,
                                FormFactory     $formFactory)
    {
        $this->em               = $em;
        $this->bookRepository   = $bookRepository;
        $this->formFactory      = $formFactory;
    }

    /**
     * @param int $id
     * @return \MunKirjat\BookBundle\Entity\Book
     */
    public function getBook($id)
    {
        return $this->bookRepository->find($id);
    }

    /**
     * @param Book $book
     * @return Form
     */
    public function getBookForm(Book $book = null)
    {
        return $this->formFactory->create(new BookType(), $book);
    }

    /**
     * @param \Symfony\Component\Form\Form $form
     * @return \MunKirjat\BookBundle\Entity\Book
     */
    public function saveByForm(Form $form)
    {
        $book = $form->getData();

        $this->em->persist($book);
        $this->em->flush();

        return $book;
    }

    /**
     * @return \MunKirjat\BookBundle\Entity\Book|null
     */
    public function getLatestReadBook()
    {
        return $this->bookRepository->getLatestReadBook();
    }

    /**
     * @return \MunKirjat\BookBundle\Entity\Book
     */
    public function getLatestAddedBook()
    {
        return $this->bookRepository->getLatestAddedBook();
    }

    /**
     * @return int
     */
    public function getReadPageCount()
    {
        return $this->bookRepository->getReadPageCount();
    }

    /**
     * @return int
     */
    public function getBookCount()
    {
        return $this->bookRepository->getBookCount();
    }

    /**
     * @return int
     */
    public function getUnreadBookCount()
    {
        return $this->bookRepository->getUnreadBookCount();
    }

    /**
     * @return int
     */
    public function getUnratedBookCount()
    {
        return $this->bookRepository->getUnratedBookCount();
    }

    /**
     * @return float
     */
    public function getAverageBookReadPace()
    {
        return $this->bookRepository->getAverageBookReadPace();
    }

    /**
     * @return float
     */
    public function getSlowestBookReadPace()
    {
        return $this->bookRepository->getSlowestBookReadPace();
    }

    /**
     * @return float
     */
    public function getFastestBookReadPace()
    {
        return $this->bookRepository->getFastestBookReadPace();
    }

    /**
     * @return float
     */
    public function getAverageRating()
    {
        return $this->bookRepository->getAverageRating();
    }

    /**
     * @param int $limit
     * @param int $diff
     * @return mixed
     */
    public function getRecentlyReadBooks($limit = 20, $diff = 183)
    {
        return $this->bookRepository->getRecentlyReadBooks($limit, $diff);
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getUnreadBooks($limit = 20)
    {
        return $this->bookRepository->getUnreadBooks($limit);
    }
}
