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

class EditEmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'Prénom'])
            ->add('lastName', TextType::class, ['label' => 'Nom'])
            ->add('email', EmailType::class, ['label' => 'Adresse email'])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Nouveau mot de passe (laisser vide pour ne pas changer)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
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
