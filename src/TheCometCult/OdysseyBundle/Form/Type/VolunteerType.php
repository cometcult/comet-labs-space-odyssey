<?php

namespace TheCometCult\OdysseyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class VolunteerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email')
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'volunteer';
    }
}