<?php

namespace App\Form;

use App\Entity\Quantity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuantityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', NumberType::class, [
                'label' => 'Quantité',
                'attr' => [
                    'placeholder' => 'Entrez la quantité (par exemple : 1,5 pour 1,5 litre)',
                ],
            ])
            ->add('unit', TextType::class, [
                'label' => 'Unité de mesure',
                'attr' => [
                    'placeholder' => 'Entrez l\'unité de mesure (par exemple : cuillère à soupe'
                ],
            ])
            ->add('ingredient', IngredientType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quantity::class,
        ]);
    }
}
