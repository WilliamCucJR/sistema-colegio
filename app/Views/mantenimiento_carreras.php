<?= $this->include('templates/header'); ?>
<?= $this->include('templates/sidebar'); ?>

<main class="main">
    <h2><i class="fa-solid fa-graduation-cap"></i>Carreras</h2>
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
                            <input type="text" class="form-control" id="id_carrera" name="id_carrera">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 input-div">
                            <label>Carrera</label>
                            <input type="text" class="form-control" id="nombre_carrera" placeholder="Carrera">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-button" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary modal-button" onclick="agregarEditarCarrera()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        getCarreras();

        $('#mantenimientoModal').on('show.bs.modal', function() {
            $(this).removeAttr('inert');
        });

        $('#mantenimientoModal').on('hidden.bs.modal', function() {
            $(this).attr('aria-hidden', 'true');
            $('#id_carrera').val('');
            $('#nombre_carrera').val('');
        });
    });

    function getCarreras() {
        $.ajax({
            url: '<?= base_url('mantenimiento/getCarreras'); ?>',
            type: 'GET',
            success: function(response) {
                $('#table-container').html(response);
            }
        });
    }

    function agregarEditarCarrera() {
        var nombre_carrera = $('#nombre_carrera').val();
        var id_carrera = $('#id_carrera').val();
        var ruta = '';

        if (nombre_carrera.trim() === '') {
            Swal.fire({
                title: "Error",
                text: "El campo 'Nombre de la Carrera' es obligatorio.",
                icon: "error",
                timer: 3000,
                showConfirmButton: false
            });
            return;
        }

        if (id_carrera != '') {
            ruta = '<?= base_url('mantenimiento/editarCarrera'); ?>';
        } else {
            ruta = '<?= base_url('mantenimiento/agregarCarrera'); ?>';
        }

        $.ajax({
            url: ruta,
            type: 'POST',
            data: {
                nombre_carrera: nombre_carrera,
                id_carrera: id_carrera
            },
            success: function(response) {
                Swal.fire({
                    title: "OK",
                    text: "Registro guardado exitosamente!",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    getCarreras();
                    $('#mantenimientoModal').modal('hide');
                });
            }
        });
    }

    function getCarreraById(id_carrera) {
        $.ajax({
            url: '<?= base_url('mantenimiento/getCarreraById'); ?>',
            type: 'POST',
            data: {
                id_carrera: id_carrera
            },
            success: function(response) {
                var data = JSON.parse(response);
                $('#nombre_carrera').val(data.nombre_carrera);
                $('#id_carrera').val(data.id_carrera);
                $('#mantenimientoModal').modal('show');
            }
        });
    }

    function eliminarCarrera(id_carrera) {
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
                    url: '<?= base_url('mantenimiento/eliminarCarrera'); ?>',
                    type: 'POST',
                    data: {
                        id_carrera: id_carrera
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "OK",
                            text: "Registro eliminado exitosamente!",
                            icon: "success",
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            getCarreras();
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