<?php

namespace App\Form;

use App\Entity\Listing;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',TextType::class, array(
            'label' => 'Titre',
            'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
        ))
        ->add('icon',TextType::class, array(
            'label' => 'Icon( byFontAwesome )',
            'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
        ))
        ->add('color',ColorType::class, array(
            'label' => 'Color',
            'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
        ))
        ->add('photoURL', FileType::class, [
                
            'label' => 'Cover image',
            'mapped' => false,
            'required' => false,
            'attr'=>array('class'=>'form-control   mb-4 form-control-lg form-control-solid','placeholder'=>'', 'accept'=>'images/*' ),
            'constraints' => [ 
            ],
        ])
        
        ->add('content',CKEditorType::class, array(
            'label' => 'Content',
            'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
        ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
        ]);
    }
}
