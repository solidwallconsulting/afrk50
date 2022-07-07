<?php

namespace App\Form;

use App\Entity\Newsletters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewslettersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('name',TextType::class, array(
                    'required'=>true,
                    'label' => 'Name',
                    'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Name')
                ))
            ->add('email',EmailType::class, array(
                'required'=>true,
                'label' => 'Email',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Email')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Newsletters::class,
        ]);
    }
}
