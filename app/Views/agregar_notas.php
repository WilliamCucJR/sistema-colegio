<?= $this->include('templates/header'); ?>
<?= $this->include('templates/sidebar'); ?>

<main class="main">
    <h2><i class="fa-solid fa-list"></i> Ingresar Notas</h2>
    <div class="card">
        <div class="card-header">
            Buscar Estudiante
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8 input-div">
                    <label>Estudiante</label>
                    <select class="form-control" id="id_estudiante">
                    </select>
                </div>
                <div class="col-md-4 input-div d-flex align-items-center">
                    <button type="button" class="btn card-button" onclick="getAsignaciones()"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                </div>
            </div>
        </div>
    </div>

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
                            <label>ID Asignacion</label>
                            <input type="text" class="form-control" id="id_asignacion" name="id_asignacion">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-div">
                            <label>Estudiante</label>
                            <input type="text" class="form-control" id="estudiante" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-div">
                            <label>Curso</label>
                            <input type="text" class="form-control" id="curso" disabled>
                        </div>
                        <div class="col-md-6 input-div">
                            <label>Sección</label>
                            <input type="text" class="form-control" id="seccion" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 input-div">
                            <label>1er Parcial</label>
                            <input type="text" class="form-control" id="primer_parcial">
                        </div>
                        <div class="col-md-3 input-div">
                            <label>2do Parcial</label>
                            <input type="text" class="form-control" id="segundo_parcial">
                        </div>
                        <div class="col-md-3 input-div">
                            <label>Final</label>
                            <input type="text" class="form-control" id="final">
                        </div>
                        <div class="col-md-3 input-div">
                            <label>Zona</label>
                            <input type="text" class="form-control" id="zona">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-button" data-dismiss="modal"><i class="fa-solid fa-x"></i> Cerrar</button>
                <button type="button" class="btn btn-primary modal-button" onclick="ingresarNotas()"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        getEstudiantes();

        $('#mantenimientoModal').on('show.bs.modal', function() {
            $(this).removeAttr('inert');
        });

        $('#mantenimientoModal').on('hidden.bs.modal', function() {
            $(this).attr('aria-hidden', 'true');
        });
    });

    function getAsignaciones() {
        var id_estudiante = $('#id_estudiante').val();

        $.ajax({
            url: '<?= base_url('procesos/getAsignacionesByEstudiante'); ?>',
            type: 'POST',
            data: {
                id_estudiante: id_estudiante
            },
            success: function(response) {
                $('#table-container').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
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

    function getAsignacionById(id_asignacion) {
        $.ajax({
            url: '<?= base_url('procesos/getAsignacionById'); ?>',
            type: 'POST',
            data: {
                id_asignacion: id_asignacion
            },
            success: function(response) {
                var data = JSON.parse(response);
                $('#id_asignacion').val(data.id_asignacion);
                $('#estudiante').val(data.nombre);
                $('#curso').val(data.nombre_curso);
                $('#seccion').val(data.nombre_seccion);
                $('#primer_parcial').val(data.nota_primer_parcial);
                if (data.nota_primer_parcial > 0) {
                    $('#primer_parcial').attr('readonly', true);
                } else {
                    $('#primer_parcial').attr('readonly', false);
                }
                $('#segundo_parcial').val(data.nota_segundo_parcial);
                if (data.nota_segundo_parcial > 0) {
                    $('#segundo_parcial').attr('readonly', true);
                } else {
                    $('#segundo_parcial').attr('readonly', false);
                }
                $('#final').val(data.nota_examen_final);
                if (data.nota_examen_final > 0) {
                    $('#final').attr('readonly', true);
                } else {
                    $('#final').attr('readonly', false);
                }
                $('#zona').val(data.zona);
                if (data.zona > 0) {
                    $('#zona').attr('readonly', true);
                } else {
                    $('#zona').attr('readonly', false);
                }
                $('#mantenimientoModal').modal('show');
            }
        });
    }

    function ingresarNotas() {
        var id_asignacion = $('#id_asignacion').val();
        var primer_parcial = $('#primer_parcial').val();
        var segundo_parcial = $('#segundo_parcial').val();
        var final = $('#final').val();
        var zona = $('#zona').val();

        $.ajax({
            url: '<?= base_url('procesos/ingresarNotas'); ?>',
            type: 'POST',
            data: {
                id_asignacion: id_asignacion,
                primer_parcial: primer_parcial,
                segundo_parcial: segundo_parcial,
                final: final,
                zona: zona
            },
            success: function(response) {
                Swal.fire({
                    title: "Correcto",
                    text: "Notas ingresada correctamente",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                });
                $('#mantenimientoModal').modal('hide');
                getAsignaciones();
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