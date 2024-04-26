<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
