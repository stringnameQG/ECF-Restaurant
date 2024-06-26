<?php

namespace App\Form;

use App\Entity\Dishes;
use App\Entity\PictureDishes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PictureDishesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'input__title',
                    'maxlength' => '50',
                    'visibility'=> 'hidden'
                ],
                'required' => true,
                'label' => 'Titre'
            ])
            ->add('pictures', FileType::class, [
                'attr' => [
                    'class' => 'input__pictures',
                    'accept' => 'image/*',
                ],
                'label' => 'Image',
                'multiple' => false,
                'mapped' => false,
                'required' => false,
            ])
            ->add('dishes', EntityType::class, [
                'class' => Dishes::class,
                'choice_label' => 'title',
                'label' => 'Plat',
            ])
            ->add('display', CheckboxType::class, [
                'label' => 'Afficher',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PictureDishes::class,
        ]);
    }
}
