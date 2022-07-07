<?php

namespace App\Form;

use App\Entity\HowItHelps;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HowItHelpsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('video',TextareaType::class, array(
                'label' => 'Video integration',
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
            )) 
            ->add('descreption',TextareaType::class, array(
                'label' => 'Description',
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
            )) 
            ->add('user', EntityType::class, [
                'class' => User::class,
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'' ),
                'required'=>true,
                'placeholder'=>'Please choose a value',
                'label' => 'User',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HowItHelps::class,
        ]);
    }
}
