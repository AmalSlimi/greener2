<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        $builder
            ->add('LibelletVehicule', TextType::class, [
                'label' => 'Libellet',
                'constraints' => [
                    new NotBlank(['message' => 'Libellet should not be blank']),
                    new Type(['type' => 'string', 'message' => 'Libellet should be a valid string']),
                ],
            ])
            ->add('Marque', TextType::class, [
                'label' => 'Marque',
                'constraints' => [
                    new NotBlank(['message' => 'Marque should not be blank']),
                    new Type(['type' => 'string', 'message' => 'Marque should be a valid string']),
                ],
            ])
            ->add('PollutioParKm', NumberType::class, [
                'label' => 'PollutioParKm',
                'constraints' => [
                    new Type([
                        'type' => 'numeric',
                        'message' => 'Please enter a valid number.',
                    ]),
                    new Range([
                        'min' => PHP_INT_MIN, 
                        'max' => PHP_INT_MAX, 
                        'minMessage' => 'Please enter a valid number.',
                        'maxMessage' => 'Please enter a valid number.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
