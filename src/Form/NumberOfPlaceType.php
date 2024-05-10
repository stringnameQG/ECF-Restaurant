<?php

namespace App\Form;

use App\Entity\NumberOfPlace;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class NumberOfPlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numberOfPlace', IntegerType::class, [
                'attr' => [
                    'class' => 'input__numberOfPlace',
                    'min' => '0'
                ],
                'required' => true,
                'label' => 'Nombre de place'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NumberOfPlace::class,
        ]);
    }
}
