<?php

class EasyPDO_Table {

    private $db;
    private $name = NULL;
    public $cols = NULL;

    function __construct($DataBase, $table) {
        $this->db = $DataBase;
        $this->name = $table;
    }

    public function all() {
        return $this->db->query("SELECT * FROM `" . $this->name . "` ");
    }

    public function select($where = '', $vals = NULL) {
        if ($this->cols != NULL) {
            $comma = '';
            $cols = '';
            foreach ($this->cols as $cols2) {
                $cols .= $comma . '`' . $cols2 . '`';
                $comma = ',';
            }
        } else {
            $cols = '*';
        }
        if ($vals != NULL) {
            $r = $this->db->prepare("SELECT " . $cols . " FROM `" . $this->name . "`" . $where);
            $r->execute($vals);
        } else {
            $r = $this->db->query("SELECT " . $cols . " FROM `" . $this->name . "`" . $where);
        }
        return $r;
    }

    public function insert($vals, $security = false) {
        if ($security) {
            $comma = '';
            $colsText = '';
            $valLoc = '';
            foreach ($this->cols as $cols2) {
                $colsText .= $comma . '`' . $cols2 . '`';
                $valLoc .= $comma . '?';
                $comma = ',';
            }
            $r = $this->db->prepare("INSERT INTO `" . $this->name . "`(" . $colsText . ") VALUES(" . $valLoc . ")");
            $r->execute($vals);
        } else {
            $comma = '';
            $colsText = '';
            $valsText = '';
            $i = 0;
            foreach ($this->cols as $cols2) {
                $colsText .= $comma . '`' . $cols2 . '`';
                $valsText .= $comma . '"' . $vals[$i] . '"';
                $i++;
                $comma = ',';
            }
            $r = $this->db->query("INSERT INTO `" . $this->name . "`(" . $colsText . ") VALUES(" . $valsText . ")");
        }
        return $r;
    }

    public function delete($where = '', $vals = NULL) {
        if ($vals != NULL) {
            $r = $this->db->prepare("DELETE FROM `" . $this->name . "`" . $where);
            $r->execute($vals);
        } else {
            $r = $this->db->query("DELETE FROM `" . $this->name . "`" . $where);
        }
        return $r;
    }

    public function update($where = '', $vals, $security = false) {
        if ($security) {
            $comma = '';
            $colsText = '';
            foreach ($this->cols as $cols2) {
                $colsText .= $comma . '`' . $cols2 . '`=?';
                $comma = ',';
            }
            $r = $this->db->prepare("UPDATE `" . $this->name . "` SET " . $colsText . $where);
            $r->execute($vals);
        } else {
            $comma = '';
            $colsText = '';
            $i = 0;
            foreach ($this->cols as $cols2) {
                $colsText .= $comma . "`" . $cols2 . "`='" . $vals[$i] . "'";
                $i++;
                $comma = ',';
            }
            $r = $this->db->query("UPDATE `" . $this->name . "` SET " . $colsText . $where);
        }
        return $r;
    }

    public function total($where = '') {

        $data = $this->db->query("SELECT COUNT(*) as `totaldata` FROM `" . $this->name . "` " . $where)->fetch(PDO::FETCH_ASSOC);

        return $data['totaldata'];
    }

    public function totalPage($limit = 10, $where = '') {

        $data = $this->db->query("SELECT COUNT(*) as `totaldata` FROM `" . $this->name . "` " . $where)->fetch(PDO::FETCH_ASSOC);

        return ceil($data['totaldata'] / $limit);
    }

    public function getPage($page, $limit = 10, $where = '') {


        if ($this->cols != NULL) {
            $comma = '';
            $cols = '';
            foreach ($this->cols as $cols2) {
                $cols .= $comma . '`' . $cols2 . '`';
                $comma = ',';
            }
        } else {
            $cols = '*';
        }
        $data = $this->db->query("SELECT " . $cols . " FROM `" . $this->name . "` " . $where . " LIMIT " . ($page - 1) * $limit . "," . $limit);
        return $data;
    }

}
