<?php
namespace MunKirjat\MainBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use MunKirjat\MainBundle\Form\DataTransformer\TagTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use FPN\TagBundle\Entity\TagManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Xi\Bundle\TagBundle\Form\Type\TagType as BaseTagType;

class TagType extends BaseTagType
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
     * @return string
     */
    public function getName()
    {
        return 'custom_tag';
    }

    /**
     * @param  FormBuilderInterface $builder
     * @param  array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new TagTransformer($this->tagManager);
        $builder->addViewTransformer($transformer);
    }
}