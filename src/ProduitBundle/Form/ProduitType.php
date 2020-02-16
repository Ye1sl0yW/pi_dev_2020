<?php

namespace ProduitBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('marque')
            ->add('prix')
            ->add('quantite')
            ->add('description')
            ->add('id_categorie',EntityType::class, array(
                'class'=>'ProduitBundle\Entity\Categorie',
                'choice_label'=>'nom',
                'required' => true,
                'expanded' => true,
                'multiple'=>true
            ))
            ->add('id_magasin',EntityType::class, array(
                'class'=>'MagasinBundle\Entity\Magasin',
                'choice_label'=>'id',
                'required' => true,
                'multiple'=>false
            ))
        ->add('Valider',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProduitBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'produitbundle_produit';
    }


}
