<?php

namespace MunKirjat\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LoginFormType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildUserForm($builder, $options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'munkirjat_user_login';
    }

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text')
            ->add('password', 'password')
        ;

        $builder->setRequired(true);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            // commented out intentionally
            // will be activated later on
            //'data_class' => 'Arkhimedes\UserBundle\Form\Model\LoginFormModel',
            'data_class' => 'JmeSf2\GenericUserBundle\Entity\User',
        ));
    }
}