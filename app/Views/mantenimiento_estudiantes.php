<?= $this->include('templates/header'); ?>
<?= $this->include('templates/sidebar'); ?>

<main class="main">
    <h2><i class="fa-solid fa-user-graduate"></i> Estudiantes</h2>
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
                            <label>ID Estudiante</label>
                            <input type="text" class="form-control" id="id_estudiante" name="id_estudiante">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-div">
                            <label>Nombres</label>
                            <input type="text" class="form-control" id="nombre" placeholder="Nombres">
                        </div>
                        <div class="col-md-6 input-div">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" id="apellido" placeholder="Apellidos">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-div">
                            <label>Fecha Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" placeholder="Fecha Nacimiento">
                        </div>
                        <div class="col-md-6 input-div">
                            <label>Carrera</label>
                            <select class="form-control" id="fk_carrera_id">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-div">
                            <label>Fotografía</label>
                            <input type="file" class="form-control-file" id="fotografia">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-button" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary modal-button" onclick="agregarEditarEstudiante()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        getEstudiantes();
        getCarrerasCombo();

        $('#mantenimientoModal').on('show.bs.modal', function() {
            $(this).removeAttr('inert');
        });

        $('#mantenimientoModal').on('hidden.bs.modal', function() {
            $(this).attr('aria-hidden', 'true');
            $('#id_estudiante').val('');
            $('#nombre').val('');
            $('#apellido').val('');
            $('#fecha_nacimiento').val('');
            getCarrerasCombo();
        });
    });

    function getEstudiantes() {
        $.ajax({
            url: '<?= base_url('mantenimiento/getEstudiantes'); ?>',
            type: 'GET',
            success: function(response) {
                $('#table-container').html(response);
            }
        });
    }

    function agregarEditarEstudiante() {
        var nombre = $('#nombre').val();
        var apellido = $('#apellido').val();
        var fecha_nacimiento = $('#fecha_nacimiento').val();
        var fk_carrera_id = $('#fk_carrera_id').val();
        var id_estudiante = $('#id_estudiante').val();
        var fotografia = $('#fotografia')[0].files[0];
        var ruta = '';

        if (nombre.trim() === '' || apellido.trim() === '' || fecha_nacimiento.trim() === '' || fk_carrera_id.trim() === '') {
            Swal.fire({
                title: "Error",
                text: "Los campos no pueden estar vacíos!",
                icon: "error",
                timer: 3000,
                showConfirmButton: false
            });
            return;
        }

        if (id_estudiante != '') {
            ruta = '<?= base_url('mantenimiento/editarEstudiante'); ?>';
        } else {
            ruta = '<?= base_url('mantenimiento/agregarEstudiante'); ?>';
        }

        var formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('apellido', apellido);
        formData.append('fecha_nacimiento', fecha_nacimiento);
        formData.append('fk_carrera_id', fk_carrera_id);
        formData.append('id_estudiante', id_estudiante);
        formData.append('fotografia', fotografia);

        $.ajax({
            url: ruta,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    title: "OK",
                    text: "Registro guardado exitosamente!",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    getEstudiantes();
                    $('#mantenimientoModal').modal('hide');
                });
            }
        });
    }

    function getEstudianteById(id_estudiante) {
        $.ajax({
            url: '<?= base_url('mantenimiento/getEstudianteById'); ?>',
            type: 'POST',
            data: {
                id_estudiante: id_estudiante
            },
            success: function(response) {
                var data = JSON.parse(response);
                $('#nombre').val(data.nombre);
                $('#apellido').val(data.apellido);
                $('#fecha_nacimiento').val(data.fecha_nacimiento);
                getCarrerasCombo(data.fk_carrera_id);
                $('#id_estudiante').val(data.id_estudiante);
                $('#mantenimientoModal').modal('show');
            }
        });
    }

    function eliminarEstudiante(id_estudiante) {
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
                    url: '<?= base_url('mantenimiento/eliminarEstudiante'); ?>',
                    type: 'POST',
                    data: {
                        id_estudiante: id_estudiante
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "OK",
                            text: "Registro eliminado exitosamente!",
                            icon: "success",
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            getEstudiantes();
                        });
                    }
                });
            }
        });
    }

    function getCarrerasCombo(fk_carrera_id = '') {
        $.ajax({
            url: '<?= base_url('mantenimiento/getCarrerasCombo'); ?>',
            type: 'POST',
            data: {
                fk_carrera_id: fk_carrera_id
            },
            success: function(response) {
                $('#fk_carrera_id').html(response);
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