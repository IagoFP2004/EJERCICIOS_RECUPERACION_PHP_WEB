<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductoModel extends BaseDbModel
{
    public function get():array
    {
        $sql = "SELECT p.codigo, p.nombre, p2.nombre AS nombre_proveedor, p.coste, p.margen, p.stock, p.iva, (p.coste * p.margen*(1 + p.iva/100)) AS pvp, 
                c.nombre_categoria AS nombre_completo_categoria
                FROM producto p  
                LEFT JOIN proveedor p2 ON p.proveedor = p2.cif
                LEFT JOIN categoria c ON c.id_categoria = p.id_categoria ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}