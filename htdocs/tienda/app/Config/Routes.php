<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
// Explicación clase
$routes->get("/categorias", "CCategorias::index");
$routes->get("/categorias/borrar/(:any)", "CCategorias::borrar/$1");
$routes->match(["GET", "POST"], "/categorias/nuevo", "CCategorias::nuevo");
$routes->match(["GET", "POST"], "/categorias/actualizar/(:any)", "CCategorias::actualizar/$1");

// Ejercicio 3
$routes->get("/productos", "CProductos::index");
$routes->get("/productos/borrar/(:any)", "CProductos::borrar/$1");
$routes->match(["GET", "POST"], "/productos/nuevo", "CProductos::nuevo");
$routes->match(["GET", "POST"], "/productos/actualizar/(:any)", "CProductos::actualizar/$1");

// Explicacion clase
$routes->get("/productos/caros", "CProductos::caros");
$routes->get("/productos/entre/(:any)/(:any)", "CProductos::entre/$1/$2");
$routes->get("/productos/completos", "CProductos::completos");
$routes->get("/productos/cuantossinstock", "CProductos::cuantos_sin_stock");
// $routes->view("/plantilla","plantillas/v_usaplantilla");
$routes->match(["GET", "POST"], "clientes", "CClientes::alta");

// Ejercicio 4
$routes->get("/tarjetas/grabar/(:any)", "CTarjetas::grabar/$1");
$routes->get("/tarjetas/reset/(:any)", "CTarjetas::reset/$1");
$routes->match(["GET", "POST"], "/tarjetas/(:any)", "CTarjetas::tarjeta/$1");