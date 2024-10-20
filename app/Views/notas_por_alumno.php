<?= $this->include('templates/header'); ?>
<?= $this->include('templates/sidebar'); ?>

<main class="main">
    <h2><i class="fa-solid fa-file-pdf"></i> Notas por Alumno</h2>
    <div class="card">
        <div class="card-header">
            Buscar Estudiante
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-3 input-div">
                    <label>Carrera</label>
                    <select class="form-control" id="id_carrera"">
                    </select>
                </div>
                <div class=" col-md-3 input-div">
                        <label>Cursos</label>
                        <select class="form-control" id="id_curso">
                        </select>
                </div>
                <div class=" col-md-3 input-div">
                    <label>Secciones</label>
                    <select class="form-control" id="id_seccion">
                    </select>
                </div>
                <div class="col-md-3 input-div d-flex align-items-center">
                    <button type="button" class="btn card-button" onclick="getTableReporte()"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container" id="table-container">

    </div>
</main>

<script>
    $(document).ready(function() {
        getCarrerasCombo();
        getCursosCombo();
        getSeccionesCombo();

        $('#mantenimientoModal').on('show.bs.modal', function() {
            $(this).removeAttr('inert');
        });

        $('#mantenimientoModal').on('hidden.bs.modal', function() {
            $(this).attr('aria-hidden', 'true');
        });
    });

    function getCarrerasCombo() {
        $.ajax({
            url: '<?= base_url('reportes/getCarrerasCombo'); ?>',
            type: 'get',
            success: function(response) {
                $('#id_carrera').html(response);
            }
        });
    }

    function getTableReporte() {
        var id_carrera = $('#id_carrera').val();
        var id_curso = $('#id_curso').val();
        var id_seccion = $('#id_seccion').val();

        $.ajax({
            url: '<?= base_url('reportes/getNotasAlumnoTable'); ?>',
            type: 'post',
            data: {
                id_carrera: id_carrera,
                id_curso: id_curso,
                id_seccion: id_seccion
            },
            success: function(response) {
                $('#table-container').html(response);
            }
        });

    }

    function descargarReporte() {
        var element = document.getElementById('notas_alumno_reporte');
        var opt = {
            margin: 0.2, // Reducir el margen a 0.2 pulgadas
            filename: 'reporte_notas_alumnos.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
            }
        };

        html2pdf().set(opt).from(element).save();
    }


    function getCursosCombo() {

        $.ajax({
            url: '<?= base_url('reportes/getCursosCombo'); ?>',
            type: 'get',
            success: function(response) {
                $('#id_curso').html(response);
            }
        });
    }

    function getSeccionesCombo() {
        $.ajax({
            url: '<?= base_url('reportes/getSeccionesCombo'); ?>',
            type: 'get',
            success: function(response) {
                $('#id_seccion').html(response);
            }
        });
    }
</script>
<nav class="navbar">
    <i class="fa-solid fa-bars" id="sidebar-close"></i>
</nav>

<?= $this->include('templates/footer'); ?>