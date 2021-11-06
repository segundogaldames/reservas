<?php

class Session
{
	public static function init()
	{
		session_start();
	}

	public static function destroy($clave = false)
	{
		if($clave):
			if(is_array($clave)):
				for($i = 0;$i < count($clave);$i++):
					if(isset($_SESSION[$clave[$i]])):
						unset($_SESSION[$clave[$i]]);
					endif;
				endfor;
			else:
				if(isset($_SESSION[$clave])):
					unset($_SESSION[$clave]);
				endif;
			endif;
		else:
			session_destroy();
		endif;
	}

	public static function set($clave, $valor)
	{
		if(!empty($clave)):
			$_SESSION[$clave] = $valor;
		endif;
	}

	public static function get($clave)
	{
		if(isset($_SESSION[$clave])):
			return $_SESSION[$clave];
		endif;
	}

	public static function acceso($level)
	{
		if(!Session::get('autenticado')):
			header('Location: ' . BASE_URL . 'error/access/5050');
			exit;
		endif;

		Session::tiempo();

		if(Session::getLevel($level) > Session::getLevel(Session::get('level'))):
			header('Location: ' . BASE_URL . 'error/access/5050');
			exit;
		endif;
	}

	public static function accesoView($level)
	{
		if(!Session::get('autenticado')):
			return false;
		endif;

		if(Session::getLevel($level) > Session::getLevel(Session::get('level'))):
			return false;
		endif;
	}

	public static function getLevel($level)
	{
		$role['admin'] = 3;
		$role['especial'] = 2;
		$role['usuario'] = 1;

		if(!array_key_exists($level, $role)):
			throw new Exception("Error de acceso");
		else:
			return $role[$level];
		endif;
	}

	public static function accesoEstricto(array $level, $noAdmin = false)
	{
		if(!Session::get('autenticado')):
			header('Location: ' . BASE_URL . 'error/access/5050');
			exit;
		endif;

		Session::tiempo();

		if($noAdmin == false):
			if(Session::get('level') == 'admin'):
				return;
			endif;
		endif;

		if(count($level)):
			if(in_array(Session::get('level'), $level)):
				return;
			endif;
		endif;

		header('Location: ' . BASE_URL . 'error/access/5050');
	}

	public static function accesoViewEstricto(array $level, $noAdmin = false)
	{
		if(!Session::get('autenticado')):
			return false;
		endif;

		if($noAdmin == false):
			if(Session::get('level') == 'admin'):
				return false;
			endif;
		endif;

		if(count($level)):
			if(in_array(Session::get('level'), $level)):
				return true;
			endif;
		endif;

		return false;
	}

	public static function tiempo()
	{
		if(!Session::get('tiempo') || !defined('SESSION_TIME')):
			throw new Exception("Tiempo de session no definido");

		endif;

		if(SESSION_TIME == 0): //se asume que el tiempo de session es indefinido
			return;
		endif;

		if(time() - Session::get('tiempo') > (SESSION_TIME * 60)):
			Session::destroy();
			header('Location: ' . BASE_URL . 'error/access/8080');
		else:
			Session::set('tiempo', time());
		endif;
	}
}