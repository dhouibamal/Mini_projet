<?php

// src/Form/ResetPasswordRequestFormType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajouter un champ pour l'email
        $builder->add('email', EmailType::class, [
            'label' => 'Email'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Optionnel: ajouter des options
        $resolver->setDefaults([]);
    }
}

