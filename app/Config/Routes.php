<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::dashboard');
$routes->get('dashboard', 'DashboardController::dashboard');
$routes->get('asignar-cursos', 'CursosController::asignarCursos');
$routes->get('agregar-notas', 'NotasController::agregarNotas');
$routes->get('mantenimiento/mantenimiento-carreras', 'MantenimientoController::mantenimientoCarreras');
$routes->get('mantenimiento/mantenimiento-semestre', 'MantenimientoController::mantenimientoSemestre');
$routes->get('mantenimiento/mantenimiento-secciones', 'MantenimientoController::mantenimientoSecciones');
$routes->get('mantenimiento/mantenimiento-cursos', 'MantenimientoController::mantenimientoCursos');
$routes->get('mantenimiento/mantenimiento-estudiantes', 'MantenimientoController::mantenimientoEstudiantes');
