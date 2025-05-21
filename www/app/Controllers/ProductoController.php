<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CategoriaModel;
use Com\Daw2\Models\ProductoModel;
use Com\Daw2\Models\ProveedorModel;

class ProductoController extends BaseController
{
    public function listado():void
    {
        $data = array(
            'titulo' => 'Gestion de Productos',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio'
        );

        $modelo = new ProductoModel();
        $proveedoresModel = new ProveedorModel();
        $categoriasModel = new CategoriaModel();

        $data['proveedores'] = $proveedoresModel->getAllProveedores();
        $data['categorias'] = $categoriasModel->getAllCategorias();

        $copia_GET = $_GET;
        unset($copia_GET['order']);
        $data['url'] = http_build_query($copia_GET);

        $data['order'] = $this->getOrder();

        $copia_GET_2 = $_GET;
        unset($copia_GET['page']);
        $data['urlDos'] = http_build_query($copia_GET_2);

        $numeroRegistros = $modelo->countResults();
        $numeroPaginas = $this->getNumeroPaginas($numeroRegistros);
        $data['page'] = $this->getNumeroPagina($numeroPaginas);
        $data['max_page']=$numeroPaginas;

        $data['productos'] = $modelo->get($_GET, $data['order'],$data['page']);

        $this->view->showViews(array('templates/header.view.php', 'productos.view.php', 'templates/footer.view.php'), $data);
    }

    public function deleteProducto(string $codigo):void
    {
        $modelo = new ProductoModel();
        $borrado = $modelo->deleteProducto($codigo);

        if ($borrado !== false) {
            $_SESSION['mensaje'] = 'Producto eliminado correctamente';
            header('Location: /productos');
        }else{
            $_SESSION['mensajeError'] = 'Error al eliminar el producto, el proveedor provee este producto';
            header('Location: /productos');
        }
    }

    public function menuAlta():void
    {
        $data = array(
            'titulo' => 'Gestion de Productos',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio/productos/Alta Producto'
        );

        $proveedorModel = new ProveedorModel();
        $categoriaModel = new CategoriaModel();

        $data['proveedores'] = $proveedorModel->getAllProveedores();
        $data['categorias'] = $categoriaModel->getAllCategorias();

        $this->view->showViews(array('templates/header.view.php', 'productoAltaEdit.view.php', 'templates/footer.view.php'), $data);
    }

    public function realizarAltaProducto():void
    {
        $data = array(
            'titulo' => 'Gestion de Productos',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio/productos/Alta Producto'
        );

        $proveedorModel = new ProveedorModel();
        $categoriaModel = new CategoriaModel();
        $errores = $this->checkErrors($_POST);

        if($errores === []){

        }else{
            $data['errores'] = $errores;
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['proveedores'] = $proveedorModel->getAllProveedores();
            $data['categorias'] = $categoriaModel->getAllCategorias();
        }

        $this->view->showViews(array('templates/header.view.php', 'productoAltaEdit.view.php', 'templates/footer.view.php'), $data);
    }

    public function getOrder(): int
    {
        if (isset($_GET['order'])) {
            $order = (int)$_GET['order'];
            if (abs($order) >= 1 && abs($order) <= 9) {
                return $order;
            }
        }
        return 1;
    }

    public function getNumeroPaginas(int $numeroPaginas): int
    {
        return (int)$numeroPaginas/$_ENV['numero.pagina'];
    }

    public function getNumeroPagina(int $numeroPaginas): int
    {
        if (isset($_GET['page'])) {
            $page = (int)$_GET['page'];
            if ($page >= 1 && $page <= $numeroPaginas) {
                return (int) $page;
            }
        }
        return 1;
    }

    public function checkErrors(array $data):array
    {
        $errores = [];
        $modelo = new ProductoModel();
        $proveedorModel = new ProveedorModel();
        $categoriaModel = new CategoriaModel();

        if(empty($data['codigo'])){
            $errores['codigo'] = 'Codigo es requerido';
        }else if(!is_string($data['codigo'])){
            $errores['codigo'] = 'Codigo debe ser un string';
        }else if(mb_strlen($data['codigo']) > 10){
            $errores['codigo'] = 'Codigo no debe tener mas de 10 caracteres';
        }else if($modelo->getByCodigo($data['codigo']) !== false){
            $errores['codigo'] = 'Codigo ya existe';
        }

        if(empty($data['nombre'])){
            $errores['nombre'] = 'Nombre es requerido';
        }else if(!is_string($data['nombre'])){
            $errores['nombre'] = 'Nombre debe ser un string';
        }else if(mb_strlen($data['nombre']) > 50){
            $errores['nombre'] = 'Nombre no debe tener mas de 50 caracteres';
        }

        if(empty($data['descripcion'])){
            $errores['descripcion'] = 'Descripcion es requerido';
        }else if (!is_string($data['descripcion'])){
            $errores['descripcion'] = 'Descripcion debe ser un string';
        }else if(mb_strlen($data['descripcion']) > 255){
            $errores['descripcion'] = 'Descripcion no debe tener mas de 255 caracteres';
        }

        if (!empty($data['id_proveedor'])) {
            foreach ($data['id_proveedor'] as $id_proveedor) {
                if ($proveedorModel->getByCodigo((string)$id_proveedor) !== false) {
                    $errores['id_proveedor'] = 'El proveedor seleccionado no es valido';
                }
            }
        }

        if (empty($data['descripcion'])){
            $errores['descripcion'] = 'Descripcion es requerido';
        }else if (!is_string($data['descripcion'])){
            $errores['descripcion'] = 'Descripcion debe ser un string';
        }else if(mb_strlen($data['descripcion']) > 255){
            $errores['descripcion'] = 'Descripcion no debe tener mas de 255 caracteres';
        }

        if(empty($data['coste'])){
            $errores['coste'] = 'Coste es requerido';
        }else if(!is_float($data['coste'])){
            $errores['coste'] = 'Coste debe ser un numero';
        }else if($data['coste'] < 0){
            $errores['coste'] = 'Coste no puede ser negativo';
        }else if (!number_format($data['coste'], 2, '.', '')){
            $errores['coste'] = 'Coste no puede tener mas de dos decimales';
        }

        if(!empty($data['margen'])){
            if(!filter_var($data['margen'], FILTER_VALIDATE_FLOAT)){
                $errores['margen'] = 'Margen debe ser un numero';
            }else if($data['margen'] < 0){
                $errores['margen'] = 'Margen no puede ser negativo';
            }else if (!number_format($data['margen'], 2, '.', '')){
                $errores['margen'] = 'Margen no puede tener mas de dos decimales';
            }
        }

        if(!empty($data['iva'])){
            if(!in_array($data['iva'], ['0', '10', '21'])){
                $errores['iva'] = 'Iva debe ser 0, 10 o 21';
            }
        }

        if(!empty($data['id_categoria'])){
            if($categoriaModel->getCategoriaById((int)$data['id_categoria']) === false){
                $errores['id_categoria'] = 'La categoria seleccionada no es valida';
            }
        }

        return $errores;
    }
}