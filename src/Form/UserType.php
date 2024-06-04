<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => 'Correo Electrónico',
            'required' => true,
        ])
        ->add('roles', ChoiceType::class, [
            'label' => 'Roles',
            'choices' => [
                'Usuario' => 'ROLE_USER',
                'Administrador' => 'ROLE_ADMIN',
            ],
            'multiple' => true,
            'expanded' => true,
            'required' => true,
        ])
        ->add('username', null, ['label' => 'Nombre de usuario'])
        ->add('nombre', null, ['label' => 'Nombre'])
        ->add('apellido', null, ['label' => 'Apellido'])
        ->add('fechaNacimiento', null, ['label' => 'Fecha de nacimiento'], DateType::class, [
            'widget' => 'single_text',
        ])
        ->add('foto', FileType::class, [
            'label' => 'Foto de Perfil',
            'mapped' => false, 
            'required' => false, 
        ])
        ->add('notificaciones',  null, ['label' => 'Recibir notificaciones'], CheckboxType::class, [
            'required' => false,
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
