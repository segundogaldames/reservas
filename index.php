<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('class/rutas.php');
    require('class/config.php');
    require('class/session.php');

    $session = new Session;

    $title = 'Bienvenido';

    // echo uniqid();
    // exit;

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
</head>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php include('partials/menu.php'); ?>
        <?php include('partials/mensajes.php'); ?>
    </header>
    <div class="container">
        <h1 class="text-center">Bienvenido al Sistema de Reservas de Horas Médicas</h1>
        <div class="col-md-6">
            <div class="list-group">
                <a href="<?php echo RESERVAS; ?>" class="list-group-item list-group-item-action">Ver Reservas</a>
                <a class="list-group-item list-group-item-action disabled">A disabled link item</a>
            </div>
        </div>

    </div>

</body>
</html>
