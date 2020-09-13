<?php
require_once 'layers/Dev.php';
require_once 'RouteConfig.php';


class App
{

    public $dev;
    public $routes;

    public function __construct()
    {
        $this->dev = new Dev();
        $this->routes = new RouteConfig();
    }

}
