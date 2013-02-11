<?php
namespace MunKirjat\BookBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="MunKirjat\BookBundle\Repository\AuthorRepository")
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
	protected $firstName;
	
	/**
     * @var string
     *
	 * @ORM\Column(name="lastname", type="string", length=45)
	 */	
	protected $lastName;
	
    /**
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="authors")
     */
	protected $books;
	
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @param int $id
     * @return Author
     */
    public function setId($id)
	{
		$this->id = $id;

        return $this;
	}

    /**
     * @param string $firstName
     * @return Author
     */
    public function setFirstName($firstName)
	{
		$this->firstName = $firstName;

        return $this;
	}

    /**
     * @param string $lastName
     * @return Author
     */
    public function setLastname($lastName)
	{
		$this->lastName = $lastName;

        return $this;
	}

    /**
     * @return string
     */
    public function getFullName()
	{
	    return $this->firstName . ' ' . $this->lastName;
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
    public function getFirstName()
	{
		return $this->firstName;
	}

    /**
     * @return string
     */
    public function getLastName()
	{
		return $this->lastName;
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