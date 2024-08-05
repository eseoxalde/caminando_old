<?php
namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ruta', TextType::class, [
                'label' => 'Ruta',
                'disabled' => true,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ]            ])
            ->add('nombre', TextType::class, [
                'label' => 'Nombre para la barra de navegación',
                'disabled' => true,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('visible', CheckboxType::class, [
                'label' => 'Visible',
                'required' => false,
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('posicion', IntegerType::class, [
                'label' => 'Posición',
                'attr' => ['class' => 'form-control']
            ])
            ->add('parent', EntityType::class, [
                'class' => Menu::class,
                'choice_label' => 'nombre',
                'label' => 'Parent',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
