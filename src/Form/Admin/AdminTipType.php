<?php

namespace App\Form\Admin;

use App\Entity\Tip;
use App\Form\InstructionType;
use App\Form\MaterialType;
use App\Form\QuantityType;
use App\Form\StepType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminTipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Donnez un titre de votre astuce',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Partagez avec vos lecteurs à quoi va servir votre astuce',
                ],
            ])
            ->add('quantities', CollectionType::class, [
                'entry_type' => QuantityType::class,
                'label' => 'Saisissez vos ingrédients',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => ['label' => false],
                'attr' => [
                    'data-controller' => 'form-collection'
                ]
            ])
            ->add('materials', CollectionType::class, [
                'entry_type' => MaterialType::class,
                'label' => 'Matériel nécessaire',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => [
                    'label' => false,
                ],
                'attr' => [
                    'data-controller' => 'form-collection'
                ]
            ])
            ->add('steps', CollectionType::class, [
                'entry_type' => StepType::class,
                'label' => 'Les étapes de votre astuce',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => ['label' => false],
                'attr' => [
                    'data-controller' => 'form-collection'
                ]
            ])
            ->add('instructions', CollectionType::class, [
                'entry_type' => InstructionType::class,
                'label' => 'Le mode d\'emploi de votre astuce',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => ['label' => false],
                'attr' => [
                    'data-controller' => 'form-collection'
                ]
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut de l\'astuce',
                'choices' => [
                    'Publique' => 'public',
                    'En cours de validation' => 'draft',
                    'Privée' => 'private',
                ],
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tip::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
