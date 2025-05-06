<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\PaisModel;
use Com\Daw2\Models\ProveedorModel;

class ProveedoresController extends BaseController
{
    public function listado() {
        $data = array(
            'titulo' => 'Gestion de proveedores',
            'breadcrumb' => ['Inicio', 'Gestion de proveedores'],
            'seccion' => '/proveedor'
        );

        $modelo = new ProveedorModel();
        $paisModel = new PaisModel();

        $data['paises'] = $paisModel->getPaises();

        $copiaGet = $_GET;
        unset($copiaGet['order']);
        $data['url']=http_build_query($copiaGet);

        $data['order'] = $this->getOrder();
/*
        $copiaGet2 = $_GET;
        unset($copiaGet2['page']);
        $data['urlDos']=http_build_query($copiaGet2);

        $numeroRegistros = $modelo->countRegistros($_GET);
        $page = $this->getPage($numeroRegistros);

        $data['page'] = $this->getNumberPage($page);
        $data['max_page'] = $page;
*/



        $data['listado'] = $modelo->get($_GET,$data['order']);

        $this->view->showViews(array('templates/header.view.php', 'proveedor.view.php', 'templates/footer.view.php'), $data);
    }

    public function menuAlta():void
    {
        $data = array(
            'titulo' => 'Gestion de proveedores',
            'breadcrumb' => ['Inicio', 'Alta de proveedores'],
            'seccion' => '/proveedor/new'
        );
        $paisModel = new PaisModel();

        $data['paises'] = $paisModel->getPaises();

        $this->view->showViews(array('templates/header.view.php', 'proveedorAlta.view.php', 'templates/footer.view.php'), $data);
    }

    public function realizarAlta():void
    {
        $data = array(
            'titulo' => 'Gestion de proveedores',
            'breadcrumb' => ['Inicio', 'Alta de proveedores'],
            'seccion' => '/proveedor/new'
        );

        $errores = [];
        $errores = $this->checkErrors($_POST);

        if ($errores === []) {
            $modelo = new ProveedorModel();
            $insertar = $modelo->insertarProveedor($_POST);

            if ($insertar !==false) {
                $_SESSION['mensaje'] = "Proveedor añadido correctamente";
                header('Location: /proveedores');
            }else{
                $_SESSION['mensaje'] = "No se pudo añadir el proveedor";
                header('Location: /proveedores');
            }

        }else{
            $data['errores'] = $errores;
            $paisModel = new PaisModel();
            $data['paises'] = $paisModel->getPaises();
        }

        $this->view->showViews(array('templates/header.view.php', 'proveedorAlta.view.php', 'templates/footer.view.php'), $data);
    }

    public function deleteProveedor(string $cif):void
    {
        $modelo = new ProveedorModel();
        $borrar = $modelo->delete($cif);

        if ($borrar !==false) {
            $_SESSION['mensaje'] = "Proveedor eliminado correctamente";
            header('Location: /proveedores');
        }else{
            $_SESSION['mensaje'] = "No se pudo eliminar el proveedor, este proveedor nos provee productos";
            header('Location: /proveedores');
        }

    }

    public function checkErrors(array $data):array
    {
     $errors = [];
     $modelo = new ProveedorModel();

     if (empty($data['cif'])) {
         $errors['cif'] = 'CIF es requerido';
     }elseif ($modelo->getBycif($data['cif']) !== false) {
         $errors['cif'] = 'El cif ya existe';
     }elseif (!isset($data['cif'])) {
         $errors['cif'] = 'El cif debe ser un texto';
     }elseif(!preg_match('/^[A-Z][0-9]{0,7}[A-Z]$/', $data['cif'])){
         $errors['cif'] = 'El formato del cif no es valido';
     }

     if (empty($data['codigo'])) {
         $errors['codigo'] = 'El codigo es requerido';
     }elseif(!is_string($data['codigo'])){
         $errors['codigo'] = 'El codigo debe ser un texto';
     }elseif(strlen($data['codigo']) > 10){
         $errors['codigo'] = 'El codigo no puede tener mas de 10 caracteres';
     }

     if (empty($data['nombre'])) {
         $errors['nombre'] = 'El nombre es requerido';
     }elseif(!is_string($data['nombre'])){
         $errors['nombre'] = 'El nombre debe ser un texto';
     }elseif(strlen($data['nombre']) > 255){
         $errors['nombre'] = 'El nombre no puede tener mas de 255 caracteres';
     }

     if (empty($data['direccion'])) {
         $errors['direccion'] = 'La direccion es requerido';
     }elseif(!is_string($data['direccion'])){
         $errors['direccion'] = 'La direccion debe ser un texto';
     }elseif(strlen($data['direccion']) > 255){
         $errors['direccion'] = 'La direccion no puede tener mas de 255 caracteres';
     }

     if (empty($data['website'])) {
         $errors['website'] = 'El website es requerido';
     }elseif(filter_var($data['website'], FILTER_VALIDATE_URL) === false){
         $errors['website'] = 'El website no es valido';
     }

     if (empty($data['email'])) {
         $errors['email'] = 'El email es requerido';
     }elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
         $errors['email'] = 'El email no es valido';
     }

     if (!empty($data['telefono'])){
         if (!preg_match("/^[0-9]{0,9}$/", $data['telefono'])){
             $errors['telefono'] = 'El formato del telefono es incorrecto';
         }
     }

     return $errors;
    }

    public function getOrder(): int
    {
        if (isset($_GET['order']) && is_numeric($_GET['order'])) {
            $order = (int) $_GET['order'];
            if (abs($order) >= 1 && abs($order) <= 6) {
                return $order;
            }
        }
        return 1;
    }

    public function getPage(int $numeroRegistros):int
    {
        return (int)ceil($numeroRegistros/$_ENV['numero.pagina']);
    }

    public function getNumberPage($page):int
    {
        if (isset($_GET['page'])){
            if($_GET['page'] >-4 && $_GET['page']<4){
                return (int)$_GET['page'];
            }
        }
        return 1;
    }


}