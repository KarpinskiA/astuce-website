<?php

namespace App\Form;

use App\Entity\Instruction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstructionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('orderNumber', IntegerType::class, [
                'label' => 'Ordre de l\'étape',
                'attr' => [
                    'placeholder' => 'Numéro de l\'étape (par exemple : 1)',
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description de l\'étape',
                'attr' => [
                    'placeholder' => 'Décrivez ce qu\'il faut faire dans cette étape (par exemple : Mélanger les ingredients dans le récipient. ',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instruction::class,
        ]);
    }
}
