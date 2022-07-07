<?php

namespace App\Form;

use App\Entity\Partnership;
use App\Entity\Sectors;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnershipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, array(
                'label' => 'Your name',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('lastname',TextType::class, array(
                'label' => 'Your last name',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('companyName',TextType::class, array(
                'label' => 'Name of the company',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('email',EmailType::class, array(
                'label' => 'Your email',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('sector', EntityType::class, [
                'class' => Sectors::class,
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'' ),
                'required'=>true,
                'placeholder'=>'Please choose a value',
                'label' => 'Sector',
            ])
            ->add('serviceDescription',TextareaType::class, array(
                'label' => 'Service or the product that you are commercializing',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'','rows'=>'10')
            ))
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partnership::class,
        ]);
    }
}
