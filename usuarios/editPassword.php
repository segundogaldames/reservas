<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/usuarioModel.php');

    $session = new Session;

    $usuarios = new UsuarioModel;

    $title = 'Cambiar Password';

    if (isset($_GET['usuario'])) {
        $id = (int) $_GET['usuario'];

        $usuario = $usuarios->getUsuarioId($id);

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {

            $clave = trim(strip_tags($_POST['clave'])); //sanitizacion basica
            $reclave = trim(strip_tags($_POST['reclave']));

            if (empty($clave) || strlen($clave) < 8) {
                $msg = 'Ingrese el password de la cuenta con al menos 8 caracteres';
            }elseif ($reclave != $clave) {
                $msg = 'Los passwords ingresados no coinciden';
            }else{
                $usu = $usuarios->editPassword($id, $clave);

                if ($usu) {
                    $_SESSION['success'] = 'El password se ha modificado correctamente';
                    header('Location: ' . SHOW_EMPLEADO . $usuario['empleado_id']);
                }
            }

            //print_r($nombre);
        }

    }


?>
<?php if(isset($_SESSION['autenticado']) && $_SESSION['usuario_rol'] == 'Administrador' || ($_SESSION['usuario_id']) == $usuario['id']): ?>
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

            <?php if($usuario): ?>
                <form name="form" action="" method="post">
                    <div class="mb-3">
                        <label for="clave" class="form-label">Empleado: <?php echo $usuario['empleado']; ?> </label>
                    </div>
                    <div class="mb-3">
                        <label for="clave" class="form-label">Password<span class="text-danger">*</span>  </label>
                        <input type="password" name="clave" class="form-control" oncopy="return false" onpaste="return false" aria-describedby="usuarioHelpInline">
                        <div id="usuarioHelp" class="form-text text-danger">Ingrese el password del Empleado</div>
                    </div>

                    <div class="mb-3">
                        <label for="reclave" class="form-label">Confirmar Password<span class="text-danger">*</span>  </label>
                        <input type="password" name="reclave" class="form-control" oncopy="return false" onpaste="return false" aria-describedby="usuarioHelpInline">
                        <div id="usuarioHelp" class="form-text text-danger">Confirme el password del Empleado</div>
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="confirm" value="1">
                        <button type="submit" class="btn btn-outline-success">Editar</button>
                        <a href="<?php echo SHOW_EMPLEADO . $usuario['empleado_id']; ?>" class="btn btn-outline-primary">Volver</a>
                    </div>
                </form>
            <?php else: ?>
                <p class="text-info">El password no pudo ser modificado</p>
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