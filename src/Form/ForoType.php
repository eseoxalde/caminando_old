<?php
namespace App\Form;

use App\Entity\Foro; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre del Foro',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción del Foro',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('postsNormalesLimit', IntegerType::class, [
                'label' => 'Límite de Posts Normales',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('postsImportantesLimit', IntegerType::class, [
                'label' => 'Límite de Posts Importantes',
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Foro::class, 
        ]);
    }
}
