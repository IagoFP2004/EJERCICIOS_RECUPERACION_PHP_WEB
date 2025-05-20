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
}