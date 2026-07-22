<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CancelOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contactMode', ChoiceType::class, [
                'label' => 'Mode de contact utilisé',
                'choices' => [
                    'Email' => 'EMAIL',
                    'Appel GSM' => 'GSM',
                ],
                'data' => 'EMAIL',
                'placeholder' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer le mode de contact.'
                    ])
                ],
            ])
            ->add('reason', TextareaType::class, [
                'label' => 'Motif d\'annulation',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer un motif.'])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}