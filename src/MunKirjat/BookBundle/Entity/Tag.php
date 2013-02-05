<?php
namespace MunKirjat\BookBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="tag")
 */
class Tag
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
	 * @ORM\Column(name="name", type="string", length=45)
	 */
	protected $name;
	
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="tags")
     */
	protected $books;
	
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @param string $name
     * @return Tag
     */
    public function setName($name)
	{
		$this->name = $name;

        return $this;
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
    public function getName()
	{
		return $this->name;
	}

    /**
     * @param Book $book
     * @return Tag
     */
    public function addBook(Book $book)
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addTag($this);
        }
        
        return $this;
    }

    /**
     * @param Book $book
     * @return Tag
     */
    public function removeBook(Book $book)
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            $book->removeTag($this);
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