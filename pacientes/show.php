<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/pacienteModel.php');
    require('../class/telefonoModel.php');

    $session = new Session;

    if (isset($_GET['paciente'])) {
        $id = (int) $_GET['paciente'];

        $pacientes = new PacienteModel;
        $telefono = new TelefonoModel;

        $paciente = $pacientes->getPacienteId($id);
        $type = 'Paciente';

        $telefonos = $telefono->getTelefonoIdType($id, $type);

    }

    //print_r($roles);exit;

    $title = 'Pacientes';

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

            <?php include('../partials/mensajes.php'); ?>

            <?php if(!empty($paciente)): ?>
                <table class="table table-hover">
                    <table class="table table-hover">
                   <tr>
                       <th>RUT:</th>
                       <td><?php echo $paciente['rut']; ?></td>
                   </tr>
                   <tr>
                       <th>Nombre:</th>
                       <td><?php echo $paciente['nombre']; ?></td>
                   </tr>
                   <tr>
                       <th>Email:</th>
                       <td><?php echo $paciente['email']; ?></td>
                   </tr>
                   <tr>
                       <th>Fecha de nacimiento:</th>
                       <td>
                           <?php
                                $fecha_nac = new DateTime($paciente['fecha_nacimiento']);
                                echo $fecha_nac->format('d-m-Y');
                            ?>
                        </td>
                   </tr>
                   <tr>
                       <th>Edad:</th>
                       <td><?php echo $paciente['edad']; ?> años</td>
                   </tr>
                    <tr>
                        <th>Teléfonos:</th>
                        <td>
                            <?php if ($telefonos): ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach($telefonos as $telefono): ?>
                                        <a href="<?php echo SHOW_TELEFONO . $telefono['id']; ?>" class="list-group-item list-group-item-action">+56 <?php echo $telefono['numero']; ?></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p>Sin teléfono</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                   <tr>
                       <th>Fecha Creación:</th>
                       <td>
                           <?php
                                $creado = new DateTime($paciente['created_at']);
                                echo $creado->format('d-m-Y H:i:s');
                            ?>
                        </td>
                   </tr>
                    <tr>
                       <th>Fecha Modificación:</th>
                       <td>
                           <?php
                                $modificado = new DateTime($paciente['updated_at']);
                                echo $modificado->format('d-m-Y H:i:s');
                            ?>
                       </td>
                   </tr>
                </table>
                <p>
                    <?php if($_SESSION['usuario_rol'] == 'Administrador'): ?>
                        <a href="<?php echo EDIT_PACIENTE . $id ?>" class="btn btn-outline-success">Editar</a>
                    <?php endif; ?>
                    <a href="<?php echo ADD_TEL_PAC . $id; ?>" class="btn btn-outline-success">Agregar Teléfono</a>
                    <a href="<?php echo PACIENTES; ?>" class="btn btn-outline-primary">Volver</a>
                </p>
            <?php else: ?>
                <p class="text-info">No hay datos</p>
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