<?php

namespace App\Controller\Admin;

use App\Entity\Pagina;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class PaginaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pagina::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), 
            TextField::new('ruta')->onlyOnIndex()->setCustomOption('disabled', true),
            TextField::new('titulo'),
            TextField::new('subtitulo'),
            TextEditorField::new('texto'),
            BooleanField::new('imagen_tipo1')->renderAsSwitch()
            ->setHelp(
                'Ingrese la ruta de la imagen si "Imagen Tipo 1" está habilitado. <br>' .
                'Ejemplo: <br><img src="img/icons8-imagen-50.png" alt="Ejemplo de ruta" style="max-width: 100px;">'
            ),
            TextField::new('ruta_imagen_tipo1'),
            BooleanField::new('video')->renderAsSwitch()
                ->setHelp(
                    'Ingrese la ruta de la imagen si "Imagen Tipo 1" está habilitado. <br>' .
                    'Ejemplo: <br><img src="img/icons8-imagen-50.png" alt="Ejemplo de ruta" style="max-width: 100px;">'
                ),
                TextField::new('ruta_video'),
                    ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Crud::PAGE_DETAIL, Action::NEW)
            ->disable(Crud::PAGE_DETAIL, Action::DELETE)
        ;
    }

}
