<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ReportesController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function alumnosPorCarrera()
    {
        return view('alumnos_por_carrera');
    }

    public function getCarrerasCombo()
    {

        $query = $this->db->query('SELECT * FROM carreras');
        $carreras = $query->getResult();
        $html = '';
        $html .= '<option value="">Seleccionar</option>';

        if (!empty($carreras) && is_array($carreras)):
            foreach ($carreras as $carrera):
                $html .= '<option value="' . esc($carrera->id_carrera) . '">' . esc($carrera->nombre_carrera) . '</option>';
            endforeach;
        else:
            $html .= '<option value="">No hay carreras disponibles.</option>';
        endif;

        return $this->response->setBody($html);
    }

    public function getAlumnosCarreraTable()
    {

        $id_carrera = $this->request->getPost('id_carrera');

        $query = $this->db->query("SELECT a.id_estudiante,
                                      CONCAT(a.nombre, ' ', a.apellido) AS nombre,
                                      b.nombre_carrera
                               FROM estudiantes a
                               INNER JOIN carreras b ON b.id_carrera = a.fk_carrera_id
                               WHERE a.fk_carrera_id = $id_carrera");
        $alumnos = $query->getResult();
        $html = '';

        $html .= '
        <div>
            <button type="button" class="btn modal-button-ficha" onclick="descargarReporte()"><i class="fa-solid fa-file-pdf"></i> Descargar</button>
        </div>
        <div id="alumnos_carrera_reporte" style="padding: 20px; font-family: Arial, sans-serif;">
            <center>
                <h2 style="margin-bottom: 20px;">Alumnos por Carrera</h2>
            </center>
            <table class="styled-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: grey;">
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px;">#</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px;">Nombre</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px;">Carrera</th>
                    </tr>
                </thead>
                <tbody>';
        if (!empty($alumnos) && is_array($alumnos)):
            foreach ($alumnos as $alumno):
                $html .= '<tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">' . esc($alumno->id_estudiante) . '</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">' . esc($alumno->nombre) . '</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">' . esc($alumno->nombre_carrera) . '</td>
                    </tr>';
            endforeach;
        else:
            $html .= '<tr>
                    <td colspan="3" style="border: 1px solid #ddd; padding: 8px; text-align: center;">No hay alumnos disponibles.</td>
                </tr>';
        endif;
        $html .= '</tbody>
            </table>
        </div>';

        return $this->response->setBody($html);
    }

    public function notasPorAlumno()
    {
        return view('notas_por_alumno');
    }

    public function getCursosCombo()
    {

        $query = $this->db->query("SELECT * FROM cursos");
        $cursos = $query->getResult();
        $html = '';
        $html .= '<option value="">Seleccionar</option>';

        if (!empty($cursos) && is_array($cursos)):
            foreach ($cursos as $curso):
                $html .= '<option value="' . esc($curso->id_curso) . '">' . esc($curso->nombre_curso) . '</option>';
            endforeach;
        else:
            $html .= '<option value="">No hay cursos disponibles.</option>';
        endif;

        return $this->response->setBody($html);
    }

    public function getSeccionesCombo()
    {

        $query = $this->db->query("SELECT * FROM secciones");
        $secciones = $query->getResult();
        $html = '';
        $html .= '<option value="">Seleccionar</option>';

        if (!empty($secciones) && is_array($secciones)):
            foreach ($secciones as $seccion):
                $html .= '<option value="' . esc($seccion->id_seccion) . '">' . esc($seccion->nombre_seccion) . '</option>';
            endforeach;
        else:
            $html .= '<option value="">No hay secciones disponibles.</option>';
        endif;

        return $this->response->setBody($html);
    }

    public function getNotasAlumnoTable()
    {
        $id_curso = $this->request->getPost('id_curso');
        $id_seccion = $this->request->getPost('id_seccion');
        $id_carrera = $this->request->getPost('id_carrera');

        // Construir la consulta SQL dinámicamente
        $sql = "SELECT  e.nombre_carrera,
                    a.id_estudiante,
                    CONCAT(b.nombre, ' ', b.apellido) AS nombre,
                    a.id_curso,
                    c.nombre_curso,
                    a.id_seccion,
                    d.nombre_seccion,
                    a.nota_primer_parcial,
                    a.nota_segundo_parcial,
                    a.nota_examen_final,
                    a.zona,
                    a.nota_final 
            FROM asignacion_cursos a
            INNER JOIN estudiantes b ON b.id_estudiante = a.id_estudiante
            INNER JOIN cursos c ON c.id_curso = a.id_curso
            INNER JOIN secciones d ON d.id_seccion = a.id_seccion
            INNER JOIN carreras e ON e.id_carrera = b.fk_carrera_id";

        $conditions = [];
        $params = [];

        if (!empty($id_carrera)) {
            $conditions[] = "b.fk_carrera_id = ?";
            $params[] = $id_carrera;
        }
        if (!empty($id_curso)) {
            $conditions[] = "a.id_curso = ?";
            $params[] = $id_curso;
        }
        if (!empty($id_seccion)) {
            $conditions[] = "a.id_seccion = ?";
            $params[] = $id_seccion;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $query = $this->db->query($sql, $params);
        $notas = $query->getResult();
        $html = '';

        $html .= '
    <div>
        <button type="button" class="btn modal-button-ficha" onclick="descargarReporte()"><i class="fa-solid fa-file-pdf"></i> Descargar</button>
    </div>
    <div id="notas_alumno_reporte" style="padding: 20px; font-family: Arial, sans-serif;">
        <center>
            <h2 style="margin-bottom: 20px;">Notas de Alumnos</h2>
        </center>
        <table class="styled-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: grey;">
                    <th scope="col" style="border: 1px solid #ddd; padding: 8px;">#</th>
                    <th scope="col" style="border: 1px solid #ddd; padding: 8px;">Nombre</th>
                    <th scope="col" style="border: 1px solid #ddd; padding: 8px;">Carrera</th>
                    <th scope="col" style="border: 1px solid #ddd; padding: 8px;">Curso</th>
                    <th scope="col" style="border: 1px solid #ddd; padding: 8px;">Sección</th>
                    <th scope="col" style="border: 1px solid #ddd; padding: 8px;">Nota Final</th>
                </tr>
            </thead>
            <tbody>';
        if (!empty($notas) && is_array($notas)):
            $conteo = 1;
            foreach ($notas as $nota):
                $html .= '<tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">' . $conteo . '</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">' . esc($nota->nombre) . '</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">' . esc($nota->nombre_carrera) . '</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">' . esc($nota->nombre_curso) . '</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">' . esc($nota->nombre_seccion) . '</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">' . esc($nota->nota_final) . '</td>
                </tr>';
                $conteo++;
            endforeach;
        else:
            $html .= '<tr>
                <td colspan="6" style="border: 1px solid #ddd; padding: 8px; text-align: center;">No hay alumnos disponibles.</td>
            </tr>';
        endif;
        $html .= '</tbody>
        </table>
    </div>';

        return $this->response->setBody($html);
    }
}
