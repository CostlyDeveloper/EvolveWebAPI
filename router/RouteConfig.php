<?php

namespace router {

    use IO\RequestProcess;
    use IO\ResponseProcess;
    use Layer\FileContentManagement;
    use LayerCRUD\CRUDController;
    use Steampixel\Route;

    require_once __DIR__ . '/../layers/FileContentManagement.php';
    require_once __DIR__ . '/../modules/APPLICATION/Model.php';
    require_once __DIR__ . '/../modules/APPLICATION/Controller.php';
    require_once __DIR__ . '/Route.php';
    require_once __DIR__ . '/../dependencies/CRUDController.php';

    const BASE_PATH = '/';

    class RouteConfig
    {
        private RequestProcess        $request;
        private FileContentManagement $fileContent;
        private ResponseProcess       $response;

        function __construct(ResponseProcess $_response)
        {
            $this->response    = $_response;
            $this->request     = new RequestProcess();
            $this->fileContent = new FileContentManagement();

            // check the file content is ready
            if ($this->fileContent->getFileContent()) {
                $this->request->valueSetter($this->fileContent->getFileContent());
            } else {
                $this->response->throwError('ERROR', 'Request');
            }
            // check the request is valid
            if (!$this->request->isValid()) {
                $this->response->throwError('ERROR', 'Request');
            }

            // if all is ready here we can start with routes
            $this->getRoutes();
        }

        final public function getRoutes(): void
        {

            Route::add('/', function () {
                echo 'Welcome :-)';
            });

            Route::add('([\s\S]*)', function ($url) {

                $this->isValidRoute($url);
                //TODO pogledati kako napraviti jednu instancu requesta umjesto dvije i pogledati request validation
                $CRUDController = new CRUDController($url, $this->request, $this->response);
            }, ['post']);

            // Run the Router with the given Basepath
            Route::run(BASE_PATH);
        }

        final function isValidRoute(string $_route): void
        {
            $crudActions = array('create', 'read', 'update', 'delete');
            $str         = file_get_contents('../modules/moduleList.json');
            $moduleList  = json_decode($str, false);
            $path        = explode("/", $_route);
            $module      = $path[1];
            $controller  = $path[2];
            $action      = strtolower($path[3]);

            if ((!in_array($action, $crudActions))) {
                $this->response->throwError('ERROR', 'Endpoint do not exist!');
            } elseif (($tmpModuleIndex = ArrayUtils::objArraySearch($moduleList->ModuleList, 'Name', $module)) !== -1) {
                // Module exist here
                $tmpControllerIndex = ArrayUtils::objArraySearch($moduleList->ModuleList[$tmpModuleIndex]->ModelList, 'Name', $controller);
                //
                if ($tmpControllerIndex === -1) {
                    $this->response->throwError('ERROR', 'Endpoint do not exist!');
                }
            } else {
                $this->response->throwError('ERROR', 'Endpoint do not exist!');
            }
        }
    }

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
