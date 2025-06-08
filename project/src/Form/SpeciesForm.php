<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Species;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;

class SpeciesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('scientificName', TextType::class, [
                'label' => 'Nombre científico',
                'constraints' => [
                    new NotBlank([
                        'message' => 'El nombre científico no puede estar vacío',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÿ0-9\s\'`,-]+$/',
                        'message' => 'El nombre científico solo puede contener letras, números, espacios, apóstrofes, comas y guiones',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Ej: Panthera leo'
                ]
            ])
            ->add('commonName', TextType::class, [
                'label' => 'Nombre común',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÿ0-9\s\'`,-]+$/',
                        'message' => 'El nombre común solo puede contener letras, números, comas, espacios, apóstrofes y guiones',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Ej: León'
                ]
            ])
            ->add('image', UrlType::class, [
                'label' => 'Imagen: ',
                'required' => false,
                'constraints' => [
                    new Url([
                        'message' => 'La URL de la imagen no es válida',
                    ]),
                    new Regex([
                        'pattern' => '/\.(jpg|jpeg|png|gif|webp|bmp|tiff)$/i',
                        'message' => 'La URL debe terminar en una extensión de imagen válida (.jpg, .jpeg, .png, .gif, .webp, .bmp, .tiff)',
                    ])
                ],
                'attr' => [
                    'placeholder' => 'https://ejemplo.com/imagen.jpg',
                    'class' => 'mt-4'
                ],
                'row_attr' => [
                    'class' => 'mb-4'
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => 'Categoría',
                'class' => Categories::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Debe seleccionar una categoría',
                    ]),
                ],
                'placeholder' => 'Seleccione una categoría'
            ])
            ->add('status', EntityType::class, [
                'label' => 'Estado',
                'class' => Status::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Debe seleccionar un estado',
                    ]),
                ],
                'placeholder' => 'Seleccione un estado'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Species::class,
        ]);
    }
}