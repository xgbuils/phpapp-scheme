<?php

class ObjectsController {
    //private $db;

    public function get($id = null) {
        $data     = $this->db['objects']->get($id);
        $response = json_encode($data);
        return $response;
    }

    public function post($id, $user) {

    }

    public function put ($id, $user) {

    }

    public function delete ($id) {

    }
}

?>