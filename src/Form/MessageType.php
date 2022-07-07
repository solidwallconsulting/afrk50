<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, array(
                'label' => 'Your name',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('email',EmailType::class, array(
                'label' => 'Your email',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('subject',TextType::class, array(
                'label' => 'Subject',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('message',TextareaType::class, array(
                'label' => 'Your message',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
