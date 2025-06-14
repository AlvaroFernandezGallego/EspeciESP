<?php

namespace App\Form;

use App\Entity\Messages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class MessagesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('issue', TextType::class, [
                'label' => 'Asunto',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El asunto es obligatorio']),
                    new Assert\Length([
                        'max' => 50,
                        'maxMessage' => 'El asunto no puede tener más de {{ limit }} caracteres'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La descripción es obligatoria'])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}