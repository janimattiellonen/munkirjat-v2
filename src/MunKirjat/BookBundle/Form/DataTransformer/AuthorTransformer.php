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
        //if($collection instanceof ArrayCollection)
        {
           // die('sss');
            $authors = $this->authorService->getAuthorsById(array_filter($collection->toArray() ) );

            return new ArrayCollection($authors);
        }

        return $collection;
    }

}
