# Proyecto Symfony

> ⚠️ **Work in progress:** versión sin terminar, conservada como referencia.

Aplicación web desarrollada con Symfony. Proporciona una estructura básica para la gestión de páginas y barra de navegación, y un formulario de contacto.

## Requisitos

- PHP 7.4 o superior
- Composer
- Symfony CLI
- MySQL o cualquier otra base de datos compatible

## Otras tecnologías

- Bootstrap 4.0.0
- TinyMCE 6.x
- Google Fonts (Roboto)
- FontAwesome (local)

## Instalación

1. Cloná el repositorio:

```bash
   git clone https://github.com/eseoxalde/caminando_old.git
   cd caminando_old
```

2. Instalá las dependencias:

```bash
   composer install
```

3. Configurá las variables de entorno: copiá `.env` a `.env.local` y ajustá la conexión a la base de datos y los demás parámetros necesarios.

4. Creá la base de datos y ejecutá las migraciones:

```bash
   symfony console doctrine:database:create
   symfony console doctrine:migrations:migrate
```

5. Creá un usuario admin y los datos iniciales:

```bash
   php bin/console doctrine:fixtures:load
```

   Las credenciales del admin se detallan en [`Manual.md`](Manual.md).

6. Iniciá el servidor de desarrollo:

```bash
   symfony server:start
```

## Uso

Visitá http://localhost:8000 para ver la aplicación en funcionamiento.

Los menús y las páginas se administran desde el panel de administración.

## Documentación

- [`Manual.md`](Manual.md)
- [`Documento.md`](Documento.md)

