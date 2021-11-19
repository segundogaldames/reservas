<?php

class Session
{
	public function __construct()
	{
		session_start();
	}

	public function login($id_usuario, $id_empleado, $nom_usuario, $rol)
	{
		$_SESSION['autenticado'] = true;
		$_SESSION['usuario_id'] = $id_usuario;
		$_SESSION['usuario_empleado'] = $id_empleado;
		$_SESSION['usuario_nombre'] = $nom_usuario;
		$_SESSION['usuario_rol'] = $rol;
		$_SESSION['time'] = time();
	}

	public function logout()
	{
		if (isset($_SESSION['autenticado'])) {
			session_destroy();
		}
	}
}