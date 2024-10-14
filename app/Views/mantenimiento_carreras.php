<?= $this->include('templates/header'); ?>
<?= $this->include('templates/sidebar'); ?>

<main class="main">
    <h2><i class="fa-solid fa-graduation-cap"></i>Carreras</h2>
    <button type="button" class="btn modal-button" data-toggle="modal" data-target="#exampleModal">
        <i class="fa-solid fa-plus"></i> Agregar
    </button>
    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
            </tbody>
        </table>
    </div>
</main>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Modal header content -->
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 input-div">
                            <label>Nombres</label>
                            <input type="text" class="form-control" id="nombres" placeholder="Nombres">
                        </div>
                        <div class="col-md-6 input-div">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" placeholder="Apellidos">
                        </div>
                        <div class="col-md-6 input-div">
                            <label>Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" placeholder="Nombres">
                        </div>
                        <div class="col-md-6 input-div">
                            <label>Carrera</label>
                            <select id="fk_carrera_id" class="form-control">
                                <option selected>Seleccionar...</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="col-md-6 input-div">
                            <label for="exampleFormControlFile1">Archivo</label>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-button" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary modal-button">Guardar</button>
            </div>
        </div>
    </div>
</div>
<nav class="navbar">
    <i class="fa-solid fa-bars" id="sidebar-close"></i>
</nav>

<?= $this->include('templates/footer'); ?>