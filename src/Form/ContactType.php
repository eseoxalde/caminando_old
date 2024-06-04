<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre',
                'attr' => ['placeholder' => 'Introduce tu nombre']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo Electrónico',
                'attr' => ['placeholder' => 'Introduce tu correo electrónico']
            ])
            ->add('asunto', TextType::class, [
                'label' => 'Asunto',
                'attr' => ['placeholder' => 'Introduce el asunto del mensaje']
            ])
            ->add('mensaje', TextareaType::class, [
                'label' => 'Mensaje',
                'attr' => ['placeholder' => 'Escribe tu mensaje aquí', 'rows' => 6]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
