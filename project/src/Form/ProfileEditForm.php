<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProfileEditForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El nombre de usuario es obligatorio']),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'El nombre debe tener al menos {{ limit }} caracteres',
                        'maxMessage' => 'El nombre no puede tener más de {{ limit }} caracteres',
                    ])
                ]
            ])
            ->add('new_password', PasswordType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres',
                    ]),
                ]
            ])
            ->add('new_password_confirm', PasswordType::class, [
                'mapped' => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
