<?php
    require_once('Controllers/Controller.php');
    require_once('Controllers/API/UsersController.php');
    require_once('Controllers/API/ActionsController.php');
    require_once('Controllers/API/ObjectsController.php');   

	class StaticRouter {
        private $routes = [];

        private function pathToRegExp ($path) {
            $path    = split('/', trim($path, '/'));
            $pattern = array_reduce($path, function ($a, $b) {
                return $a . '\\/' . $b;
            }, '');
            return '/^' . $pattern . '(?:\\/(?P<id>\\d+)?)?\\/?$/';
        }

        public function get($path, $view) {
            array_push($this->routes, [
                'path'        => $this->pathToRegExp($path),
                'view'        => $view,
                'contentType' => 'text/html',
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
                    if ($requestMethod === 'get') {
                        include($route['view']);
                    }
                }
            }
        }
    }
    
?>