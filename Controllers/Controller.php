<?php
require('db/Database.php');

class Controller {
    protected $database;
    protected $name;
    
    public function __construct () {
        $this->db   = new Database('db/tables');
        $className  = get_class($this);
        $ok = preg_match('/Controller$/', $className, $matches, PREG_OFFSET_CAPTURE);
        if ($ok) {
            $length = $matches[0][1];
            $this->name = strtolower(substr($className, 0, $length));
        }
    }

    public function get($params) {
        if (isset($params)) {
            $name = $this->name;
            if (isset($params['id']) && is_integer($id = $params['id'])) {
                $data = $this->db->get($name)->get($id);
            } else {
                $data = $this->db->get($name)->get();
            }
        }

        return $data;
    }

    public function post($params) {
        $body = file_get_contents('php://input');

        if (isset($params)) {
            $name = $this->name;
            $item = json_decode($body, true);
            $data = $this->db->get($name)->add($item);
        }
        return $data;

    }
}
?>