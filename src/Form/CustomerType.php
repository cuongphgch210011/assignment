<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('fullname', TextType::class,
        [
            'label' => "User Name",
            'attr' => 
            [
                'minlength' => 3,
                'maxlength' => 25
            ]
        ])
        ->add('phone', IntegerType::class,
        [
            'label' => "User Phone",
        
            
        ])
        ->add('city', TextType::class,
        [
            'label' => 'User City',
           
        ])
        
        ->add('Save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
