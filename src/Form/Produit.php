<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Energie;
use App\Entity\Produit;
use App\Entity\Vehicule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelletProduit')
            ->add('Categorie' , EntityType::class,[
                'class'=> Categorie::class,
                'choice_label' => 'libellet',
                'required' => true
            ])
            ->add('imageFile',VichImageType::class,[
                'required'=>false,
            ])
            ->add('Prix')
            ->add('Description')
            ->add('Production_mentuelle')
            ->add('Stock_actuelle')
            ->add('typeVehicule', EntityType::class, [
                'class' => Vehicule::class,
                'choice_label' => 'LibelletVehicule'
            ])
            ->add('distanceVehicule')
            ->add('typeEnergie' , EntityType::class,[
                'class'=> Energie::class,
                'choice_label' => 'libelletEnergie',
            ])
            ->add('consommationrnEnergie')
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
