<?php
namespace App\Form;

use App\Entity\Post;
use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Título',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenido',
                'attr' => ['rows' => 10],
            ])
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'name',
                'label' => 'Categoría',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Guardar',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
