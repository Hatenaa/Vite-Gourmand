<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UpdateOrderStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'label' => 'Nouveau statut',
                'choices' => [
                    'Acceptée' => 'ACCEPTED',
                    'En préparation' => 'IN_PREPARATION',
                    'En cours de livraison' => 'IN_DELIVERY',
                    'Livrée' => 'DELIVERED',
                    'En attente retour matériel' => 'WAITING_MATERIAL',
                    'Terminée' => 'COMPLETED',
                ],
            ])
            ->add('contactMode', ChoiceType::class, [
                'label' => 'Mode de contact',
                'choices' => [
                    'Email' => 'EMAIL',
                    'Appel GSM' => 'GSM',
                ],
                'placeholder' => false,
                'required' => false
            ])
            ->add('reason', TextareaType::class, [
                'label' => 'Motif',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}