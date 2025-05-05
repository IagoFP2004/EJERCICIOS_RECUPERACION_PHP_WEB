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

        $data['listado'] = $modelo->get($_GET,$data['order']);

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

}