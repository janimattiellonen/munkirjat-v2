<?php
namespace MunKirjat\BookBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;

use MunKirjat\BookBundle\Service\AuthorService;

use Symfony\Component\Form\DataTransformerInterface;

class AuthorTransformer implements DataTransformerInterface
{
    /**
     * @param AuthorService
     */
    protected $authorService;

    /**
     * @param AuthorService $authorService
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * @param mixed $collection The value in the original representation
     *
     * @return mixed The value in the transformed representation
     *
     * @throws UnexpectedTypeException   when the argument is not a string
     * @throws TransformationFailedException  when the transformation fails
     */
    public function transform($collection)
    {
        return $collection;
    }

    /**
     * @param mixed $collection
     * @return mixed
     */
    public function reverseTransform($collection)
    {
        if(null === $collection)
        {
            return array();
        }

        if(is_object($collection) )
        {
            $collection = $collection->toArray();
        }

        if(count($collection) == 0) {
            return $collection;
        }

        $authors = $this->authorService->getAuthorsById(array_filter($collection) );

        return new ArrayCollection($authors);

    }

}
