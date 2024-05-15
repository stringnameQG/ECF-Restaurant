<?php

namespace App\Form;

use App\Entity\Allergy;
use App\Entity\Booking;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numberOfGuests', IntegerType::class, [
                'attr' => [
                    'class' => 'input__numberOfGuests',
                    'min' => '0'
                ],
                'required' => true,
                'label' => 'Nombre de personne'
            ])
            ->add('date', DateTimeType::class, [
                'attr' => [
                    'class' => 'input__date'
                ],
                'label' => 'Date de réservation',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'input__name',
                    'maxlength' => '255'
                ],
                'required' => true,
                'label' => 'Nom'
            ])
            ->add('Allergy', EntityType::class, [
                'class' => Allergy::class,
                'choice_label' => 'name',
                'required' => false,
                'multiple' => true,
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
