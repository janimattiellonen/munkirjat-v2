<?php
namespace MunKirjat\BookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text')
                ->add('language', 'text')
                ->add('authors', 'author')
                ->add('tags', 'tag')
                ->add('pageCount', 'text')
                ->add('isRead', 'checkbox')
                ->add('startedReading', 'date', array(
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'format' => 'dd.MM.yyyy' ) )
                ->add('finishedReading', 'date', array(
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'format' => 'dd.MM.yyyy' ) )
                ->add('isbn', 'text')
        ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'MunKirjat\BookBundle\Entity\Book',
            'csrf_field_name'   => '_token',
            'intention'         => 'new-book',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'book';
    }
}
