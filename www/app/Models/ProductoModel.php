<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductoModel extends BaseDbModel
{

    public const ORDER_COLUMNS = ['p.codigo','p.nombre','nombre_proveedor','p.coste','p.margen','p.stock','p.iva','pvp','nombre_completo_categoria'];
    public function get(array $data, int $order):array
    {
        $sentido = ($order > 0) ? 'ASC' : 'DESC';
        $order = abs($order);

        $condiciones = [];
        $condicionesHaving = [];
        $valores = [];

        if (!empty($data['codigo'])) {
            $condiciones[] = "p.codigo LIKE :codigo";
            $valores["codigo"] = "%" . $data['codigo'] . "%";
        }

        if (!empty($data['nombre'])) {
            $condiciones[] = "p.nombre LIKE :nombre";
            $valores["nombre"] = "%" . $data['nombre'] . "%";
        }

        if (!empty($data['id_proveedor'])) {
            $placeholders = [];
            foreach ($data['id_proveedor'] as $id_proveedor) {
               $paramNames = "id_proveedor_" . $id_proveedor;
               $placeholders[] = ":$paramNames";
               $valores[$paramNames] = $id_proveedor;
            }
            $condiciones[] = "p.proveedor IN (" . implode(',', $placeholders) . ")";
        }

        if (!empty($data['id_categoria'])) {
            $condiciones[] = "p.id_categoria = :id_categoria";
            $valores["id_categoria"] = $data['id_categoria'];
        }

        if (!empty($data['min_margen'])) {
            $condiciones[] = "p.margen >= :min_margen";
            $valores["min_margen"] = $data['min_margen'];
        }

        if (!empty($data['max_margen'])) {
            $condiciones[] = "p.margen <= :max_margen";
            $valores["max_margen"] = $data['max_margen'];
        }

        if (!empty($data['min_coste'])) {
            $condiciones[] = "p.coste >= :min_coste";
            $valores["min_coste"] = $data['min_coste'];
        }

        if (!empty($data['max_coste'])) {
            $condiciones[] = "p.coste <= :max_coste";
            $valores["max_coste"] = $data['max_coste'];
        }

        if (!empty($data['min_pvp'])) {
            $condicionesHaving[] = "pvp >= :min_pvp";
            $valores["min_pvp"] = $data['min_pvp'];
        }

        if (!empty($data['max_pvp'])) {
            $condicionesHaving[] = "pvp <= :max_pvp";
            $valores["max_pvp"] = $data['max_pvp'];
        }

        $sql = "SELECT p.codigo, p.nombre, p2.nombre AS nombre_proveedor, p.coste, p.margen, p.stock, p.iva, (p.coste * p.margen*(1 + p.iva/100)) AS pvp, 
                c.nombre_categoria AS nombre_completo_categoria
                FROM producto p  
                LEFT JOIN proveedor p2 ON p.proveedor = p2.cif
                LEFT JOIN categoria c ON c.id_categoria = p.id_categoria ";
        if (!empty($condiciones)) {
            $sql .= " WHERE " . implode(" AND ", $condiciones);
        }
        if (!empty($condicionesHaving)) {
            $sql .= " HAVING " . implode(" AND ", $condicionesHaving);
        }
        $sql.= " ORDER BY ".self::ORDER_COLUMNS[$order-1]." ".$sentido;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($valores);
        return $stmt->fetchAll();
    }
}