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

        $data['productos'] = $modelo->get();
        $data['proveedores'] = $proveedoresModel->getAllProveedores();
        $data['categorias'] = $categoriasModel->getAllCategorias();

        $this->view->showViews(array('templates/header.view.php', 'productos.view.php', 'templates/footer.view.php'), $data);
    }
}