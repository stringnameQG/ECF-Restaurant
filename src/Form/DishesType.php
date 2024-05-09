<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Dishes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class DishesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'input__title',
                    'maxlength' => '50'
                ],
                'required' => true,
                'label' => 'Prénom'
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'resize' => 'none',
                    'class' => 'input__description',
                    'maxlength' => '400'
                ],
                'required' => true,
                'label' => 'Commentaire'
            ])
            ->add('price', IntegerType::class, [
                'attr' => [
                    'class' => 'input__price',
                    'min' => '0'
                ],
                'required' => true,
                'label' => 'Note'
            ])
            ->add('bestDishes', CheckboxType::class, [
                'class' => 'input__bestDishes',
                'label'    => 'Ouvert',
                'required' => true,
            ])
            ->add('Category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dishes::class,
        ]);
    }
}
