<?php

// src/Form/HotelType.php
namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'Hôtel',
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('categorie', TextType::class, [
                'label' => 'Catégorie',
            ])
            ->add('defaultPrice', NumberType::class, [
                'label' => 'Prix par défaut',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter l\'Hôtel',
            ])
            ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}
