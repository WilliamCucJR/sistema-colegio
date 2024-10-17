<?= $this->include('templates/header'); ?>
<?= $this->include('templates/sidebar'); ?>

<main class="main">
    <h2><i class="fa-solid fa-puzzle-piece"></i>Cursos</h2>
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
                            <label>ID Curso</label>
                            <input type="text" class="form-control" id="id_curso" name="id_curso">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-div">
                            <label>Curso</label>
                            <input type="text" class="form-control" id="nombre_curso" placeholder="Curso">
                        </div>
                        <div class="col-md-6 input-div">
                            <label>Semestre</label>
                            <select class="form-control" id="fk_id_semestre">
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-button" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary modal-button" onclick="agregarEditarCurso()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        getCursos();
        getSemestresCombo();

        $('#mantenimientoModal').on('show.bs.modal', function() {
            $(this).removeAttr('inert');
        });

        $('#mantenimientoModal').on('hidden.bs.modal', function() {
            $(this).attr('aria-hidden', 'true');
            $('#id_curso').val('');
            $('#nombre_curso').val('');
            getSemestresCombo();
        });
    });

    function getCursos() {
        $.ajax({
            url: '<?= base_url('mantenimiento/getCursos'); ?>',
            type: 'GET',
            success: function(response) {
                $('#table-container').html(response);
            }
        });
    }

    function agregarEditarCurso() {
        var nombre_curso = $('#nombre_curso').val();
        var id_curso = $('#id_curso').val();
        var fk_id_semestre = $('#fk_id_semestre').val();
        var ruta = '';

        if (nombre_curso.trim() === '' || fk_id_semestre.trim() === '') {
            Swal.fire({
                title: "Error",
                text: "Los campos no pueden estar vacios",
                icon: "error",
                timer: 3000,
                showConfirmButton: false
            });
            return;
        }

        if (id_curso != '') {
            ruta = '<?= base_url('mantenimiento/editarCurso'); ?>';
        } else {
            ruta = '<?= base_url('mantenimiento/agregarCurso'); ?>';
        }

        $.ajax({
            url: ruta,
            type: 'POST',
            data: {
                nombre_curso: nombre_curso,
                fk_id_semestre: fk_id_semestre,
                id_curso: id_curso
            },
            success: function(response) {
                Swal.fire({
                    title: "OK",
                    text: "Registro guardado exitosamente!",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    getCursos();
                    $('#mantenimientoModal').modal('hide');
                });
            }
        });
    }

    function getCursoById(id_curso) {
        $.ajax({
            url: '<?= base_url('mantenimiento/getCursoById'); ?>',
            type: 'POST',
            data: {
                id_curso: id_curso
            },
            success: function(response) {
                var data = JSON.parse(response);
                $('#nombre_curso').val(data.nombre_curso);
                $('#id_curso').val(data.id_curso);
                getSemestresCombo(data.fk_id_semestre);
                $('#mantenimientoModal').modal('show');
            }
        });
    }

    function eliminarCurso(id_curso) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Este cambio no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('mantenimiento/eliminarCurso'); ?>',
                    type: 'POST',
                    data: {
                        id_curso: id_curso
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "OK",
                            text: "Registro eliminado exitosamente!",
                            icon: "success",
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            getCursos();
                        });
                    }
                });
            }
        });
    }

    function getSemestresCombo(fk_id_semestre = '') {
        $.ajax({
            url: '<?= base_url('mantenimiento/getSemestresCombo'); ?>',
            type: 'POST',
            data: {
                fk_id_semestre: fk_id_semestre
            },
            success: function(response) {
                $('#fk_id_semestre').html(response);
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