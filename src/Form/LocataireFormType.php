<?php

namespace App\Form;

use App\Entity\Locataire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;




class LocataireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

        ->add('prenom', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        
        ->add('adresse', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ]
        ])

        ->add('telephone', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        
        ->add('email', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Locataire::class,
        ]);
    }
}
