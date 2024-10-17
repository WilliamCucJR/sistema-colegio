<nav class="sidebar">
    <center><a href="<?= base_url('dashboard'); ?>" class="logo"><img src="<?= base_url('img/proyecto_logo.png'); ?>" alt="Logo" width="225px"> </a></center>
    <div class="menu-content">
        <ul class="menu-items">
            <li class="item">
                <a href="<?= base_url('dashboard'); ?>"><i class="fa-solid fa-house"></i> Inicio</a>
            </li>
            <li class="item">
                <a href="<?= base_url('asignar-cursos'); ?>"><i class="fa-solid fa-list"></i> Asignar cursos</a>
            </li>
            <li class="item">
                <a href="<?= base_url('agregar-notas'); ?>"><i class="fa-solid fa-check"></i> Ingresar Notas</a>
            </li>
            <li class="item">
                <div class="submenu-item">
                    <span><i class="fa-solid fa-gear"></i> Mantenimiento</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
                <ul class="menu-items submenu">
                    <div class="menu-title">
                        <i class="fa-solid fa-chevron-left"></i>
                        Mantenimiento
                    </div>
                    <li class="item">
                        <a href="<?= base_url('mantenimiento/mantenimiento-estudiantes'); ?>"><i class="fa-solid fa-user-graduate"></i> Estudiantes</a>
                    </li>
                    <li class="item">
                        <a href="<?= base_url('mantenimiento/mantenimiento-carreras'); ?>"><i class="fa-solid fa-graduation-cap"></i> Carreras</a>
                    </li>
                    <li class="item">
                        <a href="<?= base_url('mantenimiento/mantenimiento-semestre'); ?>"><i class="fa-solid fa-arrow-up-9-1"></i> Semestres</a>
                    </li>
                    <li class="item">
                        <a href="<?= base_url('mantenimiento/mantenimiento-secciones'); ?>"><i class="fa-solid fa-bars"></i> Secciónes</a>
                    </li>
                    <li class="item">
                        <a href="<?= base_url('mantenimiento/mantenimiento-cursos'); ?>"><i class="fa-solid fa-puzzle-piece"></i> Cursos</a>
                    </li>
                </ul>
            </li>
            <li class="item">
                <div class="submenu-item">
                    <span><i class="fa-solid fa-file-pdf"></i> Reportes</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
                <ul class="menu-items submenu">
                    <div class="menu-title">
                        <i class="fa-solid fa-chevron-left"></i>
                        Reportes
                    </div>
                    <li class="item">
                        <a href="<?= base_url('reportes/alumnos-por-carrera'); ?>"><i class="fa-solid fa-file-pdf"></i> Alumnos por carrera</a>
                    </li>
                    <li class="item">
                        <a href="<?= base_url('reportes/notas-por-alumno'); ?>"><i class="fa-solid fa-file-pdf"></i> Notas por alumno</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<nav class="navbar">
    <i class="fa-solid fa-bars" id="sidebar-close"></i>
</nav>