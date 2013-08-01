<?php
namespace MunKirjat\BookBundle\Service;

use Doctrine\ORM\EntityManager;

use MunKirjat\BookBundle\Entity\Author;
use MunKirjat\BookBundle\Form\Type\BookType;
use MunKirjat\BookBundle\Entity\Book;
use MunKirjat\BookBundle\Repository\BookRepository;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Xi\Bundle\TagBundle\Service\AbstractTaggableService;

class BookService extends AbstractTaggableService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var BookRepository
     */
    protected $bookRepository;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @param EntityManager         $em
     * @param BookRepository        $bookRepository
     * @param FormFactory           $formFactory
     * @param ContainerInterface    $container
     */
    public function __construct(EntityManager       $em,
                                BookRepository      $bookRepository,
                                FormFactory         $formFactory,
                                ContainerInterface  $container)
    {
        $this->em               = $em;
        $this->bookRepository   = $bookRepository;
        $this->formFactory      = $formFactory;

        parent::__construct($container);
    }

    /**
     * @param int $id
     * @return Book
     */
    public function getBook($id)
    {
        $book = $this->bookRepository->find($id);

        $this->getTagService()->getTagManager()->loadTagging($book);

        return $book;
    }

    /**
     * @return array
     */
    public function getBooks()
    {
        return $this->bookRepository->findBooksBy();
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

        $this->em->getConnection()->beginTransaction();
        $this->em->persist($book);
        $this->em->flush();

        $this->getTagService()->getTagManager()->saveTagging($book);
        $this->em->flush();
        $this->em->getConnection()->commit();

        return $book;
    }

    /**
     * @param string $term
     *
     * @return array
     */
    public function searchBooks($term)
    {
        return $this->bookRepository->findBooksByTitle($term);
    }

    /**
     * get taggable resource name
     *
     * @return string
     */
    public function getTaggableType()
    {
        return 'book';
    }

    /**
     * @param array $ids
     * @param array $options
     * @param array $tagNames
     * @return resources
     */
    public function getTaggedResourcesByIds(array $ids, array $options, array $tagNames)
    {
        return $this->bookRepository->findById($ids);
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

    /**
     * @param Author $author
     *
     * @return array
     */
    public function getBooksByAuthor(Author $author)
    {
        return $this->bookRepository->findBooksByAuthor(array($author->getId()));
    }
}
