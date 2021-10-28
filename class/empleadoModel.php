<?php

require_once('model.php');

class EmpleadoModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getEmpleados()
    {
        $emp = $this->_db->query("SELECT e.id, e.nombre, r.nombre as rol, es.nombre as especialidad FROM empleados e INNER JOIN roles r ON r.id = e.rol_id INNER JOIN especialidades es ON e.especialidad_id = es.id");

        return $emp->fetchall();
    }

    public function getEmpleadoId($id)
    {
        $emp = $this->_db->prepare("SELECT e.id, e.rut, e.nombre, e.email, e.created_at, e.updated_at, r.nombre as rol, es.nombre as especialidad FROM empleados e INNER JOIN roles r ON r.id = e.rol_id INNER JOIN especialidades es ON e.especialidad_id = es.id WHERE e.id = ?");
        $emp->bindParam(1, $id);
        $emp->execute();

        return $emp->fetch();
    }

    public function getEmpleadoRutEmail($rut, $email)
    {
        $emp = $this->_db->prepare("SELECT id FROM empleados WHERE rut = ? OR email = ?");
        $emp->bindParam(1, $rut);
        $emp->bindParam(2, $email);
        $emp->execute();

        return $emp->fetch();
    }
}
