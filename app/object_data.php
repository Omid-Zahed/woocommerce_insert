<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require  (dirname(__DIR__, 1).'/lib/EasyPDO/easypdo.php');
require_once dirname(__DIR__, 1).'/vendor/autoload.php';


$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

/**
 * Description of object_data
 *
 * @author omid
 */
  class object_data{
            protected $table_name;
            protected    function getDB            ($table){
                $db=new EasyPDO();
                $db->connect();
                $table =$db->table($table);
                return $table;
            }
            protected function delet_item       ($table,$id){
                $this->getDB($table)->delete("WHERE `ID`= ?", [$id]);
            }

             protected function deletItem       ($id,$id_name="ID"){
                $this->getDB($this->table_name)->delete("WHERE `".$id_name."`= ?", [$id]);
            }
            protected function list_all_item() {
                return $this->getDB($this->table_name)->all()->fetchAll();
            }
            }