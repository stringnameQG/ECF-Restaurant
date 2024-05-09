<?php

namespace App\Form;

use App\Entity\CateringService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CateringServiceType extends AbstractType
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
            ->add('dateOpen', DateType::class, [
                'attr' => [
                    'class' => 'input__dateOpen'
                ],
                'label' => 'Heure d\'ouverture',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('dateClose', DateType::class, [
                'attr' => [
                    'class' => 'input__dateOpen'
                ],
                'label' => 'Heure de fermeture',
                'required' => true,
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CateringService::class,
        ]);
    }
}
