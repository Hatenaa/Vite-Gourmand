<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;

class EditOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                'label' => 'Adresse de livraison',
                'constraints' => [
                    new Assert\NotBlank(message: 'L\'adresse est obligatoire.'),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'constraints' => [
                    new Assert\NotBlank(message: 'La ville est obligatoire.'),
                ],
            ])
            ->add('deliveryDate', null, [
                'label' => 'Date de livraison',
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
                'label' => 'Heure de livraison',
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotNull(message: 'L\'heure de livraison est obligatoire'),
                ],
            ])
            ->add('peopleCount', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'constraints' => [
                    new Assert\NotBlank(message: 'Le nombre de personne est obligatoire.'),
                    new Assert\GreaterThan( value: 0, message: 'Le nombre de personnes doit être supérieur à 0.'),
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