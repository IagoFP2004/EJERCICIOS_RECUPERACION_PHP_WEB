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
            'breadcrumb' => ['Inicio', 'Gestion de proveedores'],
            'seccion' => '/proveedor'
        );

        $this->view->showViews(array('templates/header.view.php', 'proveedor.view.php', 'templates/footer.view.php'), $data);
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