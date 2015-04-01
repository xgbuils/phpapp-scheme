<?php
class RouterHandler {
	public function __construct () {
		$this->routers = [];

	}

	public function add($router) {
		array_push($this->routers, $router);
	}

	public function exec() {
		foreach ($this->routers as $router) {
			$router->exec();
		}
	}
}
?>