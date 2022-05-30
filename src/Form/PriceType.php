<?php

namespace App\Form;

use App\Entity\Price;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        TODO: no property selection if price on property
        $builder
            ->add('name')
            ->add('start_date',DateType::class,[
                'widget' => 'choice',
                'years' => [date('Y'),date('Y')+1],
            ])
            ->add('end_date',DateType::class,[
                'widget' => 'choice',
                'years' => [date('Y'),date('Y')+1],
            ])
            ->add('price')
            ->add('property',EntityType::class,[
                'class' => Property::class,
                'disabled' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Price::class,
        ]);
    }
}
