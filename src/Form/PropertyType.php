<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'trim' => true,
            ])
            ->add('description',TextareaType::class,[
                'required' => true,
                'trim' => true,
                'attr' => ['class' => 'tinymce'],
                ])
            ->add('bedrooms')
            ->add('min_price',MoneyType::class,[
                'currency' => '',
                'html5' => true,
                'label' => 'Minimum Price',
            ])
            ->add('type',ChoiceType::class,[
                'choices' => [
                    'Condo' => 'Condo',
                    'Villa' => 'Villa',
                    'Bungalow' => 'Bungalow',
                ]
            ])
            ->add('pool',ChoiceType::class,[
                'choices' => [
                    'None' => null,
                    'Private' => 'Private',
                    'Shared' => 'Shared',
                ]
            ])
            ->add('gym',ChoiceType::class,[
                'choices' => [
                    'None' => null,
                    'Private' => 'Private',
                    'Shared' => 'Shared',
                ]
            ])
            ->add('status',ChoiceType::class,[
                'choices' => [
                    'Open' => 'Open',
                    'Close' => 'Close',
                    'Snooze' => 'Snooze',
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
