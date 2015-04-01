<?php
    require_once('Controllers/Controller.php');
    require_once('Controllers/API/UsersController.php');
    require_once('Controllers/API/ActionsController.php');
    require_once('Controllers/API/ObjectsController.php');   

	class ApiRouter {
        private $routes = [];

        private function pathToRegExp ($path) {
            $path    = split('/', trim($path, '/'));
            $pattern = array_reduce($path, function ($a, $b) {
                if ($b[0] === ':') {
                    $name = substr($b, 1);
                    $b = '(?P<' . $name . '>\\d+)?';
                    return $a . '\\/' . $b;
                } else {
                    return $a . '\\/' . $b;
                }
            }, '');
            return '/^' . $pattern . '(?:\\/(?P<id>\\d+)?)?\\/?$/';
        }

        public function route($path, $controllerName, $methods = ['get', 'post', 'put']) {
            array_push($this->routes, [
                'path'        => $this->pathToRegExp($path),
                'controller'  => $controllerName,
                'methods'     => $methods,
                'contentType' => 'text/json',
            ]);
        }


        public function exec() {
            $n = count($this->routes);
            $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
            $path          = $_SERVER['REQUEST_URI'];

            for ($i = 0; $i < $n; ++$i) {
                $route = $this->routes[$i];
                $ok = preg_match_all($route['path'], $path, $matches);
                if ($ok) {
                    if (in_array($requestMethod, $route['methods'], true)) {
                        $id = $matches['id'][0];
                        $id = $id || $id === '0' ? intval($id) : null;

                        if        (isset($route['controller'])) {
                            $controllerName = $route['controller'];
                            $controller     = new $controllerName();
                            $queryString    = null;

                            $response = $controller->$requestMethod([
                                'id'   => $id,
                                'queryString' => $queryString,
                            ]);
                        }

                        //$contentType = $route['contentType'];
                        echo json_encode($response);
                        break;
                    }
                }
            }
        }
    }
    
?>