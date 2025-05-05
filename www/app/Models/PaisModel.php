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
}