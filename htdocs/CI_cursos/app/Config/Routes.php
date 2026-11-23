<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'CCursos::index');
$routes->get('/cursos', 'CCursos::todoscursos');
$routes->get("/detalleasistencia/(:any)", 'CCursos::detalleasistencia/$1');
$routes->match(["GET", "POST"], "/newasistente", "CCursos::newasistente");
$routes->match(["GET", "POST"], "/programar", "CProgramar::elegirSede");
$routes->match(["GET", "POST"], "/programar/(:alphanum)", "CProgramar::nuevoCurso/$1");

// Ejercicio 1 forma vista de tabla entera
$routes->match(["GET", "POST"], "/Edificio/(:alphanum)/(:num)", "CAulas::cursosAulas/$1/$2");
$routes->get("/Edificio/(:alphanum)", "CAulas::detallesEdificio/$1");
// Ejercicio 1 forma vista por linea de tabla
$routes->match(["GET", "POST"], "/Edificio2/(:alphanum)/(:num)", "CAulas::cursosAulas2/$1/$2");
$routes->get("/Edificio2/(:alphanum)", "CAulas::detallesEdificio2/$1");

// Ejercicio 2
$routes->match(["GET", "POST"], "/Login", "CAsistentes::login");
$routes->match(["GET", "POST"], "/Asistente/(:alphanum)", "CAsistentes::datosAsistente/$1");
$routes->match(["GET", "POST"], "/Gestion/asistentes", "CAsistentes::gestion");