<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class, array('label' => 'Libelle du produit', 'attr' => array('require', 'class' => 'form-control form-group')))
            ->add('stock',TextType::class, array('label' => 'Quantite en stock', 'attr' => array('require', 'class' => 'form-control form-group')))
            ->add('Valider', SubmitType::class, array('attr' => array('class' => 'btn btn-success')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
