<?php

namespace App\Controller\Admin;

use App\Entity\Sitio;
 
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class SitioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sitio::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('header'),
            TextField::new('menu'),
            TextField::new('nombre_sitio'),
            TextField::new('logo_sitio'),
            TextField::new('twiter'),
            TextField::new('instagram'),
            TextField::new('facebook'),
            TextField::new('logo_sitio'),
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
