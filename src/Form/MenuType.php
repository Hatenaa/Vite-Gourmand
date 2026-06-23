<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Menu;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Theme;
use App\Entity\Regime;
use App\Entity\Dish;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false
            ])
            ->add('basePrice', NumberType::class, [
                'label' => 'Prix',
            ])
            ->add('minPeople', IntegerType::class, [
                'label' => 'Nombre de personnes minimum',
            ])
            ->add('stock', IntegerType::class, [
                'label' => 'Stock disponible',
            ])
            ->add('conditions', TextareaType::class, [
                'label' => 'Conditions',
                'required' => true // Les conditions du menu sont obligatoires.
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => ' ',
                'required' => false,
            ])
            ->add('theme', EntityType::class, [
                'class' => Theme::class,
                'choice_label' => 'label',
                'label' => 'Thème'
            ])
            ->add('regime', EntityType::class, [
                'class' => Regime::class,
                'choice_label' => 'label',
                'label' => 'Régime'
            ])
            ->add('dishes', EntityType::class, [
                'class' => Dish::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Plats',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class
        ]);
    }
}