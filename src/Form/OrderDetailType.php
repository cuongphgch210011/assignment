<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\OrderDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class OrderDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add(
            'product',
            EntityType::class,
            [
                'label' => 'Product name',
                'required' => true,
                'class' => Product::class,
                'choice_label' => 'name',
            ]
        )
        ->add(
            'quantity',
            IntegerType::class,
            [
                'label' => "Quantity",
                'required' => true,
            ])
        ->add('Save', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderDetail::class,
        ]);
    }
}
