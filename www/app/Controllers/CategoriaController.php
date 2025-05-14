<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CategoriaModel;

class CategoriaController extends BaseController
{
    public function listado():void
    {
        $data = array(
            'titulo' => 'Gestion de categorias',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio/categorias'
        );

        $model = new CategoriaModel();

        $copia_GET= $_GET;
        unset($copia_GET['order']);
        $data['url']=http_build_query($copia_GET);

        $data['order'] = $this->getOrder();

        $copia_GET2= $_GET;
        unset($copia_GET2['page']);
        $data['url2']=http_build_query($copia_GET2);

        $numeroRegistros = $model->countResults();
        $numeroPaginas = $this->getNumberPage($numeroRegistros);
        $data['page'] = $this->getPage($numeroPaginas);
        $data['max_page'] = $numeroPaginas;



        $data['listado'] = $model->get($_GET, $data['order'], $data['page']);

        $this->view->showViews(array('templates/header.view.php', 'categorias.view.php', 'templates/footer.view.php'), $data);
    }

    public function deleteCategoria($id_categoria):void
    {
        $modelo = new CategoriaModel();
        $borrado = $modelo->delete($id_categoria);

        if ($borrado !== false) {
            $_SESSION['mensaje'] = "Categoria eliminada correctamente";
            header('Location: /categoria');
        }else{
            $_SESSION['mensajeError'] = "No se pudo eliminar la categoria, contiene productos";
            header('Location: /categoria');
        }

    }

    public function menuAlta():void
    {
        $data = array(
            'titulo' => 'Alta de categorias',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio/categorias/Alta Categoria'
        );

        $modelo = new CategoriaModel();

        $data['padres'] = $modelo->getPadres();

        $this->view->showViews(array('templates/header.view.php', 'categoriasAlta.view.php', 'templates/footer.view.php'), $data);
    }

    public function realizarAltaCategoria():void
    {
        $data = array(
            'titulo' => 'Alta de categorias',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio/categorias/Alta Categoria'
        );


        $modelo = new CategoriaModel();
        $errores = $this->checkData($_POST);

        if($errores === []){
            $insertado = $modelo->insert($_POST);

            if ($insertado !== false) {
                $_SESSION['mensaje'] = "Categoria almacenada correctamente";
                header('Location: /categoria');
            }else{
                $_SESSION['mensajeError'] = "No se pudo almacenar la categoria";
                header('Location: /categoria');
            }
        }else{
            $data['errores'] = $errores;
            $data['padres'] = $modelo->getPadres();
            $data['categorias'] = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        }
        $this->view->showViews(array('templates/header.view.php', 'categoriasAlta.view.php', 'templates/footer.view.php'), $data);
    }

    public function mostrarVistaEdicion(int $id_categoria):void
    {
        $data = array(
            'titulo' => 'Edicion de categorias',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio/categorias/Modificar Categoria'
        );

        $modelo = new CategoriaModel();

        $data['categorias']=$modelo->getCategoriaByid($id_categoria);
        $data['padres'] = $modelo->getPadres();

        $this->view->showViews(array('templates/header.view.php', 'categoriasAlta.view.php', 'templates/footer.view.php'), $data);
    }

    public function editarCategoria(int $id_categoria):void
    {
        $data = array(
            'titulo' => 'Edicion de categorias',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio/categorias/Modificar Categoria'
        );

        $modelo = new CategoriaModel();


        $data['categorias']=filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['padres'] = $modelo->getPadres();

        $errores = $this->checkData($_POST);

        if($errores === []){
            $edicion = $modelo->updateCategoria($id_categoria, [
                'nombre_categoria' => $_POST['nombre'],
                'id_padre' => $_POST['id_padre']
            ]);
            if ($edicion !== false) {
                $_SESSION['mensaje'] = "Categoria modificada correctamente";
                header('Location: /categoria');
            }else{
                $_SESSION['mensajeError'] = "No se pudo modificar la categoria";
                header('Location: /categoria');
            }
        }else{
            $data['errores'] = $errores;
        }


        $this->view->showViews(array('templates/header.view.php', 'categoriasAlta.view.php', 'templates/footer.view.php'), $data);
    }

    public function getOrder():int
    {
        if (isset($_GET['order']) && is_numeric($_GET['order'])) {
            $order = (int) $_GET['order'];
            if (abs($order) >= 1 && abs($order) <= 3) {
                return $order;
            }
        }
        return 1;
    }

    public function getNumberPage(int $numeroRegistros):int
    {
        return (int) ceil($numeroRegistros / $_ENV['numero.pagina']);
    }

    public function getPage(int $numeroPaginas):int
    {
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = (int) $_GET['page'];
            if ($_GET['page'] > 1 && $_GET['page'] <= $numeroPaginas) {
                return (int) $_GET['page'];
            }
        }
        return 1;
    }

    public function checkData(array $data):array
    {
        $errores = [];
        $modelo = new CategoriaModel();

        if(empty($data['nombre'])){
            $errores['nombre'] = 'Nombre es requerido';
        }else if (!is_string($data['nombre'])){
            $errores['nombre'] = 'Nombre debe ser un string';
        }else if(mb_strlen($data['nombre']) > 50){
            $errores['nombre'] = 'Nombre no debe tener mas de 50 caracteres';
        }

        if (!empty($data['id_padre'])) {
            if($modelo->getPadres() === false){
                $errores['id_padre'] = 'El padre seleccionado no es valido';
            }
        }

        return $errores;
    }
}