<?php
namespace MunKirjat\BookBundle\Entity;

use \DateTime;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="readingsession")
 */
class ReadingSession
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Book
     *
     * @ORM\ManyToOne(targetEntity="MunKirjat\BookBundle\Entity\Book", inversedBy="readingSessions")
     */
    protected $book;

    /**
     * @var int
     *
     * @ORM\Column(name="starting_page", type="integer", nullable=true)
     */
    protected $startingPage;

    /**
     * @var int
     *
     * @ORM\Column(name="ending_page", type="integer", nullable=true)
     */
    protected $endingPage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="starting_date", type="datetime")
     */
    protected $startingDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ending_date", type="datetime", nullable=true)
     */
    protected $endingDate;

    /**
     * @param \MunKirjat\BookBundle\Entity\Book $book
     *
     * @return ReadingSession
     */
    public function setBook(Book $book)
    {
        if ($this->book !== $book) {
            $this->book = $book;
            $this->book->addReadingSession($this);
        }

        return $this;
    }

    /**
     * @return \MunKirjat\BookBundle\Entity\Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @param \DateTime $endingDate
     *
     * @return ReadingSession
     */
    public function setEndingDate(\DateTime $endingDate)
    {
        $this->endingDate = $endingDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndingDate()
    {
        return $this->endingDate;
    }

    /**
     * @param int $endingPage
     *
     * @return ReadingSession
     */
    public function setEndingPage($endingPage)
    {
        $this->endingPage = $endingPage;

        return $this;
    }

    /**
     * @return int
     */
    public function getEndingPage()
    {
        return $this->endingPage;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $startingDate
     *
     * @return ReadingSession
     */
    public function setStartingDate(\DateTime $startingDate)
    {
        $this->startingDate = $startingDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartingDate()
    {
        return $this->startingDate;
    }

    /**
     * @param int $startingPage
     *
     * @return ReadingSession
     */
    public function setStartingPage($startingPage)
    {
        $this->startingPage = $startingPage;

        return $this;
    }

    /**
     * @return int
     */
    public function getStartingPage()
    {
        return $this->startingPage;
    }

    /**
     * @return boolean
     */
    public function hasOpenSession()
    {
        return null === $this->getEndingDate();
    }
}
 