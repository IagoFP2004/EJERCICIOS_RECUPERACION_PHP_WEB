<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\CategoriaController;
use Com\Daw2\Controllers\EjerciciosController;
use Com\Daw2\Controllers\PreferenciasController;
use Com\Daw2\Controllers\ProveedoresController;
use Com\Daw2\Controllers\UsuarioSistemaController;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        //Ejercicio1
        session_start();
        Route::add(
            '/',
            function () {
                $controlador = new \Com\Daw2\Controllers\InicioController();
                $controlador->index();
            },
            'get'
        );

        Route::add(
            '/demo-proveedores',
            function () {
                $controlador = new \Com\Daw2\Controllers\InicioController();
                $controlador->demo();
            },
            'get'
        );

        Route::add(
            '/proveedores',
            function () {
                $controlador = new ProveedoresController();
                $controlador->listado();
            },
            'get'
        );

        Route::add(
            '/proveedores/new',
            function () {
                $controlador = new ProveedoresController();
                $controlador->menuAlta();
            },
            'get'
        );

        Route::add(
            '/proveedores/new',
            function () {
                $controlador = new ProveedoresController();
                $controlador->realizarAlta();
            },
            'post'
        );

        Route::add(
            '/proveedores/delete/([A-Z][0-9]{0,7}[A-Z])',
            function ($cif) {
                $controlador = new ProveedoresController();
                $controlador->deleteProveedor((string)$cif);
            },
            'get'
        );

        Route::add(
            '/proveedores/edit/([A-Z][0-9]{0,7}[A-Z])',
            function ($cif) {
                $controlador = new ProveedoresController();
                $controlador->showEdit((string)$cif);
            },
            'get'
        );

        Route::add(
            '/proveedores/edit/([A-Z][0-9]{0,7}[A-Z])',
            function ($cif) {
                $controlador = new ProveedoresController();
                $controlador->editarProveedor((string)$cif);
            },
            'post'
        );


        Route::pathNotFound(
            function () {
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error404();
            }
        );
        Route::methodNotAllowed(
            function () {
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error405();
            }
        );
        Route::run();
    }
}
