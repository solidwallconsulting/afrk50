<?php

namespace App\Form;

use App\Entity\Boosts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('duration',IntegerType::class, array(
            'label' => 'Duration (Days)',
            'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
        ))
        ->add('price',NumberType::class, array(
            'label' => 'Price(€)',
            'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
        ))
        ->add('stripeID',TextType::class, array(
            'label' => 'ID stripe(facultatif)',
            'attr'=>array('class'=>'form-control mb-3','placeholder'=>'')
        ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Boosts::class,
        ]);
    }
}
