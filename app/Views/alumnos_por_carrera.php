<?= $this->include('templates/header'); ?>
<?= $this->include('templates/sidebar'); ?>

<main class="main">
    <h2><i class="fa-solid fa-file-pdf"></i> Alumnos por Carrera</h2>
    <div class="card">
        <div class="card-header">
            Buscar Estudiante
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8 input-div">
                    <label>Carrera</label>
                    <select class="form-control" id="id_carrera">
                    </select>
                </div>
                <div class="col-md-4 input-div d-flex align-items-center">
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

        $.ajax({
            url: '<?= base_url('reportes/getAlumnosCarreraTable'); ?>',
            type: 'post',
            data: {
                id_carrera: id_carrera
            },
            success: function(response) {
                $('#table-container').html(response);
            }
        });

    }

    function descargarReporte() {
        var element = document.getElementById('alumnos_carrera_reporte');
        var opt = {
            margin: 0.2, // Reducir el margen a 0.2 pulgadas
            filename: 'reporte_alumnos_por_carrera.pdf',
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
</script>
<nav class="navbar">
    <i class="fa-solid fa-bars" id="sidebar-close"></i>
</nav>

<?= $this->include('templates/footer'); ?>