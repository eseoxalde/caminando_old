### 2. Manual de Ayuda

El manual de ayuda es útil para proporcionar una guía detallada sobre cómo usar y administrar la aplicación.

```markdown
# Manual de Ayuda

## Índice

1. [Introducción](#introducción)
2. [Instalación](#instalación)
3. [Uso](#uso)
4. [Administración de Páginas](#administración-de-páginas)
5. [Administración de Menús](#administración-de-menús)
6. [Formulario de Contacto](#formulario-de-contacto)
7. [Resolución de Problemas](#resolución-de-problemas)

## Introducción

Este manual proporciona instrucciones detalladas para instalar, usar y administrar la aplicación Symfony.

## Instalación

Sigue los pasos descritos en el [README](README.md) para instalar la aplicación.

## Uso

Después de instalar la aplicación, puedes acceder a ella en `http://localhost:8000`. La navegación principal incluye secciones para gestionar páginas y menús, así como un formulario de contacto.

## Administración de Páginas

### Crear Página

1. Navega a `/crear-pagina`.
2. Completa el formulario con los detalles de la nueva página.
3. Haz clic en "Guardar" para crear la página.

### Editar Página

1. Navega a `/editar-pagina/{ruta}`.
2. Modifica los campos necesarios.
3. Haz clic en "Guardar" para actualizar la página.

### Eliminar Página

1. Navega a `/borrar-pagina/{ruta}`.
2. Confirma la eliminación.

## Administración de Menús

### Listar Menús

1. Navega a `/menus`.
2. Visualiza la lista de menús existentes.

### Editar Menú

1. Navega a `/menus/{id}/editar`.
2. Modifica los campos necesarios.
3. Haz clic en "Guardar" para actualizar el menú.

## Formulario de Contacto

1. Navega a `/contacto`.
2. Completa el formulario y envíalo.
3. Recibirás una confirmación de que tu mensaje ha sido enviado.

## Resolución de Problemas

### Problemas Comunes

1. **Error de Conexión a la Base de Datos**:

   - Verifica los parámetros de conexión en `.env.local`.
   - Asegúrate de que el servidor de la base de datos esté en funcionamiento.

2. **Errores en Migraciones**:
   - Asegúrate de que todas las migraciones están actualizadas ejecutando `symfony console doctrine:migrations:migrate`.

Para más problemas, revisa los registros de Symfony en `var/log` y consulta la documentación oficial de Symfony.
```
