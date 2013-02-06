<?php
namespace MunKirjat\BookBundle\Entity;

use \DateTime;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="MunKirjat\BookBundle\Repository\BookRepository")
 * @ORM\Table(name="book")
 * @ORM\HasLifecycleCallbacks
 */
class Book
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
	 * @ORM\Column(name="title", type="string", length=128)
	 */
	protected $title;
	
	/**
     * @var string
     *
	 * @ORM\Column(name="language_id", type="string", length=3)
	 */
	protected $language;
	
    /**
     * @ORM\ManyToMany(targetEntity="Author", inversedBy="books")
     * @ORM\JoinTable(name="book_author",
     * 		joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name="author_id", referencedColumnName="id")}
     * )
     */	
	protected $authors;
	
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="books")
     * @ORM\JoinTable(name="book_genre",
     * 		joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
     * )
     */	
	protected $genres;	
	
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="books")
     * @ORM\JoinTable(name="book_tag",
     * 		joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */	
	protected $tags;
	
	/**
     * @var int
     *
	 * @ORM\Column(name="page_count", type="integer", length=5)
	 */
	protected $pageCount;
	
	/**
     * @var boolean
     *
	 * @ORM\Column(name="is_read", type="integer", length=1)
	 */
	protected $isRead;
	
	/**
     * @var string
     *
	 * @ORM\Column(name="isbn", type="string", length=40)
	 */	
	protected $isbn;
	
	/**
     * @var \DateTime
     *
	 * @ORM\Column(name="created_at", type="datetime")
	 */
	protected $created;
	
	/**
     * @var \DateTime
     *
	 * @ORM\Column(name="updated_at", type="datetime")
	 */
	protected $updated;
	
	/**
     * @var \DateTime
     *
	 * @ORM\Column(name="started_reading", type="datetime")
	 */
	protected $startedReading;
	
	/**
     * @var \DateTime
     *
	 * @ORM\Column(name="finished_reading", type="datetime")
	 */	
	protected $finishedReading;
	
	/**
     * @var float
     *
	 * @ORM\Column(name="rating", type="float")
	 */
	protected $rating;
	
	public function __construct()
	{
	    $this->authors  = new ArrayCollection();
	    $this->genres   = new ArrayCollection();
	    $this->tags     = new ArrayCollection();
	    $this->created  = $this->updated = new DateTime();
	    $this->rating   = 0.0;
        $this->isRead   = 0;
	}

    /**
     * @param int $id
     * @return Book
     */
    public function setId($id)
	{
		$this->id = $id;

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
     * @param string $title
     * @return Book
     */
    public function setTitle($title)
	{
		$this->title = $title;

        return $this;
	}

    /**
     * @return string
     */
    public function getTitle()
	{
		return $this->title;
	}

    /**
     * @param string $language
     * @return Book
     */
    public function setLanguage($language)
	{
		$this->language = $language;

        return $this;
	}

    /**
     * @return string
     */
    public function getLanguage()
	{
		return $this->language;
	}

    /**
     * @param Author $author
     * @return Book
     */
    public function addAuthor(Author $author)
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addBook($this);
        }
        
        return $this;
    }

    /**
     * @return Book
     */
    public function removeAuthors()
    {
        foreach($this->authors as $author)
        {
            $author->removeBook($this);
            $this->authors->removeElement($author);
        }

        return $this;
    }

    /**
     * @param Author $author
     * @return Book
     */
    public function removeAuthor(Author $author)
    {
        if ($this->authors->contains($author)) {
            $this->authors->removeElement($author);
            $author->removeBook($this);
        }
        
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAuthors()
    {
        return $this->authors;
    }
    
    /**
     * @return array
     */
    public function getAuthorIds()
    {
        $array = array();
        
        foreach($this->getAuthors() as $author)
        {
            $array[] = $author->getId();
        }
        
        return $array;
    }

    /**
     * @return string
     */
    public function getAuthorsAsString()
    {
        $str = '';
        
        foreach($this->getAuthors() as $author)
        {
            $str .= $author->getFullname() . ', ';    
        }
        
        return rtrim($str, ', ');
    }

    /**
     * @param Genre $genre
     * @return Book
     */
    public function addGenre(Genre $genre)
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
            $genre->addBook($this);
        }
        
        return $this;
    }

    /**
     * @return Book
     */
    public function removeGenres()
    {
        foreach($this->genres as $genre)
        {
            $genre->removeBook($this);
            $this->genres->removeElement($genre);
        }

        return $this;
    }

    /**
     * @param Genre $genre
     * @return Book
     */
    public function removeGenre(Genre $genre)
    {
        if ($this->genres->contains($genre)) {
            $this->genres->removeElement($genre);
            $genre->removeBook($this);
        }
        
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @return string
     */
    public function getGenresAsString()
    {
        $str = '';
        
        foreach($this->getGenres() as $genre)
        {
            $str .= $genre->getName() . ', ';    
        }
        
        return rtrim($str, ', ');
    }

    /**
     * @param Tag $tag
     * @return Book
     */
    public function addTag(Tag $tag)
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addBook($this);
        }
        
        return $this;
    }

    /**
     * @return Book
     */
    public function removeTags()
    {
        foreach($this->tags as $tag)
        {
            $tag->removeBook($this);
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    /**
     * @param Tag $tag
     * @return Book
     */
    public function removeTag(Tag $tag)
    {
        if ($this->tags->contains($genre)) {
            $this->tags->removeElement($tag);
            $genre->removeBook($this);
        }
        
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getTagsAsString()
    {
        $str = '';
        
        foreach($this->getTags() as $tag)
        {
            $str .= $tag->getName() . ', ';    
        }
        
        return rtrim($str, ', ');
    }

    /**
     * @param int $pageCount
     * @return Book
     */
    public function setPageCount($pageCount)
	{
		$this->pageCount = $pageCount;

        return $this;
	}

    /**
     * @return int
     */
    public function getPageCount()
	{
		return $this->pageCount;
	}

    /**
     * @param string $isbn
     * @return Book
     */
    public function setIsbn($isbn)
	{
		$this->isbn = $isbn;

        return $this;
	}

    /**
     * @return string
     */
    public function getIsbn()
	{
		return $this->isbn;
	}

    /**
     * @param boolean $isRead
     * @return Book
     */
    public function setIsRead($isRead)
	{
		$this->isRead = $isRead;

        return $this;
	}

    /**
     * @return boolean
     */
    public function isRead()
	{
		return $this->isRead;
	}
	
	/**
	 * @ORM\PreUpdate
	 */
	public function updated()
	{
	    $this->updated = new \DateTime();
	}
	
	/**
	 * @return \DateTime
	 */
	public function getCreated()
	{
	    return $this->created;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getUpdated()
	{
	    return $this->updated;
	}

    /**
     * @param int $startedReading
     * @return Book
     */
    public function setStartedReading($startedReading)
	{
	    if(isset($startedReading) )
	    {
		    $this->startedReading = new \DateTime($startedReading);
	    }
	    else
	    {
	        $this->startedReading = null;
	    }

        return $this;
	}

    /**
     * @return \DateTime
     */
    public function getStartedReading()
	{
		return $this->startedReading;
	}

    /**
     * @param int $finishedReading
     * @return Book
     */
    public function setFinishedReading($finishedReading)
	{
	    if(isset($finishedReading) )
	    {
		    $this->finishedReading = new \DateTime($finishedReading);
	    }
	    else
	    {
	        $this->finishedReading = null;
	    }

        return $this;
	}

    /**
     * @return \DateTime
     */
    public function getFinishedReading()
	{
		return $this->finishedReading;
	}

    /**
     * @param float $rating
     * @return Book
     */
    public function setRating($rating)
	{
		$this->rating = $rating;

        return $this;
	}

    /**
     * @return float
     */
    public function getRating()
	{
	    return $this->rating;
	}
}