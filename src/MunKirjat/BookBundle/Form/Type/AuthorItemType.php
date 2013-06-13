<?php
namespace MunKirjat\BookBundle\Form\Type;

use MunKirjat\BookBundle\Form\DataTransformer\AuthorTransformer;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AuthorItemType extends CollectionType
{
    /**
     * @var \MunKirjat\BookBundle\Form\DataTransformer\AuthorTransformer
     */
    private $authorTransformer;

    /**
     * @param AuthorTransformer $authorTransformer
     */
    public function __construct(AuthorTransformer $authorTransformer)
    {
        $this->authorTransformer = $authorTransformer;
    }

    /**
     * @param  FormBuilderInterface $builder
     * @param  array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->appendClientTransformer($this->authorTransformer);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'allow_add'     => true,
            'allow_delete'  => true,
            'prototype'     => true,
            'type'          => 'text',
            'options'       => array('data' => true),
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'collection';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'author';
    }
}
