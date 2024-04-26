<?php

namespace App\Controller\Admin;


use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserCrudController extends AbstractCrudController
{

    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            TextField::new('username'),
            TextField::new('password')->setFormTypeOptions(['attr' => ['type' => 'password']]),
            ArrayField::new('roles'),
            TextField::new('perfil'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
{
    return $crud
        ->setEntityLabelInSingular('Usuario')
        ->setEntityLabelInPlural('Usuarios')
        ->setSearchFields(['username', 'email'])
        ->setDefaultSort(['email' => 'DESC'])
    ;
}

public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
{
    // Hashear la contraseña antes de actualizar el usuario
    if ($entityInstance instanceof User) {
        $plainPassword = $entityInstance->getPassword();
        $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $plainPassword);
        $entityInstance->setPassword($hashedPassword);
    }

    parent::updateEntity($entityManager, $entityInstance);
}

public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
{
    // Hashear la contraseña antes de persistir el nuevo usuario
    if ($entityInstance instanceof User) {
        $plainPassword = $entityInstance->getPassword();
        $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $plainPassword);
        $entityInstance->setPassword($hashedPassword);
    }

    parent::persistEntity($entityManager, $entityInstance);
}

}
