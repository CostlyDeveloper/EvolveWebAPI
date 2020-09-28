<?php


namespace APP {
    require_once 'layers/Dev.php';
    require_once 'router/RouteConfig.php';

    use router\RouteConfig;

    class App
    {

        public $dev;
        public $routes;

        public function __construct()
        {
            // $this->dev    = new Dev();
            $this->routes = new RouteConfig();
        }

    }
}
