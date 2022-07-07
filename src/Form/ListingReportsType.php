<?php

namespace App\Form;

use App\Entity\ListingReports;
use App\Entity\ReportCategories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListingReportsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category',EntityType::class, array( 
                'label'=>'Reason',
                'class' => ReportCategories::class, 
                'choice_label' => 'title', 
                'expanded' => true, 

                'attr'=>array('class'=>'radio-input-bloc mb-3 d-block' )

            )) 
            ->add('content',TextareaType::class, array(
                'label' => 'Content',
                'attr'=>array('class'=>'form-control mb-3','placeholder'=>'let us know...','rows'=>"4")
            )) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListingReports::class,
        ]);
    }
}
