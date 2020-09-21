<?php

use Layer\RequestValidation\FileContentManagement;
use Steampixel\Route;

require_once __DIR__ . '/layers/RequestValidation.php';
require_once __DIR__ . '/modules/APPLICATION/Model.php';
require_once __DIR__ . '/modules/APPLICATION/Controller.php';
require_once __DIR__ . '/router/src/Steampixel/Route.php';

const BASE_PATH = '/';


class RouteConfig
{
    private $Request;
    private $Response;

    final public function start(): void
    {
        $fileContent   = new FileContentManagement();
        $this->Request = $fileContent->getRequest();


        if (!$this->Request) {
            die();
        }

        Route::add('/', function () {
            echo 'Welcome :-)';
        });

        // region *** ELEMENTARY ***

        Route::add('/Elementary/User/Create', function () {

            $controller = new ELEMENTARY\Controller\Handshake($this->Request);
            $controller->UserLogin();

        }, ['post']);

        // endregion
        Route::add('/Handshake/UserLogin', function () {

            $controller = new APPLICATION\Controller\Handshake($this->Request);
            $controller->UserLogin();

        }, ['post']);

        /* Route::add('/auth', function() {
            $Controller = new APPLICATION\Controller\Handshake();
            $Controller->UserLogin($this->Request);
         }, ['get', 'post']);*/


        // Run the Router with the given Basepath
        Route::run(BASE_PATH);
    }
}
