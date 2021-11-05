<?php

require_once('model.php');
require_once('Hash.php');
require_once('config.php');

class UsuarioModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsuarioEmpleado($empleado)
    {
        $usu = $this->_db->prepare("SELECT id FROM usuarios WHERE empleado_id = ?");
        $usu->bindParam(1, $empleado);
        $usu->execute();

        return $usu->fetch();
    }

    public function addUsuario($clave, $empleado)
    {
        $clave = Hash::getHash('sha1', $clave, HASH_KEY);

        $usu = $this->_db->prepare("INSERT INTO usuarios(clave, activo, empleado_id, created_at, updated_at) VALUES(?, 1, ?, now(), now())");
        $usu->bindParam(1, $clave);
        $usu->bindParam(2, $empleado);
        $usu->execute();

        $row = $usu->rowCount();

        return $row;
    }
}
