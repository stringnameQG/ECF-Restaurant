<?php

namespace App\Form;

use App\Entity\Formula;
use App\Entity\Menu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class FormulaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'input__name',
                    'maxlength' => '50'
                ],
                'required' => true,
                'label' => 'Nom'
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'input__description',
                    'maxlength' => '50'
                ],
                'required' => true,
                'label' => 'description'
            ])
            ->add('dayAccuracy', TextType::class, [
                'attr' => [
                    'class' => 'input__dayAccuracy',
                    'maxlength' => '50'
                ],
                'required' => true,
                'label' => 'dayAccuracy'
            ])
            ->add('price', NumberType::class, [
                'attr' => [
                    'class' => 'input__price',
                    'min' => '0'
                ],
                'required' => true,
                'label' => 'Prix'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formula::class,
        ]);
    }
}
