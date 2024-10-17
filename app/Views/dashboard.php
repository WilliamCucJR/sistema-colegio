<?= $this->include('templates/header'); ?>
<?= $this->include('templates/sidebar'); ?>

<main class="main">
    <h2><i class="fa-solid fa-house"></i> Inicio</h2>
    <div class="grid-container" id="table-container">

    </div>
</main>
<div class="modal fade" id="mantenimientoModal" tabindex="-1" role="dialog" aria-labelledby="mantenimientoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Modal header content -->
            </div>
            <div class="modal-body">
                <div id="ficha-response">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-button" data-dismiss="modal"><i class="fa-solid fa-x"></i> Cerrar</button>
                <button type="button" class="btn btn-danger modal-button-ficha" onclick="descargarFicha()"><i class="fa-solid fa-file-pdf"></i> Descargar</button>
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

    function getEstudiantes() {
        $.ajax({
            url: '<?= base_url('procesos/getEstudiantes'); ?>',
            type: 'GET',
            success: function(response) {
                $('#table-container').html(response);
            }
        });
    }


    function getEstudianteFicha(id_estudiante) {
        $.ajax({
            url: '<?= base_url('procesos/getEstudianteFicha'); ?>',
            type: 'POST',
            data: {
                id_estudiante: id_estudiante
            },
            success: function(response) {
                $('#ficha-response').html(response);
                $('#mantenimientoModal').modal('show');
            }
        });
    }

    function descargarFicha() {
        var element = document.getElementById('ficha-response');
        var opt = {
            margin: 0.2,
            filename: 'ficha_estudiante.pdf',
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