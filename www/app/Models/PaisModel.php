<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class PaisModel extends BaseDbModel
{
    public function getPaises():array
    {
        $sql = "SELECT * FROM aux_countries";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getID(int $id):bool
    {
        $sql = "SELECT * FROM aux_countries WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->rowCount()===1;
    }
}