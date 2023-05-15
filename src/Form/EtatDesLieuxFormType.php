<?php

namespace App\Form;

use App\Entity\EtatDesLieux;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtatDesLieuxFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'attr' => [
                    'class' => 'form-control my-2'
                ],
                'widget' => 'single_text',
            ])

            ->add('remarques', TextType::class, [
                'attr' => [
                    'class' => 'form-control my-2'
                ],
            ])
            
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Entrée' => 'entrée', 
                    'Sortie' => 'sortie'
                ], 
                'attr' => [
                    'class' => 'form-control my-2 mb-2'
                ]
            ])
            
            ->add('contrat_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EtatDesLieux::class,
        ]);
    }
}
