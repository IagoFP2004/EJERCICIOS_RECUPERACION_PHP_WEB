<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\UsuarioSistemaModel;

class UsuarioSistemaController extends BaseController
{
    public function mostrarMenuLogin():void
    {
        $this->view->show('login.view.php');

    }

    public function mostrarMenuRegister():void
    {
        $rolModel = new AuxRolModel();
        $data['roles'] = $rolModel->getAllRols();
        $this->view->show('register.view.php',$data);
    }

    public function doLogin():void
    {
        $modelo =new UsuarioSistemaModel();

        $login = $modelo->getByEmail($_POST['email']);

        if ($login !==false){
            if (password_verify($_POST['password'],$login['pass'])){
                $_SESSION['usuario'] = $login;
                header('Location: /');
            }else{
                $data['errores']['password'] = 'Contraseña incorrecta';
                $this->view->show('login.view.php',$data);
            }
        }else{
            $data['errores']['email'] = 'El email no existe';
            $this->view->show('login.view.php',$data);
        }

    }

    public function doRegister():void
    {
        $errors = $this->checkErrors($_POST);

        if ($errors === []) {
            $modelo = new UsuarioSistemaModel();
            $alta = $modelo->darAltaUsuario($_POST);
            if ($alta !== false) {
                $data['mensaje'] = 'Usuario registrado correctamente';
                $this->view->show('login.view.php', $data);
            } else {
                $data['errores']['general'] = 'Error al registrar el usuario';
                $this->view->show('register.view.php', $data);
            }
        } else {
            $data['errors'] = $errors;
            $rolModel = new AuxRolModel();
            $data['roles'] = $rolModel->getAllRols();
            $this->view->show('register.view.php', $data);
        }
    }

    public function checkErrors(array $data): array
    {
        $errors =[];

        if (empty($data['nombre'])){
            $errors['nombre'] = 'El nombre es obligatorio';
        }

        if (empty($data['email'])){
            $errors['email'] = 'El email es obligatorio';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'El email no es válido';
        }

        if (empty($data['password'])){
            $errors['password'] = 'La contraseña es obligatoria';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'La contraseña debe tener al menos 6 caracteres';
        }

        if (empty($data['password2'])){
            $errors['password2'] = 'La confirmación de contraseña es obligatoria';
        } elseif ($data['password'] !== $data['password2']) {
            $errors['password2'] = 'Las contraseñas no coinciden';
        }

        if (empty($data['terms']) || $data['terms'] !== 'agree') {
            $errors['terms'] = 'Debes aceptar los términos y condiciones';
        }

        return $errors;
    }
}