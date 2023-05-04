<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\Paiement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PaiementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            ->add('date',  DateType::class, [
                'attr' => [
                    'class' => 'form-control my-2'
                ],
                'widget' => 'single_text',
            ])

            ->add('source', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            ->add('type',TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ] )

            ->add('contrat_id', EntityType::class, [
                'class' => Contrat::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
