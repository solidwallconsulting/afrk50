<?php

namespace App\Form;

use App\Entity\AccountTypes;
use App\Entity\Country;
use App\Entity\User;
use App\Entity\UserCategories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $isCompany = $options['isCompany'];
         
        if ($options['adminEditing'] == true) {

            $builder
            ->add('isBlocked',CheckboxType::class, array(
                'required'=>false,
                'label' => "Block user",
                'attr'=>array('class'=>' d-block mb-3','placeholder'=>'')
            )) 
            

            ;
        }

        if ($options['privacy'] == true) {
            $builder->add('privacy', ChoiceType::class, [
                'label' => 'Profile Privacy',
                'attr'=>array('class'=>'form-control-afrk mb-3 bg-white' ),
                'choices'  => [
                    'Everyone' => 0,
                    'Only me' => 1, 
                ],
            ]);
        }else{
            
           
            
            if ( $isCompany  == true) {
                $builder->add('companyName',TextType::class, array(
                    'label' => 'Company name',
                    'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Please Enter Your company name')
                ));
            }else{
                $builder->add('firstname',TextType::class, array(
                    'label' => 'First Name',
                    'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Please Enter Your First Name')
                ))
                ->add('lastname',TextType::class, array(
                    'label' => 'Last Name',
                    'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Please Enter Your Last Name')
                )) ;
            }


            $builder->add('displayName',TextType::class, array(
                'label' => 'Display name',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Please Enter Your Display name')
            )) 
            ->add('phone',TelType::class, array(
                'label' => 'Phone number',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Please Enter Your Phone number')
            ))
            ->add('address',TextType::class, array(
                'label' => 'Address',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Please Enter Your Address')
            ))
            


            ->add('country', EntityType::class, [
                'class' => Country::class,
                'required'=>true,
                'mapped'=>true,
                'placeholder'=>'Please choose a country',
                'attr'=>array('class'=>'form-control-afrk mb-3'),
                'label' => 'Country',
            ])   

              ;




            if ($isCompany == true) {
                $builder->add('numberOfEmployees',IntegerType::class, array(
                    'label' => 'Number of employees',
                    'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Please the number of employees')
                ))
    
    
                ->add('rangeOfYearlyRevenues',TextType::class, array(
                    'label' => 'Range of yearly revenues',
                    'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Please the range of yearly revenues')
                ))
    
                ->add('typeOfCompany', ChoiceType::class, [
                    'label' => 'Type of Company',
                    'attr'=>array('class'=>'form-control-afrk mb-3 bg-white' ),
                    'choices'  => [
                        'Corporation' => "Corporation",
                        'SME' => "SME",
                        'Start Up' => "Start Up",
                        'Incubator' => "Incubator",
                        'VC' => "VC",
                        'NGO' => "NGO" 
    
                    ],
                ])
                
    
    
                ->add('phaseOfTheCompany', ChoiceType::class, [
                    'label' => 'Phase of the company',
                    'attr'=>array('class'=>'form-control-afrk mb-3 bg-white' ),
                    'choices'  => [
                        'launch' => "launch",
                        'development' => "development",
                        'growth Up' => "growth",
                        'growth' => "growth" 
                    ],
                ])
    
                ->add('registrationNumber',TextType::class, array(
                    'label' => 'Registration number',
                    'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Please your registration number')
                ))
    
                ->add('contactPerson',TextType::class, array(
                    'label' => 'Contact person',
                    'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Please your contact person')
                ))
    
    
                ->add('interests', ChoiceType::class, [
                    'label' => 'Interests',
                    'attr'=>array('class'=>'form-control-afrk mb-3 bg-white' ),
                    'choices'  => [
                        'Investor' => "Investor",
                        'Development' => "Development",
                        'Capital Search' => "Capital Search",
                        'Recruitment' => "Recruitment" ,
                        'Partner search' => "Partner search" ,
                        'Commercialization of goods and services' => "Commercialization of goods and services"
                        
                    ],
                ]);
    
     
                
                
                
            }else{
                $builder->add('category', EntityType::class, [
                    'class' => UserCategories::class,
                    'required'=>true,
                    'mapped'=>true, 
                    'attr'=>array('class'=>'form-control-afrk mb-3'),
                    'label' => 'Category',
                ]);
            }




            $builder->add('about',TextareaType::class, array(
                'label' => $isCompany == true ? 'About' : 'Short company description',
                'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Enter a short company description')
            ))
             

            
            ;

 
        }

        if ($options['isEditing'] == false) {

            $builder
            ->add('category', EntityType::class, [
                'class' => UserCategories::class,
                'required'=>true,
                'mapped'=>true,
                'placeholder'=>'Please choose a category',
                'attr'=>array('class'=>'form-control-afrk mb-3'),
                'label' => 'Category',
            ]) 
                ->add('email',EmailType::class, array(
                    'label' => 'Email',
                    'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Please Enter Your Email')
                ))->
                add('password',PasswordType::class, array(
                    'label' => 'Password',
                    'attr'=>array('class'=>'form-control-afrk mb-3','placeholder'=>'Please Enter Your Password','minlength'=>8)
                ))
            ;
        }




 
    }
   
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isEditing'=>false,
            'adminEditing' => false,
            'privacy'=>null,
            'isCompany'=>null
        ]);
    }
}
