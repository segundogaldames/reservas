<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/horarioModel.php');
    require('../class/especialidadModel.php');
    require('../class/pacienteModel.php');
    require('../class/reservaModel.php');

    $session = new Session;
    $pacientes = new PacienteModel;
    $horario = new HorarioModel;
    $especialidad = new EspecialidadModel;
    $reservas = new ReservaModel;

    if (isset($_GET['paciente'])) {
        $id_paciente = (int) $_GET['paciente'];

        $paciente = $pacientes->getPacienteId($id_paciente);
        $especialidades = $especialidad->getEspecialidades();
        $horarios = $horario->getHorarios();

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
            $fecha = trim(strip_tags($_POST['fecha']));
            $esp = filter_var($_POST['especialidad'], FILTER_VALIDATE_INT);
            $hor = filter_var($_POST['horario'], FILTER_VALIDATE_INT);

            if (!$fecha) {
                $msg = 'Ingrese una fecha para la reserva';
            }elseif (!$esp) {
                $msg = 'Seleccione una especialidad';
            }elseif (!$hor) {
                $msg = 'Seleccione un horario';
            }else {

                $res = $reservas->getReservaPacienteEspecialidadHorario($esp, $id_paciente, $hor);

                if ($res) {
                    $msg = 'El paciente ya tiene reserva con la especialidad y horario ingresados';
                }else{
                    $res = $reservas->addReserva($fecha, $esp, $id_paciente, $_SESSION['usuario_id'], $hor);

                    if ($res) {
                        $_SESSION['success'] = 'La reserva se ha realizado correctamente';
                        header('Location: ' . BASE_URL);
                    }
                }
            }


        }
    }

    //print_r($roles);exit;

    $title = 'Nueva Reserva';

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
    <script src="../js/funciones.js"></script>
</head>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php include('../partials/menu.php'); ?>
    </header>
    <div class="container-fluid">
        <div class="col-md-6 offset-md-3">
            <h4><?php echo $title ?> </h4>

            <?php if(isset($msg)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <?php if($paciente): ?>
            <form name="form" action="" method="post">
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha<span class="text-danger">*</span>  </label>
                    <input type="date" name="fecha" value="<?php if(isset($_POST['fecha'])) echo $_POST['fecha']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                        <div id="empleadoHelp" class="form-text text-danger">Ingrese la fecha de la reserva</div>
                </div>
                <div class="mb-3">
                    <label for="especialidad" class="form-label">Especialidad<span class="text-danger">*</span> </label>
                    <select name="especialidad" class="form-control">
                        <option value="">Seleccione...</option>

                        <?php foreach($especialidades as $especialidad): ?>

                            <option value="<?php echo $especialidad['id']; ?>"><?php echo $especialidad['nombre']; ?></option>

                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="horario" class="form-label">Horario<span class="text-danger">*</span> </label>
                    <select name="horario" class="form-control">
                        <option value="">Seleccione...</option>

                        <?php foreach($horarios as $horario): ?>

                            <option value="<?php echo $horario['id']; ?>"><?php echo $horario['horario']; ?></option>

                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="confirm" value="1">
                    <button type="submit" class="btn btn-outline-success">Guardar</button>
                    <a href="<?php echo HORARIOS; ?>" class="btn btn-outline-primary">Volver</a>
                </div>

            </form>
            <?php else: ?>
                <p>La reserva no pudo ser realizada</p>
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