<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;

class CategoriaController extends BaseController
{
    public function listado():void
    {
        $data = array(
            'titulo' => 'Gestion de categorias',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio/categorias'
        );
        $this->view->showViews(array('templates/header.view.php', 'categorias.view.php', 'templates/footer.view.php'), $data);
    }
}