<?php
require_once('db/Table.php');

class Database {
    private $db = [];
    private $context;

    public function __construct($context) {
    	$this->context = rtrim($context, '/');
    }

    public function get ($name) {
        if (!isset($this->db[$name])) {
            $this->db[$name] = new Table($this->context . '/' . $name . '.json');
        }
        return $this->db[$name];
    }
}
?>