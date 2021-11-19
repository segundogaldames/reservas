<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/pacienteModel.php');

    #crear un objeto de la clase RolModel
    $session = new Session;
    $paciente = new PacienteModel;

    $title = 'Nuevo Paciente';

    if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {

        $rut = trim(strip_tags($_POST['rut']));
        $nombre = trim(strip_tags($_POST['nombre'])); //sanitizacion basica
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $fecha_nacimiento = trim(strip_tags($_POST['fecha_nacimiento']));
        $fonasa = filter_var($_POST['fonasa'], FILTER_VALIDATE_INT);

        if (strlen($rut) < 9 || strlen($rut) > 10) {
            $msg = 'Ingrese un RUT de al menos 9 caracteres';
        }elseif (!$nombre) {
            $msg = 'Ingrese el nombre del paciente';
        }elseif (!$email) {
            $msg = 'Ingrese el correo electrónico del paciente';
        }elseif (!$fecha_nacimiento) {
            $msg = 'Ingrese fecha de nacimiento del paciente';
        }elseif (!$fonasa) {
            $msg = 'Seleccione si es Fonasa o Isapre';
        }
        else{
            $res = $paciente->getPacienteRut($rut);

            if ($res) {
                $msg = 'El paciente ingresado ya existe... intente con otro';
            }else {

                $res = $paciente->addPaciente($rut, $nombre, $email, $fecha_nacimiento, $fonasa);

                if ($res) {
                    $_SESSION['success'] = 'El paciente se ha registrado correctamente';
                    header('Location: ' . PACIENTES);
                }
            }
        }

        //print_r($nombre);
    }

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
                    <label for="rut" class="form-label">RUT<span class="text-danger">*</span>  </label>
                    <input type="text" name="rut" value="<?php if(isset($_POST['rut'])) echo $_POST['rut']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                    <div id="empleadoHelp" class="form-text text-danger">Ingrese el RUT del Paciente (sin puntos y con guion)</div>
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span>  </label>
                    <input type="text" name="nombre" value="<?php if(isset($_POST['nombre'])) echo $_POST['nombre']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                    <div id="empleadoHelp" class="form-text text-danger">Ingrese el nombre del Paciente</div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email<span class="text-danger">*</span>  </label>
                    <input type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                    <div id="empleadoHelp" class="form-text text-danger">Ingrese el email del Paciente</div>
                </div>

                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento<span class="text-danger">*</span>  </label>
                    <input type="date" name="fecha_nacimiento" value="<?php if(isset($_POST['fecha_nacimiento'])) echo $_POST['fecha_nacimiento']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                    <div id="empleadoHelp" class="form-text text-danger">Ingrese la fecha de nacimiento del Paciente</div>
                </div>

                <div class="mb-3">
                    <label for="fonasa" class="form-label">Previsión<span class="text-danger">*</span>  </label>
                    <select name="fonasa" class="form-control">
                        <option value="">Seleccione...</option>
                        <option value="1">Fonasa</option>
                        <option value="2">Isapre</option>
                    </select>
                    <div id="empleadoHelp" class="form-text text-danger">Seleccione la previsión de salud del Paciente</div>
                </div>

                <div class="mb-3">
                    <input type="hidden" name="confirm" value="1">
                    <button type="submit" class="btn btn-outline-success">Guardar</button>
                    <a href="<?php echo PACIENTES; ?>" class="btn btn-outline-primary">Volver</a>
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