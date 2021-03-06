<?php

namespace App\Form;

use App\Entity\WorkingDays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkingDaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('day',TextType::class, array(
                'label' => 'Day',
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'Expl Mon,Tus...')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkingDays::class,
        ]);
    }
}
