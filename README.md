# JansyCorp

Tienda online hecha en PHP sin framework: el enrutador, los controladores, las entidades y los repositorios forman un **MVC propio** construido desde cero.

## Funcionalidades

- **Catálogo** de productos con ficha de detalle y páginas de empresa y ubicaciones.
- **Carrito y pedidos.** Añadir, quitar y vaciar el carrito, y confirmar la compra, que genera el pedido con sus líneas.
- **Registro con CAPTCHA** generado en el servidor (GD) y login con contraseñas cifradas con bcrypt.
- **Perfil de usuario.** Cambiar contraseña, foto de perfil e idioma.
- **Multiidioma** español/inglés con gettext. El idioma queda guardado en el perfil del usuario.
- **Panel de administración.** CRUD de productos con imágenes y gestión de usuarios y roles.
- **Control de acceso por roles** (anónimo, usuario, administrador) definido en cada ruta.
- **Logs** de la aplicación con Monolog.

## Tecnologías

| | |
|---|---|
| Backend | PHP 8, PDO, Composer (autoload PSR-4) |
| Base de datos | MySQL / MariaDB |
| Frontend | Bootstrap, JavaScript |
| Librerías | Monolog, gettext, GD |

## Estructura

```
├── app/
│   ├── controllers/   Controladores (páginas, productos, carrito, perfil, admin, auth)
│   ├── entity/        Entidades del dominio
│   ├── repository/    Acceso a datos con PDO
│   ├── views/         Plantillas y parciales
│   ├── config.php     Configuración de BD, logs y roles
│   └── routes.php     Rutas y rol necesario para cada una
├── core/              Router, Request/Response, seguridad, conexión, helpers
├── database/          Script SQL con datos de prueba
└── public/            index.php (punto de entrada), assets, traducciones, CAPTCHA
```

## Puesta en marcha (XAMPP)

1. Instala las dependencias:
   ```
   composer install
   ```
2. Importa `database/jansycorp.sql` en MySQL. Crea la base de datos `jansycorp` con datos de prueba.
3. Crea el usuario de MySQL que aparece en `app/config.php` (`jansy_user` / `jansy_pass`) o cambia esos datos por los tuyos.
4. Apunta un virtual host de Apache a la carpeta `public/`. El `.htaccess` redirige todas las rutas a `index.php`.

Usuarios de prueba: `admin@jansycorp.com` y `carlos@example.com`, los dos con la contraseña `password`.

---

Proyecto del ciclo DAM/DAW · **Santiago Ramírez**
