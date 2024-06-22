<?php

namespace App\Form;

use App\Entity\AdditionalInformation;
use App\Entity\Allergy;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;/*
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;*/

class UserInfos extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numberOfGuests', IntegerType::class, [
                'attr' => [
                    'class' => 'input__numberOfGuests',
                    'min' => '1',
                    'max' => '20'
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
            ->add('allergy', EntityType::class, [
                'class' => Allergy::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'choice_label' => 'id',
                    'multiple' => true,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
