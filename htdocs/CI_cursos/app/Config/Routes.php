<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'CCursos::index');
$routes->get('/cursos', 'CCursos::todoscursos');
$routes->get("/detalleasistencia/(:any)", 'CCursos::detalleasistencia/$1');
$routes->match(["GET", "POST"], "/newasistente", "CCursos::newasistente");
// $routes->get("/newasistente", "CCursos::newasistente");
// $routes->post("/newasistente", "CCursos::newasistente");
// $routes->get("/programar", "CProgramar::elegirSede");
// $routes->get("/programar/(:alphanum)", "CProgramar::nuevoCurso/$1");
$routes->match(["GET", "POST"], "/programar", "CProgramar::elegirSede");
$routes->match(["GET", "POST"], "/programar/(:alphanum)", "CProgramar::nuevoCurso/$1");

$routes->match(["GET", "POST"], "/Edificio/(:any)/(:any)", "CAulas::cursosAulas/$1/$2");
$routes->get("/Edificio/(:any)", "CAulas::detallesEdificio/$1");
