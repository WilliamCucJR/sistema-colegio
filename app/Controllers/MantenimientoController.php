<?php

namespace App\Controllers;

class MantenimientoController extends BaseController
{
    public function mantenimientoCarreras()
    {
        return view('mantenimiento_carreras');
    }

    public function mantenimientoSemestre()
    {
        return view('mantenimiento_semestre');
    }

    public function mantenimientoSecciones()
    {
        return view('mantenimiento_secciones');
    }

    public function mantenimientoCursos()
    {
        return view('mantenimiento_cursos');
    }

    public function mantenimientoEstudiantes()
    {
        return view('mantenimiento_estudiantes');
    }
}
