<?php
require_once('model.php');

class ReservaModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getReservas()
    {
        $res = $this->_db->query("SELECT r.id, r.fecha, r.activo, r.created_at, e.nombre as especialidad, h.horario as horario FROM reservas r INNER JOIN especialidades e ON r.especialidad_id = e.id INNER JOIN horarios h ON r.horario_id = h.id ORDER BY r.created_at DESC limit 10");

        return $res->fetchall();
    }

    public function getReservaId($id)
    {
        $res = $this->_db->prepare("SELECT r.id, r.fecha, r.activo, r.especialidad_id, p.nombre as paciente, r.horario_id, r.created_at, r.updated_at, e.nombre as especialidad, emp.nombre as empleado, h.horario as horario FROM reservas r INNER JOIN especialidades e ON r.especialidad_id = e.id INNER JOIN horarios h ON r.horario_id = h.id INNER JOIN pacientes p ON r.paciente_id = p.id INNER JOIN usuarios u ON r.usuario_id = u.id INNER JOIN empleados emp ON u.empleado_id = emp.id WHERE r.id = ?");
        $res->bindParam(1, $id);
        $res->execute();

        return $res->fetch();
    }

    public function getReservaPaciente($paciente)
    {
        $res = $this->_db->prepare("SELECT r.id, r.fecha, r.activo, r.created_at, e.nombre as especialidad, h.horario as horario FROM reservas r INNER JOIN especialidades e ON r.especialidad_id = e.id INNER JOIN horarios h ON r.horario_id = h.id INNER JOIN pacientes p ON r.paciente_id = p.id INNER JOIN usuarios u ON r.usuario_id = u.id INNER JOIN empleados emp ON u.empleado_id = emp.id WHERE r.paciente_id = ?");
        $res->bindParam(1, $paciente);
        $res->execute();

        return $res->fetchall();
    }

    public function getReservaPacienteEspecialidadHorario($especialidad, $paciente, $horario)
    {
        $res = $this->_db->prepare("SELECT id FROM reservas WHERE especialidad_id = ? AND paciente_id = ? AND horario_id = ?");
        $res->bindParam(1, $especialidad);
        $res->bindParam(2, $paciente);
        $res->bindParam(3, $horario);
        $res->execute();

        return $res->fetch();
    }

    public function addReserva($fecha, $especialidad, $paciente, $usuario, $horario)
    {
        $res = $this->_db->prepare("INSERT INTO reservas(fecha, activo, especialidad_id, paciente_id, usuario_id, horario_id, created_at, updated_at) VALUES(?, 1, ?, ?, ?, ?, now(), now() )");
        $res->bindParam(1, $fecha);
        $res->bindParam(2, $especialidad);
        $res->bindParam(3, $paciente);
        $res->bindParam(4, $usuario);
        $res->bindParam(5, $horario);
        $res->execute();

        $row = $res->rowCount();
        return $row;
    }
}
