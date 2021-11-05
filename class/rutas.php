<?php
#define rutas a traves constantes
define('BASE_URL','http://localhost:8080/reservas/');
define('PARAM', false);

#definicion de rutas de roles
define('ROLES', BASE_URL . 'roles/');
define('ADD_ROL', ROLES . 'add.php');
define('SHOW_ROL', ROLES . 'show.php?rol=' . PARAM);
define('EDIT_ROL', ROLES . 'edit.php?rol=' . PARAM);
define('DEL_ROL', ROLES . 'delete.php');

#definicion de rutas de especialidades
define('ESPECIALIDADES', BASE_URL . 'especialidades/');
define('ADD_ESPECIALIDAD', ESPECIALIDADES . 'add.php');
define('SHOW_ESPECIALIDAD', ESPECIALIDADES . 'show.php?especialidad=' . PARAM);
define('EDIT_ESPECIALIDAD', ESPECIALIDADES . 'edit.php?especialidad=' . PARAM);

#definicion de rutas de empleados
define('EMPLEADOS', BASE_URL . 'empleados/');
define('ADD_EMPLEADO', EMPLEADOS . 'add.php');
define('SHOW_EMPLEADO', EMPLEADOS . 'show.php?empleado=' . PARAM);
define('EDIT_EMPLEADO', EMPLEADOS . 'edit.php?empleado=' . PARAM);

#ruta de usuarios
define('USUARIOS', BASE_URL . 'usuarios/');
define('ADD_USUARIO', USUARIOS . 'add.php?empleado=' . PARAM);
define('EDIT_PASSWORD', USUARIOS . 'editPassword.php?usuario=' . PARAM);
