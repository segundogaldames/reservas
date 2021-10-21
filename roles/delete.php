<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../class/config.php');
require('../class/rutas.php');
require('../class/rolModel.php');

if (isset($_GET['rol'])) {
    $id = (int) $_GET['rol'];

    //print_r($id);exit;

    #verificar que hay un rol con el id recibido
    $roles = new RolModel;
    $rol = $roles->getRolId($id);

    if ($rol) {
        #eliminar el rol
        $row = $roles->deleteRol($id);

        if ($row) {
            $_SESSION['success'] = 'El rol se ha eliminado correctamente';
            header('Location: ' . ROLES);
        }else {
            $_SESSION['danger'] = 'El rol no se ha podido eliminar... intente mas tarde';
            header('Location: ' . SHOW_ROL . $id);
        }
    }else{
        $_SESSION['danger'] = 'El rol no está registrado';
        header('Location: ' . ROLES);
    }
}