<?php

namespace App\Form;

use App\Entity\AdditionalInformation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'input__email',
                    'maxlength' => '180'
                ],
                'required' => true,
                'label' => 'Email'
            ])
            ->add('roles')
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'input__password'
                ],
                'required' => true,
                'label' => 'Mot de passe'
            ])
            ->add('AdditionalInformation', EntityType::class, [
                'class' => AdditionalInformation::class,
                'choice_label' => 'id',
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
