<?php
require __DIR__.'/EasyPDO_Table.php';

class EasyPDO {

    private $db = NULL;
    public $table = NULL;
    public $process = NULL;

    public function connect($Host="localhost", $DatabaseName="woodmart", $UserName="root", $Password="", $CharSet = 'utf8') {
        try {
            $this->db = new PDO('mysql:host=' . $Host . ';dbname=' . $DatabaseName . ';charset=' . $CharSet . ';', $UserName, $Password);
            return true;
        } catch (PDOException $e) {
            return 'Connection failed: ' . $e->getMessage();
        }
    }

     
    public function table($name) {
        return new EasyPDO_Table($this->db, $name);
    }

    public function query($queryText, $array = null) {
        if ($array == null) {
            return $this->db->query($queryText);
        } else {
            $r = $this->db->prepare($queryText);
            $r->execute($array);
            return $r;
        }
    }

}
