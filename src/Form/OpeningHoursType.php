<?php

namespace App\Form;

use App\Entity\OpeningHours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpeningHoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('openingTime', TimeType::class, [
                'label' => 'Heure d\'ouverture',
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('closingTime', TimeType::class, [
                'label' => 'Heure de fermeture',
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('isClosed', CheckboxType::class, [
                'label' => 'Fermé ce jour',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OpeningHours::class
        ]);
    }
}