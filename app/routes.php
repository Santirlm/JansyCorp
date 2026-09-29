<?php
/** @var \dwes\core\Router $router */

// ─── Páginas públicas ────────────────────────────────────────────
$router->get('',            'PagesController@index',       'ROLE_ANONYMOUS');
$router->get('nosotros',    'PagesController@nosotros',    'ROLE_ANONYMOUS');
$router->get('ubicaciones', 'PagesController@ubicaciones', 'ROLE_ANONYMOUS');

// ─── Catálogo ────────────────────────────────────────────────────
$router->get('productos',         'ProductosController@index', 'ROLE_ANONYMOUS');
$router->get('productos/:id',     'ProductosController@show',  'ROLE_ANONYMOUS');

// ─── Auth ────────────────────────────────────────────────────────
$router->get('login',             'AuthController@login',         'ROLE_ANONYMOUS');
$router->post('check-login',      'AuthController@checkLogin',    'ROLE_ANONYMOUS');
$router->get('registro',          'AuthController@registro',      'ROLE_ANONYMOUS');
$router->post('check-registro',   'AuthController@checkRegistro', 'ROLE_ANONYMOUS');
$router->get('logout',            'AuthController@logout',        'ROLE_USER');

// ─── Carrito ─────────────────────────────────────────────────────
$router->get('carrito',              'CarritoController@index',  'ROLE_USER');
$router->get('carrito/add/:id',      'CarritoController@add',    'ROLE_USER');
$router->get('carrito/remove/:id',   'CarritoController@remove', 'ROLE_USER');
$router->get('carrito/vaciar',       'CarritoController@vaciar', 'ROLE_USER');
$router->post('carrito/comprar',     'CarritoController@comprar','ROLE_USER');

// ─── Perfil ──────────────────────────────────────────────────────
$router->get('perfil',                   'PerfilController@index',           'ROLE_USER');
$router->post('perfil/cambiar-password', 'PerfilController@cambiarPassword', 'ROLE_USER');
$router->post('perfil/cambiar-foto',     'PerfilController@cambiarFoto',     'ROLE_USER');
$router->post('perfil/idioma',           'PerfilController@cambiarIdioma',   'ROLE_USER');

// ─── Admin ───────────────────────────────────────────────────────
$router->get('admin',                            'AdminController@index',              'ROLE_ADMIN');
$router->get('admin/productos',                  'AdminController@productos',          'ROLE_ADMIN');
$router->get('admin/productos/crear',            'AdminController@crearProducto',      'ROLE_ADMIN');
$router->post('admin/productos/guardar',         'AdminController@guardarProducto',    'ROLE_ADMIN');
$router->get('admin/productos/editar/:id',       'AdminController@editarProducto',     'ROLE_ADMIN');
$router->post('admin/productos/actualizar/:id',  'AdminController@actualizarProducto', 'ROLE_ADMIN');
$router->get('admin/productos/eliminar/:id',     'AdminController@eliminarProducto',   'ROLE_ADMIN');
$router->get('admin/usuarios',                   'AdminController@usuarios',           'ROLE_ADMIN');
$router->post('admin/usuarios/rol/:id',          'AdminController@cambiarRolUsuario',  'ROLE_ADMIN');
$router->get('admin/usuarios/eliminar/:id',      'AdminController@eliminarUsuario',    'ROLE_ADMIN');