<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\Locataire;
use App\Entity\Logement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('locataire_id', EntityType::class, [
                'attr' => [
                    'class' => 'form-control my-2'
                ],
                'class' => Locataire::class,
                'choice_label' => 'nom',
                'label' => 'Locataire'
            ])

            ->add('logement_id', EntityType::class, [
                'attr' => [
                    'class' => 'form-control my-2'
                ],
                'class' => Logement::class,
                'choice_label' => 'adresse',
                'label' => 'Adresse'
            ])
            ->add('date_entree', DateType::class, [
                'attr' => [
                    'class' => 'form-control my-2'
                ],
                'widget' => 'single_text',
            ])

            ->add('date_sortie', DateType::class, [
                'attr' => [
                    'class' => 'form-control my-2'
                ],
                'widget' => 'single_text',
            ])

            // modifié car le solde est inité à 0
            // ->add('solde',  TextType::class, [
            //     'attr' => [
            //         'class' => 'form-control my-2'
            //     ]
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
