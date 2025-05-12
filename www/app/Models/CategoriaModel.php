<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class CategoriaModel extends BaseDbModel
{
    public const ORDER_COLUMN = ['nombre_categoria','nombre_completo_categoria','numero_articulos'];
    public function get(array $data, int $order, int $page):array
    {
       $sentido = ($order > 0) ? 'ASC' : 'DESC';
       $order = abs($order);

       $limite = $_ENV['numero.pagina'];

        $condiciones = [];
        $condicionesHaving = [];
        $valores = [];

        if (!empty($data['nombre'])) {
            $condiciones[] = "c.nombre_categoria LIKE :nombre";
            $valores["nombre"] = "%" . $data['nombre'] . "%";
        }

        if (!empty($data['min_numero_articulos'])) {
            $condicionesHaving[] = "numero_articulos >= :min_numero_articulos";
            $valores["min_numero_articulos"] = $data['min_numero_articulos'];
        }

        if (!empty($data['max_numero_articulos'])) {
            $condicionesHaving[] = "numero_articulos <= :max_numero_articulos";
            $valores["max_numero_articulos"] = $data['max_numero_articulos'];
        }

        $sql = "SELECT 
                c.nombre_categoria AS nombre_categoria,
                CONCAT_WS(' > ', c3.nombre_categoria, c2.nombre_categoria, c.nombre_categoria) AS nombre_completo_categoria,
                COUNT(DISTINCT p.id_producto) as numero_articulos
            FROM categoria c 
            LEFT JOIN categoria c2 ON c.id_padre = c2.id_categoria
            LEFT JOIN categoria c3 ON c2.id_padre = c3.id_categoria
            LEFT JOIN producto p ON p.id_categoria = c.id_categoria ";
        if (!empty($condiciones)) {
            $sql .= " WHERE ".implode(' AND ', $condiciones);
        }
        $sql.= " GROUP BY c.id_categoria";
        if (!empty($condicionesHaving)) {
            $sql .= " HAVING ".implode(' AND ', $condicionesHaving);
        }
        $sql.= " ORDER BY ".self::ORDER_COLUMN[$order-1]." ".$sentido;
        $sql.= " LIMIT ".($page-1)*$limite.",".$limite;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($valores);
        return $stmt->fetchAll();
    }

    public function countResults():int
    {
        $sql = "SELECT 
                COUNT(c.id_categoria)
            FROM categoria c 
            LEFT JOIN categoria c2 ON c.id_padre = c2.id_categoria
            LEFT JOIN categoria c3 ON c2.id_padre = c3.id_categoria
            LEFT JOIN producto p ON p.id_categoria = c.id_categoria ";
        $sql.= " GROUP BY c.id_categoria";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}