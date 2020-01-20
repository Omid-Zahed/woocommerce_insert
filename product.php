<?php

require './lib/EasyPDO/easypdo.php';
require_once  __DIR__.'/vendor/autoload.php';


$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


class object_data{
    protected    function getDB            ($table){
        $db=new EasyPDO();
        $db->connect();
        $table =$db->table($table);
        return $table;
    }
    protected function delet_item       ($table,$id){
        $this->getDB($table)->delete("WHERE `ID`= ?", [$id]);
    }
    }

class product extends object_data {
    
    public $post_title          =null,
           $post_content        =null,           
           $post_excrpt         =null,
           $post_name           =null,
           $post_type           =null,
           $post_money          =null;

    private $tabel              =null;
    
    public function __construct     ($tabel="wp_posts") { 
        $this->tabel=$tabel;
    }
    public function create          ($arrayProperty){
        $tb=$this->getDB($this->tabel);
        $tb->cols=["post_title","post_content","post_excerpt","post_name","post_type"];
        $tb->insert($arrayProperty, TRUE);
    }
    public function delet           ($id){
        $this->delet_item($this->tabel, $id);
    }
    public function update          ($arrayProperty){}
    public function getAll(){     return   $this->getDB($this->tabel)->select("WHERE `post_type`= ?",["product"])->fetchAll();}
    public function get($id){     return   $this->getDB($this->tabel)->select("WHERE `id`= ? AND `post_type`= ? ", [$id,"product"])->fetchAll();}
    
    
    }
    
class meta_data extends object_data{
    public $tabelName=null;
    public function __construct($tabelName="wp_postmeta") {
        $this->tabelName=$tabelName;
    }
    function dele($id){}
    function update(){}
    function get(){}
    function insert(){}
    
    
}    
    
   
$product=new product();
//dump($product->get(12)); 
//post_title
//post_content
//post_excerpt
//post_name ->url

$metaPost=new meta_data();

//$product->create(["game","this is post content","this is post mini","dsfasdfada","product"]);


dump($product->getAll());
