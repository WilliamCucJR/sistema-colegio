<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class MantenimientoController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function mantenimientoCarreras()
    {
        return view('mantenimiento_carreras');
    }

    public function getCarreras()
    {
        $query = $this->db->query('SELECT * FROM carreras');
        $carreras = $query->getResult();
        $html = '';

        $html .= '<table class="styled-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Carrera</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>';
        if (!empty($carreras) && is_array($carreras)):
            foreach ($carreras as $carrera):
                $html .= '<tr>
                        <td>' . esc($carrera->id_carrera) . '</td>
                        <td>' . esc($carrera->nombre_carrera) . '</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" onClick="getCarreraById(' . esc($carrera->id_carrera) . ')"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                            <button type="button" class="btn btn-danger btn-sm" onClick="eliminarCarrera(' . esc($carrera->id_carrera) . ')"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
                        </td>
                    </tr>';
            endforeach;
        else:
            $html .= '<tr>
                    <td colspan="3">No hay carreras disponibles.</td>
                </tr>';
        endif;
        $html .= '</tbody>
            </table>';

        return $html;
    }

    public function agregarCarrera()
    {
        $nombre_carrera = $this->request->getPost('nombre_carrera');

        $this->db->table('carreras')->insert(['nombre_carrera' => $nombre_carrera]);
    }

    public function getCarreraById()
    {
        $id_carrera = $this->request->getPost('id_carrera');

        $query = $this->db->query('SELECT * FROM carreras WHERE id_carrera = ?', [$id_carrera]);
        $carrera = $query->getRow();

        return json_encode($carrera);
    }

    public function editarCarrera()
    {
        $id_carrera = $this->request->getPost('id_carrera');
        $nombre_carrera = $this->request->getPost('nombre_carrera');

        $this->db->table('carreras')->where('id_carrera', $id_carrera)->update(['nombre_carrera' => $nombre_carrera]);
    }

    public function eliminarCarrera()
    {
        $id_carrera = $this->request->getPost('id_carrera');

        $this->db->table('carreras')->where('id_carrera', $id_carrera)->delete();
    }

    public function mantenimientoSemestre()
    {
        $query = $this->db->query('SELECT * FROM semestres');
        $data['semestres'] = $query->getResult();

        return view('mantenimiento_semestre', $data);
    }

    public function getSemestres()
    {
        $query = $this->db->query('SELECT * FROM semestres');
        $semestres = $query->getResult();
        $html = '';

        $html .= '<table class="styled-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Semestre</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>';
        if (!empty($semestres) && is_array($semestres)):
            foreach ($semestres as $semestre):
                $html .= '<tr>
                        <td>' . esc($semestre->id_semestre) . '</td>
                        <td>' . esc($semestre->nombre_semestre) . '</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" onClick="getSemestreById(' . esc($semestre->id_semestre) . ')"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                            <button type="button" class="btn btn-danger btn-sm" onClick="eliminarSemestre(' . esc($semestre->id_semestre) . ')"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
                        </td>
                    </tr>';
            endforeach;
        else:
            $html .= '<tr>
                    <td colspan="3">No hay semestres disponibles.</td>
                </tr>';
        endif;
        $html .= '</tbody>
            </table>';

        return $html;
    }

    public function agregarSemestre()
    {
        $nombre_semestre = $this->request->getPost('nombre_semestre');

        $this->db->table('semestres')->insert(['nombre_semestre' => $nombre_semestre]);
    }

    public function getSemestreById()
    {
        $id_semestre = $this->request->getPost('id_semestre');

        $query = $this->db->query('SELECT * FROM semestres WHERE id_semestre = ?', [$id_semestre]);
        $semestre = $query->getRow();

        return json_encode($semestre);
    }

    public function editarSemestre()
    {
        $id_semestre = $this->request->getPost('id_semestre');
        $nombre_semestre = $this->request->getPost('nombre_semestre');

        $this->db->table('semestres')->where('id_semestre', $id_semestre)->update(['nombre_semestre' => $nombre_semestre]);
    }

    public function eliminarSemestre()
    {
        $id_semestre = $this->request->getPost('id_semestre');

        $this->db->table('semestres')->where('id_semestre', $id_semestre)->delete();
    }

    public function getSemestresCombo()
    {
        $fk_id_semestre = $this->request->getPost('fk_id_semestre');

        $query = $this->db->query('SELECT * FROM semestres');
        $semestres = $query->getResult();
        $html = '';

        if (!empty($semestres) && is_array($semestres)):
            foreach ($semestres as $semestre):
                $selected = ($fk_id_semestre == $semestre->id_semestre) ? ' selected' : '';
                $html .= '<option value="' . esc($semestre->id_semestre) . '"' . $selected . '>' . esc($semestre->nombre_semestre) . '</option>';
            endforeach;
        else:
            $html .= '<option value="">No hay semestres disponibles.</option>';
        endif;

        return $this->response->setBody($html);
    }

    public function mantenimientoSecciones()
    {
        $query = $this->db->query('SELECT * FROM secciones');
        $data['secciones'] = $query->getResult();

        return view('mantenimiento_secciones', $data);
    }

    public function getSecciones()
    {
        $query = $this->db->query('SELECT * FROM secciones');
        $secciones = $query->getResult();
        $html = '';

        $html .= '<table class="styled-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sección</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>';
        if (!empty($secciones) && is_array($secciones)):
            foreach ($secciones as $seccion):
                $html .= '<tr>
                        <td>' . esc($seccion->id_seccion) . '</td>
                        <td>' . esc($seccion->nombre_seccion) . '</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" onClick="getSeccionById(' . esc($seccion->id_seccion) . ')"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                            <button type="button" class="btn btn-danger btn-sm" onClick="eliminarSeccion(' . esc($seccion->id_seccion) . ')"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
                        </td>
                    </tr>';
            endforeach;
        else:
            $html .= '<tr>
                    <td colspan="3">No hay secciones disponibles.</td>
                </tr>';
        endif;
        $html .= '</tbody>
            </table>';

        return $html;
    }

    public function agregarSeccion()
    {
        $nombre_seccion = $this->request->getPost('nombre_seccion');

        $this->db->table('secciones')->insert(['nombre_seccion' => $nombre_seccion]);
    }

    public function getSeccionById()
    {
        $id_seccion = $this->request->getPost('id_seccion');

        $query = $this->db->query('SELECT * FROM secciones WHERE id_seccion = ?', [$id_seccion]);
        $seccion = $query->getRow();

        return json_encode($seccion);
    }

    public function editarSeccion()
    {
        $id_seccion = $this->request->getPost('id_seccion');
        $nombre_seccion = $this->request->getPost('nombre_seccion');

        $this->db->table('secciones')->where('id_seccion', $id_seccion)->update(['nombre_seccion' => $nombre_seccion]);
    }

    public function eliminarSeccion()
    {
        $id_seccion = $this->request->getPost('id_seccion');

        $this->db->table('secciones')->where('id_seccion', $id_seccion)->delete();
    }

    public function mantenimientoCursos()
    {
        $query = $this->db->query('SELECT * FROM cursos');
        $data['cursos'] = $query->getResult();

        return view('mantenimiento_cursos', $data);
    }

    public function getCursos()
    {
        $query = $this->db->query('SELECT * FROM cursos a INNER JOIN semestres b ON a.fk_id_semestre = b.id_semestre');
        $cursos = $query->getResult();
        $html = '';

        $html .= '<table class="styled-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Semestre</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>';
        if (!empty($cursos) && is_array($cursos)):
            foreach ($cursos as $curso):
                $html .= '<tr>
                        <td>' . esc($curso->id_curso) . '</td>
                        <td>' . esc($curso->nombre_curso) . '</td>
                        <td>' . esc($curso->nombre_semestre) . '</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" onClick="getCursoById(' . esc($curso->id_curso) . ')"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                            <button type="button" class="btn btn-danger btn-sm" onClick="eliminarCurso(' . esc($curso->id_curso) . ')"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
                        </td>
                    </tr>';
            endforeach;
        else:
            $html .= '<tr>
                    <td colspan="3">No hay cursos disponibles.</td>
                </tr>';
        endif;
        $html .= '</tbody>
            </table>';

        return $html;
    }

    public function agregarCurso()
    {
        $nombre_curso = $this->request->getPost('nombre_curso');
        $fk_id_semestre = $this->request->getPost('fk_id_semestre');

        $this->db->table('cursos')->insert(['nombre_curso' => $nombre_curso, 'fk_id_semestre' => $fk_id_semestre]);
    }

    public function getCursoById()
    {
        $id_curso = $this->request->getPost('id_curso');

        $query = $this->db->query('SELECT * FROM cursos WHERE id_curso = ?', [$id_curso]);
        $curso = $query->getRow();

        return json_encode($curso);
    }

    public function editarCurso()
    {
        $id_curso = $this->request->getPost('id_curso');
        $nombre_curso = $this->request->getPost('nombre_curso');
        $fk_id_semestre = $this->request->getPost('fk_id_semestre');

        $this->db->table('cursos')->where('id_curso', $id_curso)->update(['nombre_curso' => $nombre_curso, 'fk_id_semestre' => $fk_id_semestre]);
    }

    public function eliminarCurso()
    {
        $id_curso = $this->request->getPost('id_curso');

        $this->db->table('cursos')->where('id_curso', $id_curso)->delete();
    }

    public function mantenimientoEstudiantes()
    {
        $query = $this->db->query('SELECT * FROM estudiantes');
        $data['estudiantes'] = $query->getResult();

        return view('mantenimiento_estudiantes', $data);
    }

    public function getEstudiantes()
    {
        $query = $this->db->query('SELECT * FROM estudiantes a INNER JOIN carreras b ON a.fk_carrera_id = b.id_carrera');
        $estudiantes = $query->getResult();
        $html = '';

        $html .= '<table class="styled-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Estudiante</th>
                        <th scope="col">Fecha Nacimiento</th>
                        <th scope="col">Carrera</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>';
        if (!empty($estudiantes) && is_array($estudiantes)):
            foreach ($estudiantes as $estudiante):
                $html .= '<tr>
                        <td>' . esc($estudiante->id_estudiante) . '</td>
                        <td>' . esc($estudiante->nombre) . ' ' . esc($estudiante->apellido) . '</td>
                        <td>' . esc($estudiante->fecha_nacimiento) . '</td>
                        <td>' . esc($estudiante->nombre_carrera) . '</td>
                        <td nowrap>
                            <button type="button" class="btn btn-primary btn-sm" onClick="getEstudianteById(' . esc($estudiante->id_estudiante) . ')"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                            <button type="button" class="btn btn-danger btn-sm" onClick="eliminarEstudiante(' . esc($estudiante->id_estudiante) . ')"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
                        </td>
                    </tr>';
            endforeach;
        else:
            $html .= '<tr>
                    <td colspan="3">No hay estudiantes disponibles.</td>
                </tr>';
        endif;
        $html .= '</tbody>
            </table>';

        return $html;
    }

    public function agregarEstudiante()
    {
        $nombre = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $fecha_nacimiento = $this->request->getPost('fecha_nacimiento');
        $fk_carrera_id = $this->request->getPost('fk_carrera_id');

        $file = $this->request->getFile('fotografia');
        $uploadPath = FCPATH . 'uploads';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $fotografia = $newName;
        } else {
            $fotografia = null;
        }

        $data = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'fecha_nacimiento' => $fecha_nacimiento,
            'fk_carrera_id' => $fk_carrera_id,
            'fotografia' => $fotografia
        ];

        $this->db->table('estudiantes')->insert($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function getEstudianteById()
    {
        $id_estudiante = $this->request->getPost('id_estudiante');

        $query = $this->db->query('SELECT * FROM estudiantes WHERE id_estudiante = ?', [$id_estudiante]);
        $estudiante = $query->getRow();

        return json_encode($estudiante);
    }

    public function editarEstudiante()
    {
        $id_estudiante = $this->request->getPost('id_estudiante');
        $nombre = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $fecha_nacimiento = $this->request->getPost('fecha_nacimiento');
        $fk_carrera_id = $this->request->getPost('fk_carrera_id');

        $file = $this->request->getFile('fotografia');
        $uploadPath = FCPATH . 'uploads';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $fotografia = $newName;
        } else {
            $fotografia = null;
        }

        $data = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'fecha_nacimiento' => $fecha_nacimiento,
            'fk_carrera_id' => $fk_carrera_id
        ];

        if ($fotografia !== null) {
            $data['fotografia'] = $fotografia;
        }

        $this->db->table('estudiantes')->where('id_estudiante', $id_estudiante)->update($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function eliminarEstudiante()
    {
        $id_estudiante = $this->request->getPost('id_estudiante');

        $this->db->table('estudiantes')->where('id_estudiante', $id_estudiante)->delete();
    }

    public function getCarrerasCombo()
    {
        $fk_carrera_id = $this->request->getPost('fk_carrera_id');

        $query = $this->db->query('SELECT * FROM carreras');
        $carreras = $query->getResult();
        $html = '';

        if (!empty($carreras) && is_array($carreras)):
            foreach ($carreras as $carrera):
                $selected = ($fk_carrera_id == $carrera->id_carrera) ? ' selected' : '';
                $html .= '<option value="' . esc($carrera->id_carrera) . '"' . $selected . '>' . esc($carrera->nombre_carrera) . '</option>';
            endforeach;
        else:
            $html .= '<option value="">No hay carreras disponibles.</option>';
        endif;

        return $this->response->setBody($html);
    }

    public function getEstudiantesCombo()
    {

        $query = $this->db->query('SELECT * FROM estudiantes');
        $estudiantes = $query->getResult();
        $html = '';

        if (!empty($estudiantes) && is_array($estudiantes)):
            foreach ($estudiantes as $estudiante):
                $html .= '<option value="' . esc($estudiante->id_estudiante) . '">' . esc($estudiante->nombre) . ' ' . esc($estudiante->apellido) . '</option>';
            endforeach;
        else:
            $html .= '<option value="">No hay estudiantes disponibles.</option>';
        endif;

        return $this->response->setBody($html);
    }

    public function getCursosCombo()
    {

        $query = $this->db->query('SELECT * FROM cursos');
        $cursos = $query->getResult();
        $html = '';

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

        $query = $this->db->query('SELECT * FROM secciones');
        $secciones = $query->getResult();
        $html = '';

        if (!empty($secciones) && is_array($secciones)):
            foreach ($secciones as $seccion):
                $html .= '<option value="' . esc($seccion->id_seccion) . '">' . esc($seccion->nombre_seccion) . '</option>';
            endforeach;
        else:
            $html .= '<option value="">No hay secciones disponibles.</option>';
        endif;

        return $this->response->setBody($html);
    }
}
