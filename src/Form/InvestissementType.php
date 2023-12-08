<?php

namespace App\Form;

use App\Entity\Investissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

class InvestissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idInvestisseur')
            ->add('idEntreprise')
             ->add('montant', null, [
            'constraints' => [
                new NotBlank(),
                new Type('numeric'), //  montant is a numeric field
                new GreaterThan(0), //  the amount should be greater than 0
            ],
        ])
        ->add('dateDebutInvestissement', DateType::class, [
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
            ->add('dureePrevue')
            ->add('details')
            ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Investissement::class,
        ]);
    }
}
