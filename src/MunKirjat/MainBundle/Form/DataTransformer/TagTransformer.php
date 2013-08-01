<?php
namespace MunKirjat\MainBundle\Form\DataTransformer;

use Doctrine\Common\Util\Debug;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Xi\Bundle\TagBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use FPN\TagBundle\Entity\TagManager;

use Xi\Bundle\TagBundle\Form\DataTransformer\TagTransformer as BaseTagTransformer;

class TagTransformer extends BaseTagTransformer
{
    /**
     * @var TagManager
     */
    private $tagManager;

    /**
     * @param TagManager $tagManager
     */
    public function __construct(TagManager $tagManager)
    {
        parent::__construct($tagManager);

        $this->tagManager = $tagManager;
    }

    /**
     * transforms collection with tag names to collection with tag entities
     *
     * @param ArrayCollection $collection
     * @return ArrayCollection
     */
    public function reverseTransform($collection)
    {
        if(is_array($collection)) {
            $collection = new ArrayCollection($collection);
        }

        return parent::reverseTransform($collection);
    }
}