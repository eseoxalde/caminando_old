# Documento de Requisitos y Contratos (SRC)

## Proyecto Symfony

### Introducción

Este documento detalla los requisitos del proyecto y los acuerdos entre las partes interesadas.

### Objetivo del Proyecto

Desarrollar una aplicación web con Symfony que permita la gestión de páginas y barra de navegación, así como un formulario de contacto.

### Alcance

- Creación, edición y eliminación de páginas. Las paginas tienen un formato perticular:
  - Del lado izquierdo un texto, del derecho:
    - Una imágen
    - Una galería de imágenes (puede ser un carrusel)
    - Un video
    - Enlaces (con imagenes) para descargar pdf
    - Enlaces (con imagenes) a otras páginas
    - Fotos y las redes sociales
  - Galerías de imágenes con un texto que describe la imagen
  - Galería de imagenes y un mapa
- Administración de barra de navegación.
- Formulario de contacto para recibir mensajes de los usuarios.

### Requisitos Funcionales

1. **Gestión de Páginas**

   - Crear nuevas páginas.
   - Editar páginas existentes.
   - Eliminar páginas no críticas (excluyendo la página de inicio).

2. **Gestión de Barra de navegacióm**

   - Listar menús disponibles.
   - Editar detalles del menú.

3. **Formulario de Contacto**
   - Proveer un formulario para que los usuarios envíen mensajes.
   - Guardar los mensajes en la base de datos.
   - Confirmar la recepción del mensaje al usuario.

### Requisitos No Funcionales

- **Seguridad**: Autenticación para acceder a las áreas administrativas.
- **Usabilidad**: Interfaz intuitiva y fácil de usar.
- **Rendimiento**: Respuesta rápida y eficiente.

### Entregables

1. Código fuente del proyecto.
2. Documentación completa (README, manual de ayuda, SRC).
3. Base de datos configurada y migraciones ejecutadas.

### Cronograma

| Tarea                       | Fecha de Inicio | Fecha de Finalización |
| --------------------------- | --------------- | --------------------- |
| Análisis de Requisitos      |                 |                       |
| Diseño del Sistema          |                 |                       |
| Desarrollo                  |                 |                       |
| Pruebas                     |                 |                       |
| Implementación y Despliegue |                 |                       |

### Acuerdos

- **Propiedad Intelectual**: El código fuente y la documentación del proyecto son propiedad del cliente.
- **Soporte y Mantenimiento**: Se proporcionará soporte técnico por un período de 3 meses después de la entrega final.
- **Pagos**:

### Firma

| Nombre del Cliente | Firma | Fecha |
| ------------------ | ----- | ----- |
|                    |       |       |

| Nombre del Desarrollador | Firma | Fecha |
| ------------------------ | ----- | ----- |
|                          |       |       |
