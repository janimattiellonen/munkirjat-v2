<?php
namespace MunKirjat\BookBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="author")
 */
class Author
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
     * @var string
     *
	 * @ORM\Column(name="firstname", type="string", length=45)
	 */
	protected $firstname;
	
	/**
     * @vaer string
     *
	 * @ORM\Column(name="lastname", type="string", length=45)
	 */	
	protected $lastname;
	
    /**
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="authors")
     */
	protected $books;
	
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }
	
	public function setId($id)
	{
		$this->id = $id;
	}

    /**
     * @param string $pFirstname
     */
    public function setFirstname($pFirstname)
	{
		$this->firstname = $pFirstname;
	}

    /**
     * @param string $pLastname
     */
    public function setLastname($pLastname)
	{
		$this->lastname = $pLastname;
	}

    /**
     * @return string
     */
    public function getFullname()
	{
	    return $this->firstname . ' ' . $this->lastname;
	}

    /**
     * @return int
     */
    public function getId()
	{
		return $this->id;
	}

    /**
     * @return string
     */
    public function getFirstname()
	{
		return $this->firstname;
	}

    /**
     * @return string
     */
    public function getLastname()
	{
		return $this->lastname;
	}

    /**
     * @param Book $book
     * @return Author
     */
    public function addBook(Book $book)
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addAuthor($this);
        }
        
        return $this;
    }

    /**
     * @param Book $book
     * @return Author
     */
    public function removeBook(Book $book)
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            $book->removeAuthor($this);
        }
        
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
    }
}