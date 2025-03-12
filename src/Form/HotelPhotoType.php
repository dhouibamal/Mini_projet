<?php

// src/Form/HotelPhotoType.php
namespace App\Form;

use App\Entity\HotelPhoto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelPhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('ville')
            ->add('categorie')
            ->add('defaultPrice')
            ->add('hotelPhotos', CollectionType::class, [
                'entry_type' => HotelPhotoType::class,
                'allow_add' => true,
                'by_reference' => false,
                'label' => 'Photos de l\'Hôtel',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HotelPhoto::class,
        ]);
    }
}
