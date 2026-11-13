<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'CCursos::index');
$routes->get('/cursos', 'CCursos::todoscursos');
$routes->get("/detalleasistencia/(:any)", 'CCursos::detalleasistencia/$1');
$routes->match(["GET", "POST"], "/newasistente", "CCursos::newasistente");
// $routes->get("/newasistente", "CCursos::newasistente");
// $routes->post("/newasistente", "CCursos::newasistente");
