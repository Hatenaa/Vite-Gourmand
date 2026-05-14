<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Dish;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Allergen;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class DishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom du plat'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'mapped' => false
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de plat',
                'choices' => [
                    'Entrée' => 'STARTER',
                    'Plat' => 'MAIN',
                    'Dessert' => 'DESSERT',
                    'Accompagnement' => 'SIDE',
                ]
            ])
            ->add('allergens', EntityType::class, [
                'class' => Allergen::class,
                'choice_label' => 'label',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Allergènes',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dish::class
        ]);
    }
}