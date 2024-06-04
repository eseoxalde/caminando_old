# Proyecto Symfony

Este proyecto es una aplicación web desarrollada con Symfony. Proporciona una estructura básica para la gestión de páginas y menús, y un formulario de contacto.

## Requisitos

- PHP 7.4 o superior
- Composer
- Symfony CLI
- MySQL o cualquier otra base de datos compatible

## Instalación

1. Clona el repositorio:

   ```bash
   git clone https://github.com/eseoxalde/caminando_old.git
   cd proyecto-symfony

   ```

2. Instala las dependencias
   composer install

3. Cofigura las variables de entorno
   Copia el archivo .env a .env.local y ajusta los parámetros de conexión a la base de datos y otros parámetros necesarios.

4. Crea la base de datos y ejecuta las migraciones
   symfony console doctrine:database:create
   symfony console doctrine:migrations:migrate

5. Inicia el servidor de desarrollo
   symfony server:start

## Uso

    Visita http://localhost:8000 en tu navegador para ver la aplicación en funcionamiento.

    Accede a /contacto para ver el formulario de contacto.

    Administra los menús y páginas desde las rutas correspondientes.

## Contribución

    Si deseas contribuir, por favor, sigue estos pasos:
    Haz un fork del proyecto.

1. Crea una nueva rama (git checkout -b feature/nueva-caracteristica).
2. Realiza tus cambios y haz commit (git commit -am 'Añadir nueva característica').
3. Empuja la rama (git push origin feature/nueva-caracteristica).
4. Abre un Pull Request.

## Licencia
