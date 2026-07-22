<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],

                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                    ]),
                    new Assert\Regex(pattern: '/[A-Z]/', message: 'Au moins une majuscule requise.'),
                    new Assert\Regex(pattern: '/[a-z]/', message: 'Au moins une minuscule requise.'),
                    new Assert\Regex(pattern: '/[0-9]/', message: 'Au moins un chiffre requis.'),
                    new Assert\Regex(pattern: '/[\W_]/', message: 'Au moins un caractère spécial requis.'),
                ],
            ]);
    }
}