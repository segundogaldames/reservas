<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">RESERVAS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL; ?>">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contacto</a>
                </li>
                <?php if( isset($_SESSION['autenticado']) && ($_SESSION['usuario_rol'] == 'Administrador' || $_SESSION['usuario_rol'] == 'Supervisor')):  ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Administrar
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo HORARIOS; ?>">Horarios</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo ROLES; ?>">Roles</a></li>
                            <li><a class="dropdown-item" href="<?php echo ESPECIALIDADES; ?>">Especialidades</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo EMPLEADOS; ?>">Empleados</a></li>
                            <li><a class="dropdown-item" href="<?php echo PACIENTES; ?>">Pacientes</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(!isset($_SESSION['autenticado'])): ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo LOGIN; ?>">Iniciar Sesión</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['usuario_nombre'] ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo SHOW_EMPLEADO . $_SESSION['usuario_empleado']; ?>">Mi Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo LOGOUT; ?>">Cerrar Sesión</a></li>
                    </ul>
                </li>

                <?php endif; ?>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>