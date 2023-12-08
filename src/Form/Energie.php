<?php

namespace App\Form;

use App\Entity\Energie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
class EnergieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelletEnergie')
            ->add('libelletEnergie', TextType::class, [
                'label' => 'libelletEnergie',
                'constraints' => [
                    new NotBlank(['message' => 'Libellet should not be blank']),
                    new Type(['type' => 'string', 'message' => 'Libellet should be a valid string']),
                ],
            ])
            ->add('pollution_Par_Kw', NumberType::class, [
                'label' => 'pollution_Par_Kw',
                'constraints' => [
                    new Type([
                        'type' => 'numeric',
                        'message' => 'Please enter a valid number.',
                    ]),
                    new Range([
                        'min' => PHP_INT_MIN, // Minimum integer value
                        'max' => PHP_INT_MAX, // Maximum integer value
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
            'data_class' => Energie::class,
        ]);
    }
}
