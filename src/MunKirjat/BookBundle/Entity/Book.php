<?php
namespace MunKirjat\BookBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;

use \DateTime;

use DoctrineExtensions\Taggable\Taggable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="MunKirjat\BookBundle\Repository\BookRepository")
 * @ORM\Table(name="book")
 */
class Book implements Taggable
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
     * @Assert\NotBlank(message="book.title.required")
	 * @ORM\Column(name="title", type="string", length=128)
	 */
	protected $title;
	
	/**
     * @var string
     * @Assert\NotBlank(message="book.language.required")
	 * @ORM\Column(name="language_id", type="string", length=3)
	 */
	protected $language;
	
    /**
     * @Assert\NotBlank(message="book.author.required")
     * @ORM\ManyToMany(targetEntity="Author", inversedBy="books", fetch="EAGER")
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
     */
	protected $tags;
	
	/**
     * @var int
     *
     * @Assert\NotBlank(message="book.pageCount.required")
     * @Assert\Min(limit = "1", message="Page count must be {{ limit }} or more")
	 * @ORM\Column(name="page_count", type="integer", length=5)
	 */
	protected $pageCount;
	
	/**
     * @var boolean
     *
	 * @ORM\Column(name="is_read", type="boolean")
	 */
	protected $isRead;
	
	/**
     * @var string
     *
	 * @ORM\Column(name="isbn", type="string", length=40, nullable=true)
	 */	
	protected $isbn;
	
	/**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(name="created_at", type="datetime")
	 */
	protected $created;
	
	/**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
	 * @ORM\Column(name="updated_at", type="datetime")
	 */
	protected $updated;
	
	/**
     * @var \DateTime
     *
	 * @ORM\Column(name="started_reading", type="datetime", nullable=true)
	 */
	protected $startedReading;
	
	/**
     * @var \DateTime
     *
	 * @ORM\Column(name="finished_reading", type="datetime", nullable=true)
	 */	
	protected $finishedReading;
	
	/**
     * @var float
     *
	 * @ORM\Column(name="rating", type="float", nullable=true)
	 */
	protected $rating;

    /**
     * @var float
     *
     * @Assert\Min(limit = "0", message="Price must be {{ limit }} or more")
     * @Assert\Max(limit = "9999", message="Price must be {{ limit }} or less")
     * @ORM\Column(name="price", type="decimal", precision=8, scale=2, nullable=true)
     */
    protected $price;
	
	public function __construct()
	{
	    $this->authors  = new ArrayCollection();
	    $this->genres   = new ArrayCollection();
	    $this->tags     = new ArrayCollection();
	    $this->created  = $this->updated = new DateTime();
	    $this->rating   = 0.0;
        $this->isRead   = false;
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
    public function addAuthor22(Author $author)
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addBook($this);
        }
        
        return $this;
    }

    /**
     * @param $authors
     * @return $this
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;

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
    public function removeAuthor22(Author $author)
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
    public function getAuthorsAsArray()
    {
        $authors = array();

        foreach($this->getAuthors() as $author)
        {
            $authors[] = array(
                'id'    => $author->getId(),
                'name'  => $author->getFullName(),
            );
        }

        return $authors;
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
     * @param array|ArrayCollection $tags
     *
     * @return Book
     */
    public function setTags($tags)
    {
       // print_r($tags);die;
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return Book
     */
    public function removeTags()
    {
        foreach($this->getTags() as $tag)
        {
            $tag->removeBook($this);
            $this->getTags()->removeElement($tag);
        }

        return $this;
    }

    /**
     * @param Tag $tag
     * @return Book
     */
    public function removeTag2(Tag $tag)
    {
        if ($this->getTags()->contains($tag)) {
            $this->getTags()->removeElement($tag);
            $tag->removeBook($this);
        }
        
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTags()
    {
        $this->tags = $this->tags ?: new ArrayCollection();

        return $this->tags;
    }

    /**
     * @return array
     */
    public function getTagsAsArray()
    {
        $tags = array();

        foreach($this->getTags() as $tag)
        {
            $tags[] = array(
                'id'    => $tag->getId(),
                'name'  => $tag->getName(),
            );
        }

        return $tags;
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
     * @param boolean $read
     * @return Book
     */
    public function setIsRead($read)
	{
		$this->isRead = $read;

        return $this;
	}

    /**
     * @return boolean
     */
    public function getIsRead()
	{
		return $this->isRead;
	}

    /**
     * @param $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

	/**
	 * @return \DateTime
	 */
	public function getCreated()
	{
	    return $this->created;
	}

    /**
     * @param $updated
     * @return $this
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
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
	    $this->startedReading = $startedReading;

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
	    $this->finishedReading = $finishedReading;

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

    /**
     * @return array
     */
    public function toArray()
    {
        $startedReading     = $this->getStartedReading();
        $finishedReading    = $this->getFinishedReading();

        return array(
            'id'                => $this->getId(),
            'title'             => $this->getTitle(),
            'language'          => $this->getLanguage(),
            'isbn'              => $this->getIsbn(),
            'created'           => $this->getCreated()->format("d.m.Y"),
            'updated'           => $this->getUpdated()->format("d.m.Y"),
            'startedReading'    => isset($startedReading) ? $startedReading->format("d.m.Y") : null,
            'finishedReading'   => isset($finishedReading) ? $finishedReading->format("d.m.Y") : null,
            'pageCount'         => $this->getPageCount(),
            'isRead'            => $this->getIsRead(),
            'tags'              => $this->getTagsAsArray(),
            'authors'           => $this->getAuthorsAsArray(),
            'price'             => $this->getPrice(),
        );
    }

    /**
     * Returns the unique taggable resource type
     *
     * @return string
     */
    public function getTaggableType()
    {
        return 'book';
    }

    /**
     * @return int
     */
    public function getTaggableId()
    {
        return $this->getId();
    }

    /**
     * @param float $price
     *
     * @return Book
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}