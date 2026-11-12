<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/saludar', 'CSaludador::index');
$routes->get('/despedir/(:num)/(:alpha)', 'CSaludador::despedir/$1/$2');
$routes->get('/despedir', 'CSaludador::despedir');
$routes->get('/tempes', 'CSaludador::cargar_vistas');
$routes->get('/suerte', 'CSaludador::saludar_segun_dia');

$routes->get('/saludaridioma/(:any)', 'CSaludador::saludar_segun_idioma/$1');
$routes->get('/publi', 'CSaludador::publi');