<?php
#define rutas a traves constantes
define('BASE_URL','http://localhost:8080/reservas/');
define('PARAM', false);

#definicion de rutas de roles
define('ROLES', BASE_URL . 'roles/');
define('ADD_ROL', ROLES . 'add.php');
define('SHOW_ROL', ROLES . 'show.php?rol=' . PARAM);
define('EDIT_ROL', ROLES . 'edit.php?rol=' . PARAM);
define('DEL_ROL', ROLES . 'delete.php?rol=' . PARAM);