<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', EmprunteurType::class, [
                'choices' => [  
                    'admin' => 'ROLE_ADMIN',
                    'user' => 'ROLE_USER',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            
            ->add('password')
            ->add('enabled')
            ->add('emprunteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
