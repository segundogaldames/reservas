<?php

require_once('model.php');

class UsuarioModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addUsuario($clave, $empleado)
    {
        $usu = $this->_db->prepare("INSERT INTO usuarios(clave, activo, empleado_id, created_at, updated_at) VALUES(?, 1, ?, now(), now())");
        $usu->bindParam(1, $clave);
        $usu->bindParam(2, $empleado);
        $usu->execute();

        $row = $usu->rowCount();

        return $row;
    }
}
