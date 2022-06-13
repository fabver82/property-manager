<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('end_date',DateType::class,[
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'MM/dd/yyyy',
                'attr' => ['class' => 'form-control'],
                'years' => [date('Y'),date('Y')+1],
            ])
//            TODO: get max guest from settings and populate thecdropdown accordingly( to be added)
            ->add('nb_guest',ChoiceType::class,[
                'choices' => [
                    '1 Person' => 1,
                    '2 Persons' => 2,
                    '3 Persons' => 3,
                ],
                'attr' => ['class' => 'form-control'],
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
