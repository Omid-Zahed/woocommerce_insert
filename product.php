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
    
    public function __construct     ($tabel) { 
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
    
    
    
    $bb=  unserialize('a:5:{s:5:"width";i:1920;s:6:"height";i:1080;s:4:"file";s:16:"2020/01/wall.jpg";s:5:"sizes";a:12:{s:6:"medium";a:4:{s:4:"file";s:16:"wall-300x169.jpg";s:5:"width";i:300;s:6:"height";i:169;s:9:"mime-type";s:10:"image/jpeg";}s:5:"large";a:4:{s:4:"file";s:17:"wall-1024x576.jpg";s:5:"width";i:1024;s:6:"height";i:576;s:9:"mime-type";s:10:"image/jpeg";}s:9:"thumbnail";a:4:{s:4:"file";s:16:"wall-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:12:"medium_large";a:4:{s:4:"file";s:16:"wall-768x432.jpg";s:5:"width";i:768;s:6:"height";i:432;s:9:"mime-type";s:10:"image/jpeg";}s:9:"1536x1536";a:4:{s:4:"file";s:17:"wall-1536x864.jpg";s:5:"width";i:1536;s:6:"height";i:864;s:9:"mime-type";s:10:"image/jpeg";}s:14:"post-thumbnail";a:4:{s:4:"file";s:17:"wall-1200x675.jpg";s:5:"width";i:1200;s:6:"height";i:675;s:9:"mime-type";s:10:"image/jpeg";}s:21:"woocommerce_thumbnail";a:5:{s:4:"file";s:16:"https://media.geeksforgeeks.org/wp-content/uploads/20190719161521/core.jpg";s:5:"width";i:450;s:6:"height";i:450;s:9:"mime-type";s:10:"image/jpeg";s:9:"uncropped";b:0;}s:18:"woocommerce_single";a:4:{s:4:"file";s:16:"wall-600x338.jpg";s:5:"width";i:600;s:6:"height";i:338;s:9:"mime-type";s:10:"image/jpeg";}s:29:"woocommerce_gallery_thumbnail";a:4:{s:4:"file";s:16:"wall-100x100.jpg";s:5:"width";i:100;s:6:"height";i:100;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:16:"wall-450x450.jpg";s:5:"width";i:450;s:6:"height";i:450;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:16:"wall-600x338.jpg";s:5:"width";i:600;s:6:"height";i:338;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:16:"wall-100x100.jpg";s:5:"width";i:100;s:6:"height";i:100;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}');
    
    dd($bb);
    
dd();
$product=new product("wp_posts");
//dump($product->get(12)); 
//post_title
//post_content
//post_excerpt
//post_name ->url

$product->create(["game","this is post content","this is post mini","%d9%84%d9%be-%d8%aa%d8%a7%d9%be-15-%d8%a7%db%8c%d9%86%da%86%db%8c-%d9%84%d9%86%d9%88%d9%88-%d9%85%d8%af%d9%84-ideapad-330-fa","product"]);


dump($product->getAll());
