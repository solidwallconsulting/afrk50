<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('slogan')
            ->add('description')
            ->add('logoURL')
            ->add('videoURL')
            ->add('email')
            ->add('website')
            ->add('timezone')
            ->add('address')
            ->add('lng')
            ->add('lat')
            ->add('addionalInformations')
            ->add('createdAt')
            ->add('coverImageURL')
            ->add('status')
            ->add('user')
            ->add('listing')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
