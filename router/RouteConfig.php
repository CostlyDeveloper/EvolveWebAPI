<?php

namespace router {

    use IO\RequestProcess;
    use IO\ResponseProcess;
    use Layer\RequestValidation\FileContentManagement;
    use LayerCRUD\CRUDController;
    use Steampixel\Route;

    require_once __DIR__ . '../layers/RequestValidation.php';
    require_once __DIR__ . '../modules/APPLICATION/Model.php';
    require_once __DIR__ . '../modules/APPLICATION/Controller.php';
    require_once __DIR__ . 'Route.php';
    require_once __DIR__ . '../dependencies/CRUDController.php';

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
                (new ResponseProcess)->throwError('ERROR', 'Request');
            }

            Route::add('/', function () {
                echo 'Welcome :-)';
            });

            // region *** ELEMENTARY ***

            Route::add('([\s\S]*)', function ($url) {

                $this->isValidRoute($url);

                // request
                $request = new RequestProcess();
                $request->valueSetter($this->Request);
                $request->isValid();
                $CRUDController = new CRUDController($url, $request->Request);
            }, ['post']);


            // endregion


            // Run the Router with the given Basepath
            Route::run(BASE_PATH);
        }

        final function isValidRoute(string $_route): void
        {

            $crudActions = array('create', 'remove', 'update', 'delete');
            $str         = file_get_contents('../modules/moduleList.json');
            $moduleList  = json_decode($str, false);


            $path       = explode("/", $_route);
            $module     = $path[1];
            $controller = $path[2];
            $action     = strtolower($path[3]);

            // $tmpModuleIndex = ;

            if ((!in_array($action, $crudActions))) {
                var_dump('ERROR');
                (new ResponseProcess)->throwError('ERROR', 'Endpoint do not exist!');
            } elseif (($tmpModuleIndex = ArrayUtils::objArraySearch($moduleList->ModuleList, 'Name', $module)) !== -1) {
                // Module exist here
                $tmpControllerIndex = ArrayUtils::objArraySearch($moduleList->ModuleList[$tmpModuleIndex]->ModelList, 'Name', $controller);
                //
                if ($tmpControllerIndex === -1) {
                    var_dump('ERROR');
                    (new ResponseProcess)->throwError('ERROR', 'Endpoint do not exist!');
                }
            } else {
                var_dump('ERROR');
                (new ResponseProcess)->throwError('ERROR', 'Endpoint do not exist!');
            }
        }
    }


    // (!in_array($action, $crudActions))
    // $tmpControllerIndex = ArrayUtils::objArraySearch($moduleList->ModuleList[$tmpModuleIndex]->ModelList, 'Name', $controller);
    // $tmpControllerIndex = array_search($controller, array_column($moduleList->ModuleList[$tmpModuleIndex]->ModelList, 'Name'));
    class ArrayUtils
    {
        public static function objArraySearch(array $array, string $key, string $value): ?int
        {
            foreach ($array as $index => $arrayInf) {
                if (property_exists($arrayInf, $key)) {
                    if ($arrayInf->{$key} === $value) {

                        return $index;
                    }
                } else {
                    return -1;
                }
            }
            return -1;
        }
    }
}

