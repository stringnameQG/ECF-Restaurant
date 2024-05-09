<?php

namespace App\Form;

use App\Entity\Day;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class DayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('active', CheckboxType::class, [
                'label'    => 'Ouvert',
                'required' => true,
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'input__name',
                    'maxlength' => '50'
                ],
                'label' => 'Jour',
                'required' => true
            ])
            ->add('openAM', DateType::class, [
                'attr' => [
                    'class' => 'input__openAM'
                ],
                'label' => 'Heure d\'ouverture Matin',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('closeAM', DateType::class, [
                'attr' => [
                    'class' => 'input__closeAM'
                ],
                'label' => 'Heure de fermeture Matin',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('openPM', DateType::class, [
                'attr' => [
                    'class' => 'input__openPM'
                ],
                'label' => 'Heure d\'ouverture Soir',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('closePM', DateType::class, [
                'attr' => [
                    'class' => 'input__closePM'
                ],
                'label' => 'Heure de fermeture Soir',
                'required' => true,
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Day::class,
        ]);
    }
}
