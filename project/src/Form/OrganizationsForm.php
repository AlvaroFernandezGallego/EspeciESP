<?php

namespace App\Form;

use App\Entity\Organizations;
use App\Entity\Regions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;

class OrganizationsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'constraints' => [
                    new NotBlank([
                        'message' => 'El nombre de la organización no puede estar vacío',
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 255,
                        'minMessage' => 'El nombre debe tener al menos {{ limit }} caracteres',
                        'maxMessage' => 'El nombre no puede tener más de {{ limit }} caracteres',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Nombre de la organización',
                ],
            ])
            ->add('region', EntityType::class, [
                'class' => Regions::class,
                'choice_label' => 'name',
                'label' => 'Región',
                'placeholder' => 'Seleccione una región',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, seleccione una región',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Dirección',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'La dirección no puede tener más de {{ limit }} caracteres',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Dirección física de la organización',
                ],
            ])
            ->add('phone_number', TelType::class, [
                'label' => 'Teléfono',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(?:\+?\d{1,4}[\s\-]?)?(?:\(?\d{1,4}\)?[\s\-]?)?\d{1,4}[\s\-]?\d{1,4}[\s\-]?\d{1,4}$/',
                        'message' => 'Por favor, introduzca un número de teléfono válido',
                    ]),
                    new Length([
                        'max' => 20,
                        'maxMessage' => 'El número de teléfono no puede tener más de {{ limit }} caracteres',
                    ]),
                ],
                'attr' => [
                    'placeholder' => '+34 XXX XXX XXX',
                ],
            ])
            ->add('website_url', UrlType::class, [
                'label' => 'Sitio Web',
                'required' => false,
                'constraints' => [
                    new Url([
                        'message' => 'Por favor, introduzca una URL válida',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'https://www.ejemplo.com',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo Electrónico',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?$/',
                        'message' => 'Por favor, introduzca una dirección de correo electrónico válida',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'correo@ejemplo.com',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organizations::class,
        ]);
    }
}
