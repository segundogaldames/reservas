<?php
require_once('model.php');

class TelefonoModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTelefonoNumero($numero)
    {
        $tel = $this->_db->prepare("SELECT id FROM telefonos WHERE numero = ?");
        $tel->bindParam(1, $numero);
        $tel->execute();

        return $tel->fetch();
    }

    public function getTelefonoIdType($id, $type)
    {
        $tel = $this->_db->prepare("SELECT id, numero FROM telefonos WHERE telefonoable_id = ? AND telefonoable_type = ?");
        $tel->bindParam(1, $id);
        $tel->bindParam(2, $type);
        $tel->execute();

        return $tel->fetchall();
    }

    public function addTelefono($numero, $id, $type)
    {
        $tel = $this->_db->prepare("INSERT INTO telefonos(numero, telefonoable_id, telefonoable_type) VALUES(?, ?, ?)");
        $tel->bindParam(1, $numero);
        $tel->bindParam(2, $id);
        $tel->bindParam(3, $type);
        $tel->execute();

        $row = $tel->rowCount();
        return $row;
    }
}
