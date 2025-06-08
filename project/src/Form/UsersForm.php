<?php
namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UsersForm extends AbstractType
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
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El email es obligatorio']),
                    new Assert\Email(['message' => 'El email {{ value }} no es válido'])
                ]
            ])
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La contraseña es obligatoria']),
                    new Assert\Length([
                        'min' => 8,
                        'max' => 50,
                        'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres',
                        'maxMessage' => 'La contraseña no puede tener más de {{ limit }} caracteres'
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                        'message' => 'La contraseña debe contener al menos una letra mayúscula, una minúscula, un número y un carácter especial'
                    ])
                ]
            ])
            ->add('password_confirmation', PasswordType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Por favor, confirme su contraseña'])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class
        ]);
    }
}