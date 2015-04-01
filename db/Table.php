<?php 
    class Table {
        private $table;
        private $references;
        private $modified;

        private function findByKeyValue($hash) {
            return array_values(
                array_filter(
                    $this->table['data'],
                    function ($item) use ($hash) {
                        $match = true;
                        foreach ($hash as $field => $value) {
                            if (!isset($item[$field]) || $item[$field] !== $value) {
                                $match = false;
                                break;
                            }
                        }
                        return $match;
                    }
                )
            );
        }

        public function __construct ($filename) {
            $this->filename = $filename;
            $this->modified = false;
            //echo __DIR__ . '<br/>';
            //echo $this->filename . '<br/>';
            $content = file_get_contents($this->filename);
            //echo $content;
            $this->table = json_decode($content, true);
            //echo var_dump($this->table['data']);

        }

        public function add ($item, $requireds = []) {
            foreach ($requireds as $required) {
                if (!isset($item[$required])) {
                    throw new Exception('"' . $required . '" field is required.');
                }
            }
            $item['id'] = ++$this->table['increment'];
            $this->modified = true;
            array_push($this->table['data'], $item);

            return $this->table['increment'];
        }

        public function get ($key = null) {
            if (isset($key)) {
                if (is_integer($key)) {
                    return $this->findByKeyValue(['id' => $key])[0];
                } else if (is_array($key)) {
                    return $this->findByKeyValue($key);
                } else {
                    throw new Exception('$key parameter type is incorrect.');
                }
            } else {
                return $this->table['data'];
            }
        }

        public function references ($tableName) {
            array_push($this->references, $tableName);
        }

        public function __destruct () {
            if ($this->modified) {
                $content = json_encode($this->table);
                file_put_contents($this->filename , $content);
            }
        }
    }
?>