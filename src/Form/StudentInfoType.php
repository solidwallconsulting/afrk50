<?php

namespace App\Form;

use App\Entity\StudentInfo;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class StudentInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etablismentName',TextType::class, array(
                'label' => 'Name of the Uni/ Training Center',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('etablismentAddress',TextType::class, array(
                'label' => 'Location of the Uni/ Training Center (city and country)',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('studyDomaine',TextType::class, array(
                'label' => 'Study Subject',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'')
            ))
            ->add('studyStartYear',TextType::class, array( 
                
                'label' => 'Start of the studies at:',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'', 'type'=>'month')
            ))
            ->add('intrestsAreas',ChoiceType::class, array( 
                'choices'=>[  
                    'create a start up'=>'create a start up',
                    'develop an existing company'=>'develop an existing company',
                    'learn from the others'=>'learn from the others',
                    'share ideas'=>'share ideas',
                    'find a job'=>'find a job'
                    
                ],
                 "multiple"=>true,
                'label' => 'Areas of interest',
                'attr'=>array('class'=>'form-control-afrk mb-3 multiple-select2','placeholder'=>'')
            ))
              
            ->add('studentPass', FileType::class, [
                
                'label' => 'Upload a valid student Pass (Only PDFs jpg png format are accepted)',
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
                'label' => 'How do you want to contribute to the growth? Expose your ideas, projects, aspirations ?',
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
            'data_class' => StudentInfo::class,
        ]);
    }
}
