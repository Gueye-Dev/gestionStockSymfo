<?php

namespace App\Form;

use App\Entity\Sortie;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateS' ,DateType::class, array('label' => "Date de vente", 'attr' => array('require', 'class' => 'form-control form-group')))
            ->add('prixS' ,TextType::class, array('label' => 'Prix de vente', 'attr' => array('require', 'class' => 'form-control form-group')))
            ->add('qte' ,TextType::class, array('label' => 'Quantité vendue', 'attr' => array('require', 'class' => 'form-control form-group')))
         //   ->add('prix')
            ->add('produit',  EntityType::class, array('class' => Produit::class, 'label' => 'Libelle du produit', 'attr' => array('require', 'class' => 'form-control form-group')))
            ->add('Valider', SubmitType::class, array('attr' => array('class' => 'btn btn-success')))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
