<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/usuarioModel.php');

    session_start();

    $usuarios = new UsuarioModel;

    $title = 'Login';

    if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $clave = trim(strip_tags($_POST['clave']));

        if (!$email) {
           $msg = 'Ingrese un email válido';
        }elseif (!$clave) {
            $msg = 'Ingrese su password';
        }else {
            $usuario = $usuarios->getUsuarioEmailClave($email, $clave);

            if ($usuario) {
                # code...
            }
        }
    }

?>
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


            <form name="form" action="" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email<span class="text-danger">*</span>  </label>
                    <input type="email" name="email" class="form-control" oncopy="return false" onpaste="return false" aria-describedby="usuarioHelpInline">
                    <div id="usuarioHelp" class="form-text text-danger">Ingrese su correo electrónico</div>
                </div>

                <div class="mb-3">
                    <label for="clave" class="form-label">Password<span class="text-danger">*</span>  </label>
                    <input type="password" name="clave" class="form-control" oncopy="return false" onpaste="return false" aria-describedby="usuarioHelpInline">
                    <div id="usuarioHelp" class="form-text text-danger">Ingrese su password o contraseña</div>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="confirm" value="1">
                    <button type="submit" class="btn btn-outline-success">Ingresar</button>
                    <a href="<?php echo BASE_URL ?>" class="btn btn-outline-primary">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</body>
</html>
