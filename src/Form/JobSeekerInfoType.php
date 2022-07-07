<?php

namespace App\Form;

use App\Entity\JobSeekerInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class JobSeekerInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('areasOfExperience',TextType::class, array(
                'label' => 'Areas of experience:',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('yearsOfExperience',IntegerType::class, array(
                'label' => 'Years of experience:',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('areasOfIntrests',ChoiceType::class, array( 
                'choices'=>[  
                    'Share expertise'=>'Share expertise', 
                    'Development'=>'Development', 
                    'Capital Search'=>'Capital Search', 
                    'Recruitment'=>'Recruitment', 
                    'Partner search'=>'Partner search', 
                    'Commercialization of goods and services'=>'Commercialization of goods and services'  
                ],
                 "multiple"=>true,
                'label' => 'Areas of interest',
                'attr'=>array('class'=>'form-control-afrk mb-3 multiple-select2','placeholder'=>'')
            ))
            ->add('resumeFILE', FileType::class, [

                'row_attr'=>["class"=>"mt-3"], 
                'label' => 'Upload a resume (Only PDFs jpg png format are accepted)',
                'mapped' => false,
                'required' => false,
                'attr'=>array('class'=>'form-control   mb-4 form-control-lg form-control-solid','placeholder'=>'', 'accept'=>'images/*' ),
                'constraints' => [ 
                    new File([
                  
                        'mimeTypes' => [
                            'application/pdf',
                            'image/png',
                            'image/jpg', 
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Only PDFs jpg png format are accepted',
                    ])
                ],
            ]) 
            ->add('moreInfo',TextareaType::class, array(
                'row_attr'=>["class"=>"mt-3"], 
                'label' => 'Describe yourself and the way you want to contribute to this community',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('socialLink',TextType::class, array(
                'label' => 'Social Link',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JobSeekerInfo::class,
        ]);
    }
}
