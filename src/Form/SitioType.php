<?php

namespace App\Form;

use App\Entity\Sitio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


class SitioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('header', FileType::class, [
            'label' => 'Imagen del header',
            'mapped' => false, 
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                        'image/jpg',
                    ],
                    'mimeTypesMessage' => 'Por favor, sube una imagen válida (JPEG, PNG, GIF, JPG)',
                ])
            ],
        ])
            ->add('nombre_sitio', TextType::class, [
                'label' => 'Nombre del sitio',
                'attr' => ['placeholder' => 'Introduce el nombre del sitio web']
            ])
            ->add('logoSitio', FileType::class, [
                'label' => 'Logo del sitio',
                'mapped' => false, 
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Por favor, sube una imagen válida (JPEG, PNG, GIF, JPG)',
                    ])
                ],
            ])
            ->add('mail', TextType::class, [
                'label' => 'Correo electrónico',
                'required' => false,
                'attr' => ['placeholder' => 'Introduce el correo electrónico']
            ])
            ->add('metaTitle', TextType::class, [
                'label' => 'Meta título.',
                'attr' => ['placeholder' => 'Introduce el nombre del sitio web']
            ])
            ->add('metaDescription', TextType::class, [
                'label' => 'Meta descripcion',
                'required' => false,
                'attr' => ['placeholder' => 'Introduce una descripción para que aparezca enlas búsqeudas']
            ])
            ;
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sitio::class,
        ]);
    }
}
