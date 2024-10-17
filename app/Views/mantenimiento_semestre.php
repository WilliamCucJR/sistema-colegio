<?= $this->include('templates/header'); ?>
<?= $this->include('templates/sidebar'); ?>

<main class="main">
    <h2><i class="fa-solid fa-arrow-up-9-1"></i>Semestres</h2>
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
                            <label>ID Semestre</label>
                            <input type="text" class="form-control" id="id_semestre" name="id_semestre">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 input-div">
                            <label>Semestre</label>
                            <input type="text" class="form-control" id="nombre_semestre" placeholder="Semestre">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-button" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary modal-button" onclick="agregarEditarSemestre()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        getSemestres();

        $('#mantenimientoModal').on('show.bs.modal', function() {
            $(this).removeAttr('aria-hidden');
        });

        $('#mantenimientoModal').on('hidden.bs.modal', function() {
            $(this).attr('aria-hidden', 'true');
            $('#id_semestre').val('');
            $('#nombre_semestre').val('');
        });
    });

    function getSemestres() {
        $.ajax({
            url: '<?= base_url('mantenimiento/getSemestres'); ?>',
            type: 'GET',
            success: function(response) {
                $('#table-container').html(response);
            }
        });
    }

    function agregarEditarSemestre() {
        var nombre_semestre = $('#nombre_semestre').val();
        var id_semestre = $('#id_semestre').val();
        var ruta = '';

        if (nombre_semestre.trim() === '') {
            Swal.fire({
                title: "Error",
                text: "El campo 'Nombre del Semestre' es obligatorio.",
                icon: "error",
                timer: 3000,
                showConfirmButton: false
            });
            return;
        }

        if (id_semestre != '') {
            ruta = '<?= base_url('mantenimiento/editarSemestre'); ?>';
        } else {
            ruta = '<?= base_url('mantenimiento/agregarSemestre'); ?>';
        }

        $.ajax({
            url: ruta,
            type: 'POST',
            data: {
                nombre_semestre: nombre_semestre,
                id_semestre: id_semestre
            },
            success: function(response) {
                Swal.fire({
                    title: "OK",
                    text: "Registro guardado exitosamente!",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    getSemestres();
                    $('#mantenimientoModal').modal('hide');
                });
            }
        });
    }

    function getSemestreById(id_semestre) {
        $.ajax({
            url: '<?= base_url('mantenimiento/getSemestreById'); ?>',
            type: 'POST',
            data: {
                id_semestre: id_semestre
            },
            success: function(response) {
                var data = JSON.parse(response);
                $('#nombre_semestre').val(data.nombre_semestre);
                $('#id_semestre').val(data.id_semestre);
                $('#mantenimientoModal').modal('show');
            }
        });
    }

    function eliminarSemestre(id_semestre) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('mantenimiento/eliminarSemestre'); ?>',
                    type: 'POST',
                    data: {
                        id_semestre: id_semestre
                    },
                    success: function(response) {
                        Swal.fire(
                            'Eliminado!',
                            'El registro ha sido eliminado.',
                            'success'
                        ).then(() => {
                            getSemestres();
                        });
                    }
                });
            }
        });
    }
</script>
<nav class="navbar">
    <i class="fa-solid fa-bars" id="sidebar-close"></i>
</nav>
<?= $this->include('templates/footer'); ?>