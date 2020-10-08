<?php


namespace APP {
    require_once 'router/RouteConfig.php';

    use IO\ResponseProcess;
    use router\RouteConfig;

    class App
    {

        private RouteConfig     $routes;
        private ResponseProcess $response;

        final public function start(): void
        {
            $this->response = new ResponseProcess();
            $this->routes   = new RouteConfig($this->response);
        }
    }
}
