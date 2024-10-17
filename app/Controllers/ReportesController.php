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
}
