<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\PromotionInvoice; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionInvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname',TextType::class, array(
            'label' => 'First name',
            'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
        ))
        ->add('lastname',TextType::class, array(
            'label' => 'Last name ',
            'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
        ))
        ->add('CompanyName',TextType::class, array(
            'label' => 'Company name',
            'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
        ))
        ->add('country', EntityType::class, [
            'class' => Country::class,
            'required'=>true,
            'mapped'=>true,
            'placeholder'=>'Please choose a country',
            'attr'=>array('class'=>'form-control-afrk mb-3'),
            'label' => 'Country',
        ])

        ->add('streetAddressOne',TextType::class, array(
            'label' => 'Street address',
            'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
        ))
        ->add('streetAddressTwo',TextType::class, array(
            'label' => ' ',
            'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'House number and street name')
        ))
        ->add('town',TextType::class, array(
            'label' => 'Town / City ',
            'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'House number and street name')
        ))
        ->add('state',TextType::class, array(
            'label' => 'State / County',
            'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
        ))
        ->add('postcode',TextType::class, array(
            'label' => 'Postcode / ZIP',
            'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
        ))
        
        ->add('phone',TextType::class, array(
            'label' => 'Phone',
            'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
        ))
        ->add('email',TextType::class, array(
            'label' => 'Email address',
            'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
        ))
        ->add('additionalInformation',TextType::class, array(
            'label' => 'Additional information',
            'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Notes about your order, e.g. special notes for delivery.')
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PromotionInvoice::class,
        ]);
    }
}
