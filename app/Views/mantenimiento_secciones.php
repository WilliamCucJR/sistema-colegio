<?= $this->include('templates/header'); ?>
<?= $this->include('templates/sidebar'); ?>

<main class="main">
    <h2><i class="fa-solid fa-bars"></i> Secciones</h2>
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
                            <label>ID Seccion</label>
                            <input type="text" class="form-control" id="id_seccion" name="id_seccion">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 input-div">
                            <label>Carrera</label>
                            <input type="text" class="form-control" id="nombre_seccion" placeholder="Seccion">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-button" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary modal-button" onclick="agregarEditarSeccion()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        getSecciones();

        $('#mantenimientoModal').on('show.bs.modal', function() {
            $(this).removeAttr('aria-hidden');
        });

        $('#mantenimientoModal').on('hidden.bs.modal', function() {
            $(this).attr('aria-hidden', 'true');
            $('#id_seccion').val('');
            $('#nombre_seccion').val('');
        });
    });

    function getSecciones() {
        $.ajax({
            url: '<?= base_url('mantenimiento/getSecciones'); ?>',
            type: 'GET',
            success: function(response) {
                $('#table-container').html(response);
            }
        });
    }

    function agregarEditarSeccion() {
        var nombre_seccion = $('#nombre_seccion').val();
        var id_seccion = $('#id_seccion').val();
        var ruta = '';

        if (nombre_seccion.trim() === '') {
            Swal.fire({
                title: "Error",
                text: "El campo 'Nombre de la Sección' es obligatorio.",
                icon: "error",
                timer: 3000,
                showConfirmButton: false
            });
            return;
        }

        if (id_seccion != '') {
            ruta = '<?= base_url('mantenimiento/editarSeccion'); ?>';
        } else {
            ruta = '<?= base_url('mantenimiento/agregarSeccion'); ?>';
        }

        $.ajax({
            url: ruta,
            type: 'POST',
            data: {
                nombre_seccion: nombre_seccion,
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
                    getSecciones();
                    $('#mantenimientoModal').modal('hide');
                });
            }
        });
    }

    function getSeccionById(id_seccion) {
        $.ajax({
            url: '<?= base_url('mantenimiento/getSeccionById'); ?>',
            type: 'POST',
            data: {
                id_seccion: id_seccion
            },
            success: function(response) {
                var data = JSON.parse(response);
                $('#nombre_seccion').val(data.nombre_seccion);
                $('#id_seccion').val(data.id_seccion);
                $('#mantenimientoModal').modal('show');
            }
        });
    }

    function eliminarSeccion(id_seccion) {
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
                    url: '<?= base_url('mantenimiento/eliminarSeccion'); ?>',
                    type: 'POST',
                    data: {
                        id_seccion: id_seccion
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "OK",
                            text: "Registro eliminado exitosamente!",
                            icon: "success",
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            getSecciones();
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