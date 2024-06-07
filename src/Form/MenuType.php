<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Formula;
use App\Entity\Menu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class MenuType extends AbstractType
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
                'label' => 'Titre'
            ])
            ->add('active')
            ->add('Category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                'multiple' => true,
                'label' => 'Categorie'
            ])
            ->add('Formula', EntityType::class, [
                'class' => Formula::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'Formule'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
