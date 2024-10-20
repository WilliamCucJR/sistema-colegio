<?= $this->include('templates/header'); ?>
<?= $this->include('templates/sidebar'); ?>

<main class="main">
    <h2><i class="fa-solid fa-list"></i> Asignar Cursos</h2>
    <button type="button" class="btn modal-button" data-toggle="modal" data-target="#mantenimientoModal">
        <i class="fa-solid fa-plus"></i> Agregar
    </button>
    <div class="table-container" id="table-container">

    </div>
</main>
<div class="modal fade" id="mantenimientoModal" tabindex="-1" role="dialog" aria-labelledby="mantenimientoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Modal header content -->
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12 input-div" style="display:none" readonly>
                            <label>ID Carrera</label>
                            <input type="text" class="form-control" id="id_asignacion" name="id_asignacion">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-div">
                            <label>Estudiante</label>
                            <select class="form-control" id="id_estudiante">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-div">
                            <label>Curso</label>
                            <select class="form-control" id="id_curso">
                            </select>
                        </div>
                        <div class="col-md-6 input-div">
                            <label>Sección</label>
                            <select class="form-control" id="id_seccion">
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-button" data-dismiss="modal"><i class="fa-solid fa-x"></i> Cerrar</button>
                <button type="button" class="btn btn-primary modal-button" onclick="agregarEditarAsignacion()"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        getAsignaciones();
        getEstudiantes();
        getCursosCombo();
        getSecciones();

        $('#mantenimientoModal').on('show.bs.modal', function() {
            $(this).removeAttr('inert');
        });

        $('#mantenimientoModal').on('hidden.bs.modal', function() {
            $(this).attr('aria-hidden', 'true');
        });
    });

    function getAsignaciones() {
        $.ajax({
            url: '<?= base_url('procesos/getAsignaciones'); ?>',
            type: 'GET',
            success: function(response) {
                $('#table-container').html(response);
            }
        });
    }

    function agregarEditarAsignacion() {
        var id_estudiante = $('#id_estudiante').val();
        var id_curso = $('#id_curso').val();
        var id_seccion = $('#id_seccion').val();
        var ruta = '';

        if (id_estudiante.trim() === '' || id_curso.trim() === '' || id_seccion.trim() === '') {
            Swal.fire({
                title: "Error",
                text: "Los campos no pueden estar vacios",
                icon: "error",
                timer: 3000,
                showConfirmButton: false
            });
            return;
        }

        ruta = '<?= base_url('procesos/agregarAsignacion'); ?>';

        $.ajax({
            url: ruta,
            type: 'POST',
            data: {
                id_estudiante: id_estudiante,
                id_curso: id_curso,
                id_seccion: id_seccion
            },
            success: function(response) {
                Swal.fire({
                    title: "OK",
                    text: "Registro guardado exitosamente!",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    getAsignaciones();
                    $('#mantenimientoModal').modal('hide');
                });
            }
        });
    }

    function getEstudiantes() {
        $.ajax({
            url: '<?= base_url('mantenimiento/getEstudiantesCombo'); ?>',
            type: 'POST',
            success: function(response) {
                $('#id_estudiante').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    function getCursosCombo() {
        $.ajax({
            url: '<?= base_url('mantenimiento/getCursosCombo'); ?>',
            type: 'POST',
            success: function(response) {
                $('#id_curso').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    function getSecciones() {
        var id_curso = $('#id_curso').val();

        $.ajax({
            url: '<?= base_url('mantenimiento/getSeccionesCombo'); ?>',
            type: 'POST',
            data: {
                id_curso: id_curso
            },
            success: function(response) {
                $('#id_seccion').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
</script>
<nav class="navbar">
    <i class="fa-solid fa-bars" id="sidebar-close"></i>
</nav>

<?= $this->include('templates/footer'); ?>