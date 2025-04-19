<?php

namespace App\Form;

use App\Entity\Pagina;
use App\Entity\Carpeta;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Repository\CarpetaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class PaginaType extends AbstractType
{
    private CarpetaRepository $carpetaRepository;

    public function __construct(CarpetaRepository $carpetaRepository)
    {
        $this->carpetaRepository = $carpetaRepository;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $carpetas = $this->carpetaRepository->findAll();
        $choices = [];
        foreach ($carpetas as $carpeta) {
            $choices[$carpeta->getNombre()] = $carpeta->getId();
        }
        $builder
            ->add('ruta', TextType::class, [
                'label' => 'Ruta',
                'attr' => ['placeholder' => 'Introduce la ruta',],
                'constraints' => [
                    new NotBlank(['message' => 'La ruta no puede estar vacía.']),
                    new Regex([
                        'pattern' => '/^\w+$/',
                        'message' => 'La ruta debe contener solo una palabra.',
                    ]),
                ],
            ])
            ->add('titulo', TextType::class, [
                'label' => 'Titulo',
                'attr' => ['placeholder' => 'Introduce tu nombre']
            ])
            ->add('subtitulo', TextType::class, [
                'label' => 'Subtitulo',
                'required' => false,
                'attr' => ['placeholder' => 'Introduce tu correo electrónico']
            ])
            ->add('texto', TextareaType::class, [
                'label' => 'Texto',
                'required' => false,
                'attr' => ['class' => 'form-control tinymce']
            ])
            ->add('contenidoTipo', ChoiceType::class, [
                'label' => 'Tipo de Contenido',
                'choices' => [
                    'Sin contenido' => 'vacio',
                    'Video' => 'video',
                    'Una imagen única' => 'imagen',
                    'Carrusel de imagenes' => 'carrusel',
                    'Texto, Links' => 'textoLink',
                    'Galería de imagenes' => 'galeria',
                    'Cuadricula de links con imagenes'=>'cuadriculaLinks',
                    'Cuadricula de links con botones'=>'cuadriculaDescargas'
                ],
                'expanded' => false, 
                'multiple' => false,  
            ])
            ->add('ruta_imagen_unica', FileType::class, [
                'label' => 'Imagen',
                'mapped' => false, 
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Por favor, sube una imagen válida (JPEG, PNG, GIF)',
                        'maxSizeMessage' => 'El archivo es demasiado grande. El tamaño máximo permitido es {{ limit }}',
                    ])
                ],
            ])
            ->add('texto_alt_imagen_unica', TextType::class, [
                'label' => 'Texto alternativo para la imagen',
                'required' => false,
                'attr' => ['placeholder' => 'Introduce tu correo electrónico']
            ])
            ->add('ruta_video', TextareaType::class, [
                'label' => 'Ruta del video',
                'required' => false,
                'attr' => ['placeholder' => 'Escribe la URL del video aquí', 'rows' => 6],
            ])
            ->add('carpeta', EntityType::class, [
                'class' => Carpeta::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione una carpeta de imágenes',
                'required' => false,
            ])
            ->add('textoConLinks', TextareaType::class, [
                'label' => 'Texto',
                'required' => false,
                'attr' => ['class' => 'form-control tinymce']
            ])
            ->add('cuadriculaItems', CollectionType::class, [
                'entry_type' => CuadriculaItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pagina::class,
        ]);
    }
}
