<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use App\Config\PropertyEnumType;
use App\Config\PropertyEnumSpaces;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
                'currency' => 'THB',
                'html5' => true,
                'label' => 'Minimum Price',
            ])
            ->add('type',EnumType::class,[
                'class' => PropertyEnumType::class
            ])
            ->add('pool',EnumType::class,[
                'class' => PropertyEnumSpaces::class
            ])
            ->add('gym',EnumType::class,[
                'class' => PropertyEnumSpaces::class
            ])
            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
