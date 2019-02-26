<?php
/**
 * Created by PhpStorm.
 * User: Rubens
 * Date: 24/02/2019
 * Time: 12:46
 */

namespace Source\Classes;

use Source\Database\Connect;


/**
 * Class Incidents
 * @package Source\Classes
 */
class Incidents
{
    private $Data;
    private $IncidentId;
    private $Error;

    /**
     * @param array $data
     */
    public function exeCreate(array $data)
    {
        $this->Data = $data;

        if (in_array('', $this->Data)) {
            $this->Error = "<p class='alert alert-warning'>Por favor, preencha todos os campos</p>";
        } else {
            $this->setData();
            $this->create();
        }
    }

    /**
     * @param $id
     * @param array $data
     */
    public function exeUpdate($id, array $data)
    {
        $this->IncidentId = (int)$id;
        $this->Data = $data;

        if (in_array('', $this->Data)) {
            $this->Error = "<p class='alert alert-warning'>Por favor, preencha todos os campos</p>";
        } else {
            $this->setData();
            $this->update();
        }
    }

    /**
     * @param $id
     */
    public function exeDelete($id)
    {
        $this->IncidentId = (int)$id;

        $stmt = Connect::getInstance()->prepare("DELETE FROM incidents WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount()) {
            $this->Error = "<p class='alert alert-success'>Incidente apagado com sucesso!</p>";
        } else {
            $this->Error = "<p class='alert alert-danger'>Você está tentando apagar um registro que não existe no 
                            sistema!</p>";

        }
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->Error;
    }

    /*
     * PRIVATES METHODS
     */

    /**
     * Varre o array para remover possiveis códigos malciciosos
     */
    private function setData()
    {
        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);
    }

    /**
     * Registra um novo incidente
     */
    private function create()
    {
        $this->Data['status_id'] = 1;

        $stmt = Connect::getInstance()->prepare("INSERT INTO incidents (title, description, criticity_id, 
            type_id, status_id) VALUES (:title, :description, :criticity_id, :type_id, :status_id)");

        $stmt->execute($this->Data);

        if ($stmt->rowCount()) {
            $this->Error = "<p class='alert alert-success'>Incidente cadastrado com sucesso!</p>";
        }
    }

    /**
     * Atualiza um incidente
     */
    private function update()
    {
        $stmt = Connect::getInstance()->prepare("UPDATE incidents SET title = :title,
                description = :description, criticity_id = :criticity_id, type_id = :type_id, status_id = :status_id
                WHERE id = {$this->IncidentId}");

        $stmt->execute($this->Data);

        if ($stmt->rowCount()) {
            $this->Error = "<p class='alert alert-success'>Incidente atualizado com sucesso!</p>";
        } else {
            echo "<p class='alert alert-warning'>Nenhuma alteração efetuada!</p>";
        }
    }
}