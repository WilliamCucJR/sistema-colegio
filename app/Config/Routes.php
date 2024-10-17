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

$routes->get('mantenimiento/getCarreras', 'MantenimientoController::getCarreras');
$routes->post('mantenimiento/agregarCarrera', 'MantenimientoController::agregarCarrera');
$routes->post('mantenimiento/getCarreraById', 'MantenimientoController::getCarreraById');
$routes->post('mantenimiento/editarCarrera', 'MantenimientoController::editarCarrera');
$routes->post('mantenimiento/eliminarCarrera', 'MantenimientoController::eliminarCarrera');

$routes->get('mantenimiento/getSemestres', 'MantenimientoController::getSemestres');
$routes->post('mantenimiento/agregarSemestre', 'MantenimientoController::agregarSemestre');
$routes->post('mantenimiento/getSemestreById', 'MantenimientoController::getSemestreById');
$routes->post('mantenimiento/editarSemestre', 'MantenimientoController::editarSemestre');
$routes->post('mantenimiento/eliminarSemestre', 'MantenimientoController::eliminarSemestre');
$routes->post('mantenimiento/getSemestresCombo', 'MantenimientoController::getSemestresCombo');

$routes->get('mantenimiento/getSecciones', 'MantenimientoController::getSecciones');
$routes->post('mantenimiento/agregarSeccion', 'MantenimientoController::agregarSeccion');
$routes->post('mantenimiento/getSeccionById', 'MantenimientoController::getSeccionById');
$routes->post('mantenimiento/editarSeccion', 'MantenimientoController::editarSeccion');
$routes->post('mantenimiento/eliminarSeccion', 'MantenimientoController::eliminarSeccion');
$routes->post('mantenimiento/getSeccionesCombo', 'MantenimientoController::getSeccionesCombo');

$routes->get('mantenimiento/getCursos', 'MantenimientoController::getCursos');
$routes->post('mantenimiento/agregarCurso', 'MantenimientoController::agregarCurso');
$routes->post('mantenimiento/getCursoById', 'MantenimientoController::getCursoById');
$routes->post('mantenimiento/editarCurso', 'MantenimientoController::editarCurso');
$routes->post('mantenimiento/eliminarCurso', 'MantenimientoController::eliminarCurso');
$routes->post('mantenimiento/getCursosCombo', 'MantenimientoController::getCursosCombo');

$routes->get('mantenimiento/getEstudiantes', 'MantenimientoController::getEstudiantes');
$routes->post('mantenimiento/agregarEstudiante', 'MantenimientoController::agregarEstudiante');
$routes->post('mantenimiento/getEstudianteById', 'MantenimientoController::getEstudianteById');
$routes->post('mantenimiento/editarEstudiante', 'MantenimientoController::editarEstudiante');
$routes->post('mantenimiento/eliminarEstudiante', 'MantenimientoController::eliminarEstudiante');
$routes->post('mantenimiento/getCarrerasCombo', 'MantenimientoController::getCarrerasCombo');
$routes->post('mantenimiento/getEstudiantesCombo', 'MantenimientoController::getEstudiantesCombo');

$routes->get('procesos/getAsignaciones', 'ProcesosController::getAsignaciones');
$routes->post('procesos/agregarAsignacion', 'ProcesosController::agregarAsignacion');
$routes->post('procesos/getAsignacionesByEstudiante', 'ProcesosController::getAsignacionesByEstudiante');
$routes->post('procesos/getAsignacionById', 'ProcesosController::getAsignacionById');
$routes->post('procesos/ingresarNotas', 'ProcesosController::ingresarNotas');
$routes->get('procesos/getEstudiantes', 'ProcesosController::getEstudiantes');
$routes->post('procesos/getEstudianteFicha', 'ProcesosController::getEstudianteFicha');

$routes->get('reportes/alumnos-por-carrera', 'ReportesController::alumnosPorCarrera');
$routes->get('reportes/getCarrerasCombo', 'ReportesController::getCarrerasCombo');
$routes->post('reportes/getAlumnosCarreraTable', 'ReportesController::getAlumnosCarreraTable');


$routes->get('reportes/notas-por-alumno', 'ReportesController::notasPorAlumno');
