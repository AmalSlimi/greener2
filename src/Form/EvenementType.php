<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreEvenement', null, [
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 3, 'max' => 255]),
            ],
        ])
              ->add('dateEvenementt', DateType::class, [
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd', // Adjust the date format as needed
            'attr' => [
                'class' => 'flatpickr', // Add the flatpickr class
            ],
            'constraints' => [
                new NotBlank(),
                new GreaterThan('today'), // Ensures the date is greater than the current date
            ],
        ])
            ->add('qrcode')
            ->add('image', FileType::class, [
                'label' => 'Event Image',
                'required' => false,
                'mapped' => false,
            ])
            ->add('lieuEvenement')
        ->add('descriptionEvenement', null, [
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 10]),
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
