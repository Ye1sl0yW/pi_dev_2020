<?php

namespace MagasinBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('taux')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('id_magasin',EntityType::class, array(
                'class'=>'MagasinBundle:Magasin',
                'choice_label'=>'id',
                'multiple'=>false
            ))
            ->add('Valider',SubmitType::class);;
    }/**
     * {@inheritdoc}
 *
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MagasinBundle\Entity\Offre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'magasinbundle_offre';
    }


}
