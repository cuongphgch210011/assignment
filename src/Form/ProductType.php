<?php

namespace App\Form;

use App\Entity\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => "Product Name",
                'attr' => 
                [
                    'minlength' => 3,
                    'maxlength' => 25
                ]
            ])
            ->add('price', IntegerType::class,
            [
                'label' => "Product Price",
                'attr' => [
                    'min' => 20,
                    'max' => 50
                ]
            ])
            ->add('color', TextType::class,
            [
                'label' => 'Product Color'
            ])
            ->add('image', FileType::class,
            [
                'label' => 'Product image',
                'data_class' => null,
                'required' => is_null($builder->getData()->getImage())
                            //is_null : boolean
                            //if image is null => required = true
                            //else if image is not null => required = false
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}