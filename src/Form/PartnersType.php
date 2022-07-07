<?php

namespace App\Form;

use App\Entity\Partners;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PartnersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, array(
                'label' => 'Name',
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
            ))
            ->add('logoURL', FileType::class, [
                
                'label' => 'Partner logo',
                'mapped' => false,
                'required' => true,
                'attr'=>array('class'=>'form-control   mb-4 form-control-lg form-control-solid','placeholder'=>'', 'accept'=>'images/*' ),
                'constraints' => [
                    new File([
                        
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partners::class,
        ]);
    }
}
