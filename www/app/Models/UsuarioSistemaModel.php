<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class UsuarioSistemaModel extends BaseDbModel
{
    public function getByEmail(string $email): array | false
    {
       $sql = "SELECT * FROM usuario_sistema WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function darAltaUsuario(array $data):bool
    {
        $sql = "INSERT INTO usuario_sistema (email, pass, nombre, id_rol) VALUES (:email, :pass, :nombre, :id_rol)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'email' => $data['email'],
            'pass' => password_hash($data['password'], PASSWORD_DEFAULT),
            'nombre' => $data['nombre'],
            'id_rol' => $data['id_rol']
        ]);
    }
}