<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Factory\sitioFactory;
use App\Factory\UserFactory;
use App\Factory\paginaFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        UserFactory::createOne([
            'email' => 'admin@admin.com',
            'password'=>$password,
            'roles' => ['ROLE_ADMIN']
        ]);

        UserFactory::createMany(6);
        
        sitioFactory::createMany(1);

        $rutas = ['actividades', 'documental', 'contacto', 'reconstrucciones', 'inicio', 'libro', 'fichas', 'cuentos', 'foro', 'perfil'];
        $titulo = ['actividades', 'documental', 'contacto', 'reconstrucciones', 'inicio', 'libro', 'fichas', 'cuentos', 'foro', 'perfil'];

        foreach ($rutas as $index => $ruta) {
            PaginaFactory::createOne([
                'ruta' => $ruta,
                'titulo' => $titulo[$index],
            ]);
        }

    }
}
