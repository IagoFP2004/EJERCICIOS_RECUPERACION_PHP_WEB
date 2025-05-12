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
}