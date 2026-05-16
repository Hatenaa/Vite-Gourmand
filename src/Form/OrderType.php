<?php

namespace App\Form;

use App\Entity\Menu;
use App\Entity\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'constraints' => [
                    new Assert\NotBlank(message: 'L\'addresse est obligatoire.'),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'constraints' => [
                    new Assert\NotBlank(message: 'La ville est obligatoire.'),
                ]
            ])
            ->add('deliveryDate', null, [
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotNull(message: 'La date de livraison est obligatoire.'),
                    new Assert\GreaterThanOrEqual(
                        value: 'today',
                        message: 'La date de livraison doit être aujourd\'hui ou dans le futur.'
                    ),
                ],
            ])
            ->add('deliveryTime', null, [
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotNull(message: 'L\'heure de livraison est obligatoire.'),
                ]
            ])
            ->add('peopleCount', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'constraints' => [
                    new Assert\NotBlank(message: 'Le nombre de personnes est obligatoire.'),
                    new Assert\GreaterThan(value: 0, message: 'Le nombre de personnes doit être supérieur à 0.'),
                ],
            ])
            ->add('menu', EntityType::class, [
                'class' => Menu::class,
                'choice_label' => 'title',
                'constraints' => [
                    new Assert\NotNull(message: 'Veuillez sélectionner un menu.'),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
