<?php

use Steampixel\Route;

require_once 'layers/DataControl.php';
require_once 'modules/APPLICATION/Model.php';
require_once 'modules/APPLICATION/Controller.php';
// Include router class
include 'router/src/Steampixel/Route.php';

// Define a global basepath
define('BASEPATH', '/');

class RouteConfig
{
    private $Request;
    private $Response;

    public function start(): void
    {
        $fileContent   = new FileContentManagement();
        $this->Request = $fileContent->getRequest();


        if (!$this->Request) {
            die();
        }

        Route::add('/', function () {
            echo 'Welcome :-)';
        });

        Route::add('/auth', function () {
            $Controller = new APPLICATION\Controller\Handshake();
            $Controller->UserLogin($this->Request);
        }, ['post']);

        /* Route::add('/auth', function() {
             $this->Controller = new APPLICATION\Handshake();
             $this->Controller->UserLogin($this->Request);
         }, ['get', 'post']);*/


        // Run the Router with the given Basepath
        Route::run(BASEPATH);
    }
}
