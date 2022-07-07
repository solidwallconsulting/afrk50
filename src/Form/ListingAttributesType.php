<?php

namespace App\Form;

use App\Entity\Attributes;
use App\Entity\Listing;
use App\Entity\ListingAttributes;
 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListingAttributesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('listing', EntityType::class, [
                'class' => Listing::class,
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'','disabled'=>'disabled'),
                'required'=>true,
                'placeholder'=>'Please choose a value',
                'label' => 'Listing',
            ])
            ->add('attribute', EntityType::class, [
                'class' => Attributes::class, 
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>''),
                'required'=>true,
                'placeholder'=>'Please choose a value',
                'label' => 'Attribute',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListingAttributes::class,
        ]);
    }
}
