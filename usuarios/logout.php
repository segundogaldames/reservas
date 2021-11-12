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

    $session->logout();

    header('Location: ' . BASE_URL);
