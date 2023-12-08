<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('pdp', FileType::class, [
                'label' => 'Upload an image',
                'mapped' => false, 
                'required' => false, 
            ])
            ->add('num')
            ->add('mail')
            ->add('mdp1')
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'client' => 'client',
                    'investisseur' => 'investisseur',
                    'agent_entreprise' => 'agent entreprise',
                ],
            ])
            ->add('adresse')
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'femme' => 'femme',
                    'homme' => 'homme',

                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
