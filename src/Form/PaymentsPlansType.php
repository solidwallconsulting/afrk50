<?php

namespace App\Form;

use App\Entity\PaymentsPlans;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentsPlansType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, array(
                'label' => 'Name',
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
            ))
            ->add('duration',IntegerType::class, array(
                'label' => 'Duration ( days )',
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
            ))
            ->add('price',TextType::class, array(
                'label' => 'Price',
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
            ))
            ->add('policy',TextType::class, array(
                'label' => 'Policy',
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
            ))
            ->add('stripeID',TextType::class, array(
                'label' => 'Stripe ID',
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
            ))
            ->add('allowedListing',TextType::class, array(
                'label' => 'Number of allowed Listing',
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
            ))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PaymentsPlans::class,
        ]);
    }
}
