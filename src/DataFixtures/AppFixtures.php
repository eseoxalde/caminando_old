<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Factory\UserFactory;
use App\Factory\PaginaFactory;
use App\Factory\SitioFactory;


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
        PaginaFactory::createOne([
            'titulo' =>  'inicio',
            'subtitulo' =>  'pagina de inicio - se debe cambiar',
            'ruta' => 'inicio',
        ]);
        SitioFactory::createOne([
            'header' => 'cambiar',
            'nombre_sitio'=>'cambiame'
        ]);

        UserFactory::createMany(6);



}
}