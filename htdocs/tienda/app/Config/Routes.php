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