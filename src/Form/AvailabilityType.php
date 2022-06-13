<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
//, [
//    'widget' => 'single_text',
//    'html5' => false,
//    'attr' => ['class' => 'js-datepicker'],
//]
class AvailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date',DateType::class,[
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'MM/dd/yyyy',
                'attr' => ['class' => 'form-control'],
                'years' => [date('Y'),date('Y')+1],
            ])
            ->add('end_date',DateTimeType::class,[
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'MM/dd/yyyy',
                'attr' => ['class' => 'form-control'],
                'years' => [date('Y'),date('Y')+1],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
