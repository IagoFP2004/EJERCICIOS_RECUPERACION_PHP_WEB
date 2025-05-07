<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProveedorModel extends BaseDbModel
{
    public const ORDER_COLUMNS = ['p.cif','p.nombre','pais', 'p.email', 'p.telefono', 'numero_productos_diferentes_vendidos'];
    public  function get(array $data, int $order, int $page) : array
    {
         $condiciones = [];
         $condicionesHaving = [];
         $valores = [];

         if(!empty($data['cif'])){
             $condiciones[] = "p.cif LIKE :cif";
             $valores['cif'] = '%'.$data['cif'].'%';
         }

        if(!empty($data['nombre'])){
            $condiciones[] = "p.nombre LIKE :nombre";
            $valores['nombre'] = '%'.$data['nombre'].'%';
        }

        if(!empty($data['email'])){
            $condiciones[] = "p.email LIKE :email";
            $valores['email'] = '%'.$data['email'].'%';
        }

        if(!empty($data['min_productos'])){
            $condicionesHaving[] = "numero_productos_diferentes_vendidos >= :min_productos";
            $valores['min_productos'] = $data['min_productos'] ;
        }

        if(!empty($data['max_productos'])){
            $condicionesHaving[] = "numero_productos_diferentes_vendidos <= :max_productos";
            $valores['max_productos'] = $data['max_productos'] ;
        }

        if (!empty($data['id_pais']) && is_array($data['id_pais'])) {
            $placeholders = [];
            foreach ($data['id_pais'] as $index => $id_pais) {
                $paramName = "id_pais_$index";
                $placeholders[] = ":$paramName";
                $valores[$paramName] = $id_pais;
            }
            $condiciones[] = "ac.id IN (" . implode(',', $placeholders) . ")";
        }

        $sentido = ($order > 0 ? 'ASC' : 'DESC');
        $order = abs($order);

        $limite = $_ENV['numero.pagina'];

        $sql = "SELECT p.cif , p.nombre, ac.country_name as pais, p.email, p.telefono , COUNT(DISTINCT p2.id_producto) as numero_productos_diferentes_vendidos 
                FROM proveedor p 
                LEFT JOIN aux_countries ac ON ac.id  = p.id_country 
                LEFT JOIN producto p2 ON p2.proveedor  = p.cif ";
         if(!empty($condiciones)){
             $sql .= " WHERE ".implode(' AND ', $condiciones);
         }
         $sql.= " GROUP BY p.cif ";
         if(!empty($condicionesHaving)){
             $sql .= " HAVING ".implode(' AND ', $condicionesHaving);
         }
         $sql.= " ORDER BY ".self::ORDER_COLUMNS[$order-1]." ".$sentido;
         $sql.= " LIMIT  ".($page-1)*$limite.",".$limite;;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($valores);
        return $stmt->fetchAll();
    }

    public function countRegistros(array $data) : int
    {
        $sql = "SELECT COUNT(*) FROM proveedor";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getBycif(string $cif) : array | false
    {
        $sql = "SELECT * FROM proveedor WHERE cif = :cif";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cif' => $cif]);
        return $stmt->fetch();
    }

    public function insertarProveedor(array $data) : bool
    {
        $sql =" INSERT INTO `proveedor`(`cif`, `codigo`, `nombre`, `direccion`, `website`, `email`, `telefono`, `id_country`) 
        VALUES (:cif,:codigo,:nombre,:direccion,:website,:email,:telefono,:id_country)";
        $stmt = $this->pdo->prepare($sql);
        if(empty($data['telefono'])){
            $data['telefono'] = null;
        }
        return $stmt->execute([
            'cif' => $data['cif'],
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'direccion' => $data['direccion'],
            'website' => $data['website'],
            'email' => $data['email'],
            'telefono' => $data['telefono'],
            'id_country' => $data['id_country']
        ]);
    }

    public function nosProvee(string $cif) :bool
    {
        $sql = "SELECT p.cif , p.nombre, ac.country_name as pais, p.email, p.telefono , COUNT(DISTINCT p2.id_producto) as numero_productos_diferentes_vendidos 
                FROM proveedor p 
                LEFT JOIN aux_countries ac ON ac.id  = p.id_country 
                LEFT JOIN producto p2 ON p2.proveedor  = p.cif ";
        $sql.= " WHERE p.cif = :cif ";
        $sql.= " GROUP BY p.cif ";
        $sql.= " HAVING numero_productos_diferentes_vendidos >= 1 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cif' => $cif]);
        return $stmt->fetch() !== false;
    }

    public function delete(string $cif): bool
    {
        if ($this->nosProvee($cif)) {
            return false;
        }

        $sql = "DELETE FROM proveedor WHERE cif = :cif";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cif' => $cif]);

        return $stmt->rowCount() > 0;
    }

    public function updateProveedor(array $data, string $cif) : bool
    {
        $sql ="UPDATE `proveedor` SET `cif`=:cif,`codigo`=:codigo,`nombre`=:nombre,`direccion`=:direccion,`website`=:website,`email`=:email,`telefono`=:telefono,`id_country`=:id_country WHERE `cif`=:cif";
        $stmt = $this->pdo->prepare($sql);
        if(empty($data['telefono'])){
            $data['telefono'] = null;
        }
        if ($stmt->execute($data)){
            return true;
        }else{
            return false;
        }
    }

}