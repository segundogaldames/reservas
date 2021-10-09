<?php
#llamada a la clase model
require_once('model.php');

class RolModel extends Model
{
    #la funcion de esta clase sera trabajar directamente con la tabla roles

    #constructor
    public function __construct()
    {
        parent::__construct();
    }

    #metodo que recupera todos los roles
    public function getRoles()
    {
        $rol = $this->_db->query("SELECT id, nombre FROM roles ORDER BY nombre");

        return $rol->fetchall();
    }

    #metodo para registrar un rol
    public function setRol($nombre)
    {
        $rol = $this->_db->prepare("INSERT INTO roles(nombre) VALUES(?)");
        $rol->bindParam(1, $nombre);
        $rol->execute();

        #rescatamos el numero de filas afectadas por la consulta
        $row = $rol->rowCount();
        return $row;
    }
}

