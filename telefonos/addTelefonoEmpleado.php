<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/telefonoModel.php');
    require('../class/empleadoModel.php');
    require('../class/usuarioModel.php');

    #crear un objeto de la clase RolModel
    $session = new Session;
    $telefonos = new TelefonoModel;
    $empleados = new EmpleadoModel;
    $usuarios = new UsuarioModel;

    if (isset($_GET['empleado'])) {
        $id_empleado = (int) $_GET['empleado'];

        $empleado = $empleados->getEmpleadoId($id_empleado);
        $usuario = $usuarios->getUsuarioEmpleado($id_empleado);

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
            $numero = filter_var($_POST['numero'], FILTER_VALIDATE_INT);

            if (strlen($numero) < 9 || strlen($numero) > 9) {
                $msg = 'El teléfono debe tener 9 dígitos';
            }else{
                $telefono = $telefonos->getTelefonoNumero($numero);

                if ($telefono) {
                    $msg = 'El teléfono ingresado ya existe... intente con otro';
                }else{
                    $type = 'Empleado';
                    $telefono = $telefonos->addTelefono($numero, $id_empleado, $type);

                    if ($telefono) {
                        $_SESSION['success'] = 'El teléfono se ha registrado correctamente';
                        header('Location: ' . SHOW_EMPLEADO . $id_empleado);
                    }
                }
            }
        }
    }

    $title = 'Nuevo Telefono';



?>
<?php if(isset($_SESSION['autenticado']) && $_SESSION['usuario_rol'] == 'Administrador' || $_SESSION['usuario_id'] == $usuario['id']): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo TITLE . $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
    <script src="../js/funciones.js"></script>
</head>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php include('../partials/menu.php'); ?>
    </header>
    <div class="container-fluid">
        <div class="col-md-6 offset-md-3">
            <h4><?php echo $title; ?></h4>

            <p class="text-danger">Campos obligatorios *</p>

            <?php if(isset($msg)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <?php if($empleado): ?>
                <form name="form" action="" method="post">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono<span class="text-danger">*</span>  </label>
                        <input type="number" name="numero" value="<?php if(isset($_POST['numero'])) echo $_POST['numero']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                        <div id="empleadoHelp" class="form-text text-danger">Ingrese el teléfono del Empleado con un maximo de 9 dígitos</div>
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="confirm" value="1">
                        <button type="submit" class="btn btn-outline-success">Guardar</button>
                        <a href="<?php echo SHOW_EMPLEADO . $id_empleado; ?>" class="btn btn-outline-primary">Volver</a>
                    </div>
                </form>
            <?php else: ?>
                <p class="text-info">No se pudo agregar el teléfono</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php else: ?>
    <?php
        header('Location: ' . LOGIN);
    ?>
<?php endif; ?>