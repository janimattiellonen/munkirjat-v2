<?php
namespace MunKirjat\BookBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="MunKirjat\BookBundle\Repository\GenreRepository")
 * @ORM\Table(name="genre")
 */
class Genre
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
     * @Assert\NotBlank(message="genre.name-required")
	 * @ORM\Column(name="name", type="string", length=45)
	 */
	protected $name;
	
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="genres")
     */
	protected $books;
	
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @param string $name
     * @return Genre
     */
    public function setName($name)
	{
		$this->name = $name;

        return $this;
	}

    /**
     * @return int mixed
     */
    public function getId()
	{
		return $this->id;
	}

    /**
     * @return String
     */
    public function getName()
	{
		return $this->name;
	}

    /**
     * @param Book $book
     * @return Genre
     */
    public function addBook(Book $book)
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addGenre($this);
        }
        
        return $this;
    }

    /**
     * @param Book $book
     * @return Genre
     */
    public function removeBook(Book $book)
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            $book->removeGenre($this);
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

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'id'    => $this->getId(),
            'name'  => $this->getName(),
        );
    }
}