<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse mail'
            ])
            ->add('phone', TextType::class, [
                'label' => 'Numéro de téléphone',
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse postale',
                'required' => false,
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville',
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(min: 10, minMessage: 'Le mot de passe doit faire au moins 10 caractères.'),
                    new Assert\Regex(pattern: '/[A-Z]/', message: 'Au moins une majuscule requise.'),
                    new Assert\Regex(pattern: '/[a-z]/', message: 'Au moins une minuscule requise.'),
                    new Assert\Regex(pattern: '/[0-9]/', message: 'Au moins un chiffre requis.'),
                    new Assert\Regex(pattern: '/[\W_]/', message: 'Au moins un caractère spécial requis.'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
