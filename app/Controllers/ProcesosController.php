<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ProcesosController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getAsignaciones()
    {
        $query = $this->db->query(" SELECT 	a.id_asignacion,
                                            CONCAT(b.nombre, ' ', b.apellido) as nombre,
                                            a.fecha_asignacion,
                                            c.nombre_curso,
                                            d.nombre_seccion,
                                            e.nombre_semestre
                                    FROM asignacion_cursos a
                                    INNER JOIN estudiantes b ON b.id_estudiante = a.id_estudiante
                                    INNER JOIN cursos c ON c.id_curso = a.id_curso
                                    INNER JOIN secciones d ON d.id_seccion = a.id_seccion
                                    INNER JOIN semestres e ON e.id_semestre = c.fk_id_semestre");
        $asignaciones = $query->getResult();
        $html = '';

        $html .= '<table class="styled-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Estudiante</th>
                        <th scope="col">Fecha Asignación</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Sección</th>
                        <th scope="col">Semestre</th>
                    </tr>
                </thead>
                <tbody>';
        if (!empty($asignaciones) && is_array($asignaciones)):
            foreach ($asignaciones as $asignacion):
                $html .= '<tr>
                        <td>' . esc($asignacion->id_asignacion) . '</td>
                        <td>' . esc($asignacion->nombre) . '</td>
                        <td>' . esc($asignacion->fecha_asignacion) . '</td>
                        <td>' . esc($asignacion->nombre_curso) . '</td>
                        <td>' . esc($asignacion->nombre_seccion) . '</td>
                        <td>' . esc($asignacion->nombre_semestre) . '</td>
                    </tr>';
            endforeach;
        else:
            $html .= '<tr>
                    <td colspan="5">No hay asignaciones disponibles.</td>
                </tr>';
        endif;
        $html .= '</tbody>
            </table>';

        return $html;
    }

    public function agregarAsignacion()
    {
        $id_estudiante = $this->request->getPost('id_estudiante');
        $id_curso = $this->request->getPost('id_curso');
        $id_seccion = $this->request->getPost('id_seccion');
        $fecha_asignacion = date('Y-m-d H:i:s');

        $query = $this->db->query("INSERT INTO asignacion_cursos (id_estudiante, id_curso, id_seccion, fecha_asignacion) VALUES ('$id_estudiante', '$id_curso', '$id_seccion', '$fecha_asignacion')");

        if ($query) {
            return json_encode(array('status' => 'success', 'message' => 'Asignación guardada correctamente.'));
        } else {
            return json_encode(array('status' => 'error', 'message' => 'Error al guardar la asignación.'));
        }
    }

    public function getAsignacionesByEstudiante()
    {
        $id_estudiante = $this->request->getPost('id_estudiante');

        $query = $this->db->query(" SELECT 	a.id_asignacion,
                                            CONCAT(b.nombre, ' ', b.apellido) as nombre,
                                            a.fecha_asignacion,
                                            c.nombre_curso,
                                            d.nombre_seccion,
                                            e.nombre_semestre,
                                            a.nota_primer_parcial,
                                            a.nota_segundo_parcial,
                                            a.nota_examen_final,
                                            a.zona,
                                            a.nota_final
                                    FROM asignacion_cursos a
                                    INNER JOIN estudiantes b ON b.id_estudiante = a.id_estudiante
                                    INNER JOIN cursos c ON c.id_curso = a.id_curso
                                    INNER JOIN secciones d ON d.id_seccion = a.id_seccion
                                    INNER JOIN semestres e ON e.id_semestre = c.fk_id_semestre
                                    WHERE a.id_estudiante = $id_estudiante");
        $asignaciones = $query->getResult();
        $html = '';

        $html .= '<table class="styled-table">
                <thead>
                    <tr>
                        <th scope="col">Estudiante</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Sec.</th>
                        <th scope="col">Semestre</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Nota Final</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>';
        if (!empty($asignaciones) && is_array($asignaciones)):
            foreach ($asignaciones as $asignacion):
                if (($asignacion->nota_primer_parcial != null && $asignacion->nota_primer_parcial > 0) && ($asignacion->nota_segundo_parcial != null && $asignacion->nota_segundo_parcial > 0) && ($asignacion->nota_examen_final != null && $asignacion->nota_examen_final > 0) && ($asignacion->zona != null && $asignacion->zona > 0)) {
                    if (($asignacion->nota_primer_parcial + $asignacion->nota_segundo_parcial + $asignacion->nota_examen_final + $asignacion->zona) > 61) {
                        $class = 'class="table-success"';
                        $estado = 'Aprobado';
                    } else {
                        $class = 'class="table-danger"';
                        $estado = 'Reprobado';
                    }
                } else {
                    $class = '';
                    $estado = 'Pendiente';
                }


                $html .= '<tr>
                        <td ' . $class . ' nowrap>' . esc($asignacion->nombre) . '</td>
                        <td ' . $class . ' nowrap>' . esc($asignacion->nombre_curso) . '</td>
                        <td ' . $class . ' nowrap>' . esc($asignacion->nombre_seccion) . '</td>
                        <td ' . $class . ' nowrap>' . esc($asignacion->nombre_semestre) . '</td>
                        <td ' . $class . ' nowrap>' . esc($estado) . '</td>
                        <td ' . $class . ' nowrap>' . number_format($asignacion->nota_final, 0) . '</td>
                        <td ' . $class . '>
                            <button class="btn btn-primary" onclick="getAsignacionById(' . esc($asignacion->id_asignacion) . ')"><i class="fa-solid fa-check"></i> Ingresar Nota</button>
                    </tr>';
            endforeach;
        else:
            $html .= '<tr>
                    <td colspan="5">No hay asignaciones disponibles.</td>
                </tr>';
        endif;
        $html .= '</tbody>
            </table>';

        return $html;
    }

    public function getAsignacionById()
    {
        $id_asignacion = $this->request->getPost('id_asignacion');

        $query = $this->db->query("SELECT 	a.id_asignacion,
                                        CONCAT(b.nombre, ' ', b.apellido) as nombre,
                                        a.fecha_asignacion,
                                        c.nombre_curso,
                                        d.nombre_seccion,
                                        e.nombre_semestre,
                                        a.nota_primer_parcial,
                                        a.nota_segundo_parcial,
                                        a.nota_examen_final,
                                        a.zona 
                                FROM asignacion_cursos a
                                INNER JOIN estudiantes b ON b.id_estudiante = a.id_estudiante
                                INNER JOIN cursos c ON c.id_curso = a.id_curso
                                INNER JOIN secciones d ON d.id_seccion = a.id_seccion
                                INNER JOIN semestres e ON e.id_semestre = c.fk_id_semestre
                                WHERE id_asignacion = $id_asignacion");
        $asignacion = $query->getRow();

        if ($asignacion) {
            $asignacion->nota_primer_parcial = floor($asignacion->nota_primer_parcial);
            $asignacion->nota_segundo_parcial = floor($asignacion->nota_segundo_parcial);
            $asignacion->nota_examen_final = floor($asignacion->nota_examen_final);
            $asignacion->zona = floor($asignacion->zona);
        }

        return json_encode($asignacion);
    }

    public function ingresarNotas()
    {
        $id_asignacion = $this->request->getPost('id_asignacion');
        $primer_parcial = $this->request->getPost('primer_parcial');
        $segundo_parcial = $this->request->getPost('segundo_parcial');
        $final = $this->request->getPost('final');
        $zona = $this->request->getPost('zona');

        $primer_parcial = ($primer_parcial !== '') ? intval($primer_parcial) : null;
        $segundo_parcial = ($segundo_parcial !== '') ? intval($segundo_parcial) : null;
        $final = ($final !== '') ? intval($final) : null;
        $zona = ($zona !== '') ? intval($zona) : null;

        $nota_final = 0;

        if ($primer_parcial !== null) {
            $nota_final += $primer_parcial;
        }
        if ($segundo_parcial !== null) {
            $nota_final += $segundo_parcial;
        }
        if ($final !== null) {
            $nota_final += $final;
        }
        if ($zona !== null) {
            $nota_final += $zona;
        }

        $query = $this->db->query("UPDATE asignacion_cursos SET nota_primer_parcial = '$primer_parcial', nota_segundo_parcial = '$segundo_parcial', nota_examen_final = '$final', zona = '$zona', nota_final = '$nota_final' WHERE id_asignacion = $id_asignacion");

        if ($query) {
            return json_encode(array('status' => 'success', 'message' => 'Notas guardadas correctamente.'));
        } else {
            return json_encode(array('status' => 'error', 'message' => 'Error al guardar las notas.'));
        }
    }

    public function getEstudiantes()
    {
        $query = $this->db->query("SELECT a.*, b.nombre_carrera 
                               FROM estudiantes a
                               INNER JOIN carreras b ON b.id_carrera = a.fk_carrera_id");
        $estudiantes = $query->getResult();
        $html = '';

        $html .= '<div class="container text-center">
            <div class="row row-cols-1 row-cols-md-3 g-4">';

        if (!empty($estudiantes) && is_array($estudiantes)):
            foreach ($estudiantes as $estudiante):
                $html .= '<div class="col">
                    <div class="card h-100">
                        <img src="' . base_url('uploads/' . esc($estudiante->fotografia)) . '" class="card-img-top mx-auto d-block" alt="Foto de ' . esc($estudiante->nombre) . '" style="height:150px; width:150px; margin:10px">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">' . esc($estudiante->nombre) . ' ' . esc($estudiante->apellido) . '</h5>
                            <p class="card-text"><strong>Carrera:</strong> ' . esc($estudiante->nombre_carrera) . '</p>
                            <div class="mt-auto">
                                <button class="btn btn-primary" onclick="getEstudianteFicha(' . esc($estudiante->id_estudiante) . ')"><i class="fa-solid fa-eye"></i> Ver</button>
                            </div>
                        </div>
                    </div>
                </div>';
            endforeach;
        else:
            $html .= '<div class="col">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <p class="card-text">No hay estudiantes disponibles.</p>
                    </div>
                </div>
            </div>';
        endif;

        $html .= '</div>
        </div>';

        return $html;
    }

    public function getEstudianteFicha()
    {
        $id_estudiante = $this->request->getPost('id_estudiante');

        $query = $this->db->query(" SELECT 	a.id_estudiante,
                                        CONCAT(a.nombre, ' ', a.apellido) as nombre,
                                        a.fecha_nacimiento,
                                        a.fotografia,
                                        b.nombre_carrera 
                                FROM estudiantes a
                                INNER JOIN carreras b ON b.id_carrera = a.fk_carrera_id 
                                WHERE id_estudiante = $id_estudiante");
        $estudiante = $query->getRow();

        $queryNotas = $this->db->query("SELECT 	a.id_asignacion,
                                                CONCAT(b.nombre, ' ', b.apellido) as nombre,
                                                a.fecha_asignacion,
                                                c.nombre_curso,
                                                d.nombre_seccion,
                                                e.nombre_semestre,
                                                a.nota_primer_parcial,
                                                a.nota_segundo_parcial,
                                                a.nota_examen_final,
                                                a.zona,
                                                a.nota_final
                                        FROM asignacion_cursos a
                                        INNER JOIN estudiantes b ON b.id_estudiante = a.id_estudiante
                                        INNER JOIN cursos c ON c.id_curso = a.id_curso
                                        INNER JOIN secciones d ON d.id_seccion = a.id_seccion
                                        INNER JOIN semestres e ON e.id_semestre = c.fk_id_semestre
                                        WHERE a.id_estudiante = $id_estudiante");
        $notas = $queryNotas->getResult();
        $html = '';

        if ($estudiante) {
            $html .= '<div class="container mt-4" style="padding: 20px; border: 1px solid #ddd; border-radius: 10px; font-family: Arial, sans-serif;">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="' . base_url('uploads/' . esc($estudiante->fotografia)) . '" class="img-fluid rounded" alt="Foto de ' . esc($estudiante->nombre) . '" style="height: 150px; width: 150px; border-radius: 50%; margin-bottom: 20px;">
                            </div>
                            <div class="col-md-9">
                                <h2>' . esc($estudiante->nombre) . '</h2>
                                <p><strong>Fecha de Nacimiento:</strong> ' . esc($estudiante->fecha_nacimiento) . '</p>
                                <p><strong>Carrera:</strong> ' . esc($estudiante->nombre_carrera) . '</p>
                            </div>
                        </div>
                        <h3 style="border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-top: 20px;">Historial de Notas</h3>
                        <div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Curso</th>
                                        <th scope="col">1P</th>
                                        <th scope="col">2P</th>
                                        <th scope="col">EF</th>
                                        <th scope="col">Z</th>
                                        <th scope="col">NF</th>
                                        <th scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>';
            if (!empty($notas) && is_array($notas)):
                foreach ($notas as $nota):
                    if (($nota->nota_primer_parcial != null && $nota->nota_primer_parcial > 0) && ($nota->nota_segundo_parcial != null && $nota->nota_segundo_parcial > 0) && ($nota->nota_examen_final != null && $nota->nota_examen_final > 0) && ($nota->zona != null && $nota->zona > 0)) {
                        if (($nota->nota_primer_parcial + $nota->nota_segundo_parcial + $nota->nota_examen_final + $nota->zona) > 61) {
                            $class = 'class="table-success"';
                            $estado = 'Aprobado';
                        } else {
                            $class = 'class="table-danger"';
                            $estado = 'Reprobado';
                        }
                    } else {
                        $class = '';
                        $estado = 'Pendiente';
                    }
                    $html .= '<tr>
                            <td ' . $class . '>' . esc($nota->id_asignacion) . '</td>
                            <td ' . $class . '>' . esc($nota->nombre_curso) . '</td>
                            <td ' . $class . '>' . number_format($nota->nota_primer_parcial, 0) . '</td>
                            <td ' . $class . '>' . number_format($nota->nota_segundo_parcial, 0) . '</td>
                            <td ' . $class . '>' . number_format($nota->nota_examen_final, 0) . '</td>
                            <td ' . $class . '>' . number_format($nota->zona, 0) . '</td>
                            <td ' . $class . '>' . number_format($nota->nota_final, 0) . '</td>
                            <td ' . $class . '>' . $estado . '</td>
                        </tr>';
                endforeach;
            else:
                $html .= '<tr>
                        <td colspan="8">No hay notas disponibles.</td>
                    </tr>';
            endif;
            $html .= '</tbody>
                            </table>
                        </div>
                    </div>';
        } else {
            $html .= '<div class="container mt-4">
                        <div class="alert alert-danger" role="alert">
                            Estudiante no encontrado.
                        </div>
                    </div>';
        }

        return $html;
    }
}
