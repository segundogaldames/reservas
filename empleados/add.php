<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/empleadoModel.php');
    require('../class/rolModel.php');
    require('../class/especialidadModel.php');

    $session = new Session;

    $empleados = new EmpleadoModel;
    $rol = new RolModel;
    $especialidad = new EspecialidadModel;

    $roles = $rol->getRoles();
    $especialidades = $especialidad->getEspecialidades();

    if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
        //print_r($_POST);exit;
        $rut = trim(strip_tags($_POST['rut']));
        $nombre = trim(strip_tags($_POST['nombre']));
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $fecha_nacimiento = trim(strip_tags($_POST['fecha_nacimiento']));
        $rol = filter_var($_POST['rol'], FILTER_VALIDATE_INT);
        $especialidad = filter_var($_POST['especialidad'], FILTER_VALIDATE_INT);

        if (strlen($rut) < 9 || strlen($rut) > 10) {
            $msg = 'Ingrese el RUT del empleado';
        }elseif (strlen($nombre) < 4) {
            $msg = 'El nombre debe tener al menos 4 caracteres';
        }elseif (!$email) {
            $msg = 'Ingrese un email válido';
        }elseif (!$fecha_nacimiento) {
            $msg = 'Ingrese la fecha de nacimiento del empleado';
        }elseif (!$rol) {
            $msg = 'Seleccione el rol del empleado';
        }elseif (!$especialidad) {
            $msg = 'Seleccione la especialidad del empleado';
        }else{
            $empleado = $empleados->getEmpleadoRutEmail($rut, $email);

            if ($empleado) {
                $msg = 'Elrut o el email ingresados ya estan registrados... intente con otro';
            }else {
                $empleado = $empleados->addEmpleado($rut, $nombre, $email, $fecha_nacimiento, $rol, $especialidad);

                if ($empleado) {
                    $_SESSION['success'] = 'El empleado se ha registrado correctamente';
                    header('Location: ' . EMPLEADOS);
                }
            }
        }
    }

    //$empleado = $empleados->getEmpleadoRutEmail($rut, $email);

    //print_r($roles);exit;

    $title = 'Nuevo Empleado';

?>
<?php if(isset($_SESSION['autenticado']) && $_SESSION['usuario_rol'] == 'Administrador'): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo TITLE . $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php include('../partials/menu.php'); ?>
    </header>
    <div class="container-fluid">
        <div class="col-md-6 offset-md-3">
            <h4><?php echo $title; ?></h4>

            <?php if(isset($msg)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <p class="text-danger">Campos obligatorios *</p>

            <form name="form" action="" method="post">
                <div class="mb-3">
                    <label for="rut" class="form-label">RUT<span class="text-danger">*</span>  </label>
                    <input type="text" name="rut" value="<?php if(isset($_POST['rut'])) echo $_POST['rut']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                    <div id="empleadoHelp" class="form-text text-danger">Ingrese el RUT del Empleado</div>
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span>  </label>
                    <input type="text" name="nombre" value="<?php if(isset($_POST['nombre'])) echo $_POST['nombre']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                    <div id="empleadoHelp" class="form-text text-danger">Ingrese el nombre del Empleado</div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email<span class="text-danger">*</span>  </label>
                    <input type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                    <div id="empleadoHelp" class="form-text text-danger">Ingrese el nombre del Empleado</div>
                </div>

                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento<span class="text-danger">*</span>  </label>
                    <input type="date" name="fecha_nacimiento" value="<?php if(isset($_POST['fecha_nacimiento'])) echo $_POST['fecha_nacimiento']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                    <div id="empleadoHelp" class="form-text text-danger">Ingrese la fecha de nacimiento del Empleado</div>
                </div>

                <div class="mb-3">
                    <label for="rol" class="form-label">Rol<span class="text-danger">*</span>  </label>
                    <select name="rol" class="form-control">
                        <option value="">Seleccione...</option>

                        <?php foreach($roles as $rol): ?>
                            <option value="<?php echo $rol['id']; ?>">
                                <?php echo $rol['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="empleadoHelp" class="form-text text-danger">Seleccione el rol del Empleado</div>
                </div>

                <div class="mb-3">
                    <label for="especialidad" class="form-label">Especialidad<span class="text-danger">*</span>  </label>
                    <select name="especialidad" class="form-control">
                        <option value="">Seleccione...</option>

                        <?php foreach($especialidades as $especialidad): ?>
                            <option value="<?php echo $especialidad['id']; ?>">
                                <?php echo $especialidad['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="empleadoHelp" class="form-text text-danger">Seleccione la especialidad del Empleado</div>
                </div>

                <div class="mb-3">
                    <input type="hidden" name="confirm" value="1">
                    <button type="submit" class="btn btn-outline-success">Guardar</button>
                    <a href="<?php echo EMPLEADOS; ?>" class="btn btn-outline-primary">Volver</a>
                </div>

            </form>
        </div>

    </div>

</body>
</html>
<?php else: ?>
    <?php
        header('Location: ' . LOGIN);
    ?>
<?php endif; ?>