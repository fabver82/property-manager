<?php

namespace App\Form;

use App\Entity\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('logo',FileType::class,[
                'multiple' => false,
                'mapped' => false,
                'required' => false,
            ])
            ->add('landing_title')
            ->add('landing_text')
            ->add('SocialFB')
            ->add('socialTwitter')
            ->add('socialLinkedIn')
            ->add('socialInsta')
            ->add('currency',CurrencyType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Settings::class,
        ]);
    }
}
