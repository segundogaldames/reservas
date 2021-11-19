<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/pacienteModel.php');

    $session = new Session;

    if (isset($_GET['paciente'])) {
        $id = (int) $_GET['paciente'];

        $pacientes = new PacienteModel;

        $paciente = $pacientes->getPacienteId($id);

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {

            $nombre = trim(strip_tags($_POST['nombre']));
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $fonasa = filter_var($_POST['fonasa'], FILTER_VALIDATE_INT);

            if (!$nombre) {
                $msg = 'Ingrese el nombre del paciente';
            }elseif (!$email) {
                $msg = 'Ingrese un email válido';
            }elseif (!$fonasa) {
                $msg = 'Seleccione la prevision de salud del paciente';
            }else{
                $pac = $pacientes->editPaciente($id, $nombre, $email, $fonasa);

                if ($pac) {
                    $_SESSION['success'] = 'El paciente se ha modificado correctamente';
                    header('Location: ' . SHOW_PACIENTE . $id);
                }
            }
        }

    }

    $title = 'Editar Paciente';

?>
<?php if(isset($_SESSION['autenticado'])): ?>
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
            <h4><?php echo $title; ?> </h4>

            <?php if(isset($msg)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <p class="text-danger">Campos obligatorios *</p>

            <?php if($paciente): ?>
                <form name="form" action="" method="post">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span>  </label>
                        <input type="text" name="nombre" value="<?php echo $paciente['nombre']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                        <div id="empleadoHelp" class="form-text text-danger">Ingrese el nombre del Paciente</div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email<span class="text-danger">*</span>  </label>
                        <input type="email" name="email" value="<?php echo $paciente['email']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                        <div id="empleadoHelp" class="form-text text-danger">Ingrese el email del Paciente</div>
                    </div>

                    <div class="mb-3">
                        <label for="fonasa" class="form-label">Previsión de salud<span class="text-danger">*</span>  </label>
                        <select name="fonasa" class="form-control">
                            <option value="<?php echo $paciente['fonasa'] ?>">
                                <?php
                                    if ($paciente['fonasa'] == 1) {
                                        echo 'Fonasa';
                                    }else {
                                        echo 'Isapre';
                                    }
                                ?>
                            </option>

                            <option value="">Seleccione...</option>
                            <option value="1">Fonasa</option>
                            <option value="2">Isapre</option>
                        </select>
                        <div id="empleadoHelp" class="form-text text-danger">Seleccione la previsión de salud del Paciente</div>
                    </div>

                    <div class="mb-3">
                        <input type="hidden" name="confirm" value="1">
                        <button type="submit" class="btn btn-outline-success">Editar</button>
                        <a href="<?php echo SHOW_PACIENTE . $id; ?>" class="btn btn-outline-primary">Volver</a>
                    </div>

                </form>
            <?php else: ?>
                <p class="text-ifo">No hay datos</p>
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