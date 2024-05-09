<?php

namespace App\Form;

use App\Entity\AdditionalInformation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdditionalInformationType extends AbstractType
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
                'label' => 'Nombre d\'invité'
            ])
            ->add('defaultName', TextType::class, [
                'attr' => [
                    'class' => 'input__defaultName',
                    'maxlength' => '100'
                ],
                'required' => true,
                'label' => 'Nom réservation'
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdditionalInformation::class,
        ]);
    }
}
