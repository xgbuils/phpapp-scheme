<?php
require_once('Controllers/Controller.php');

class UsersController extends Controller {

    public function __construct () {
        parent::__construct();
        //echo var_dump('UserController: ' . var_dump($this->db));
    }

    /*public function get($params) {
        if (isset($params)) {
            if (isset($params['id']) && $params['id']) {
                $data = $this->db['users']->get($params['id']);
            } else {
                $data = $this->db['users']->get();
            }
        }

        return $data;
    }*/

    public function put ($id, $user) {

    }

    public function delete ($id) {

    }
}

?>