<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date',DateType::class,[
                'widget' => 'choice',
                'years' => [date('Y'),date('Y')+1],
            ])
            ->add('end_date',DateType::class,[
                'widget' => 'choice',
                'years' => [date('Y'),date('Y')+1],
            ])
            ->add('nb_guest')
            ->add('comment')
            ->add('status')
            ->add('property')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
