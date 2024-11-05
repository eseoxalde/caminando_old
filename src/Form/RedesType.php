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


class RedesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('instagram', TextType::class, [
                'label' => 'Instagram',
                'required' => false,
                'attr' => ['placeholder' => 'Introduce la dirección de Instagram']
            ])
            ->add('facebook', TextType::class, [
                'label' => 'Facebook',
                'required' => false,
                'attr' => ['placeholder' => 'Introduce la direccipon de Facebook']
            ])
            ->add('twitter', TextType::class, [
                'label' => 'X (ex twitter)',
                'required' => false,
                'attr' => ['placeholder' => 'Introduce la dirección de Twitter']
            ])
            ->add('tiktok', TextType::class, [
                'label' => 'Tiktok',
                'required' => false,
                'attr' => ['placeholder' => 'Introduce la dirección de Tiktok']
            ])
            ->add('youtube', TextType::class, [
                'label' => 'Youtube',
                'required' => false,
                'attr' => ['placeholder' => 'Introduce la dirección de Youtube']
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
