<?php
require './lib/EasyPDO/easypdo.php';
require_once  __DIR__.'/vendor/autoload.php';


$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


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

    
        class product       extends object_data {

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
                $post_id=$tb->LastId();
                $money=12000;
                $meta=new meta_data();

                $_product_attributes=[];
                for ($index = 0; $index < 2; $index++) {
                    $_product_attributes[]=[
                         "name" => "game".$index,
                        "value" => "nice",
                        "position" => $index,
                        "is_visible" => "1",
                        "is_variation" => "0",
                        "is_taxonomy" => "0",
                    ];
                }
                $data=[
                    "_product_image_gallery"=>22,          
                    "_price"=>22,
                    "_low_stock_amount"=>1243,
                    "_sale_price_dates_to"=>1578515399,
                    "_product_image_gallery"=>"1981,1989,1991,1990",
                    "_sale_price_dates_from"=>1577824200,
                    "_sale_price"=>77777,
                    "_regular_price"=>88888,
                    "_thumbnail_id"=>2055,
                    "_product_attributes"=> serialize($_product_attributes),         
                    "_stock_status"=>"instock",
                    "_stock"=>"98589",
                    "_manage_stock"=>"yes"
                ];


                foreach ($data as $key => $value) {
                     $meta->insert($post_id, $key, $value);
                }




            }
            public function delet           ($id){
                $this->delet_item($this->tabel, $id);
            }
            public function update          ($arrayProperty){}
            public function getAll(){     return   $this->getDB($this->tabel)->select("WHERE `post_type`= ?",["product"])->fetchAll();}
            public function get($id){     return   $this->getDB($this->tabel)->select("WHERE `id`= ? AND `post_type`= ? ", [$id,"product"])->fetchAll();}


            }


        class meta_data     extends object_data{
            public $tabelName=null;
            public function __construct($tabelName="wp_postmeta") {
                $this->tabelName=$tabelName;
            }
            function dele($meta_id){}
            function delet_all_postMeta($postID){}
            function get_all_postMeta($post_id){
                return   $this->getdb($this->tabelName)->select("WHERE `post_id`= ? ", [$post_id])->fetchAll();
            }
            function get($meta_id){
                return   $this->getdb($this->tabelName)->select("WHERE `meta_id`= ?", [$meta_id])->fetch();
            }
            function getBYkey($post_id,$meta_key){
                return   $this->getdb($this->tabelName)->select("WHERE `post_id`= ? AND `meta_key`= ? ", [$post_id,$meta_key])->fetch();
            }  
            function update($meta_id,$post_id,$meta_key,$meta_value){}
            function insert($post_id,$meta_key,$meta_value){
                $tb= $this->getDB($this->tabelName);
                $tb->cols=["post_id","meta_key","meta_value"];
                $tb->insert([$post_id,$meta_key,$meta_value], true);
            }


        }    


        class Term          extends object_data{

                      public $tabelName=null;
                      public function __construct($tabelName="wp_terms") 
                      {
                          $this->tabelName=$tabelName;
                          $this->table_name=$tabelName;}

                      function creat($name,$slug)
                      {
                         $tb=$this->getDB($this->tabelName);
                         $tb->cols=["name","slug"];
                         $tb->insert([$name,$slug],true);
                      }
                      function remove($term_id)
                      { 
                          $this->deletItem($term_id,"term_id");
                      }
                      function update()
                      { }
                      function getAll()
                      {
                           return $this->list_all_item($this->tabelName);
                      }
                      function get($term_id)
                      {
                          return $this->getDB($this->tabelName)->select("WHERE `term_id` = ?",[$term_id])->fetch();

                      }
        }


        class TermRelation  extends object_data{
            
              
                public $tabelName=null;
                public function __construct($tabelName="wp_term_relationships")
                { $this->tabelName=$tabelName; $this->table_name=$tabelName;}

                
                function creat($object_id,$term_taxonomy_id,$term_order=0)
                {
                    $tb=$this->getDB($this->tabelName);
                    $tb->cols=["object_id","term_taxonomy_id","term_order"];
                    $tb->insert([$object_id,$term_taxonomy_id,$term_order],true);

                }
                function remove()
                {

                }
                function update()
                {}
                function getAll()
                {
                     return $this->list_all_item($this->tabelName);
                }
                function get($term_taxonomy_id)
                {
                    return $this->getDB($this->tabelName)->select("WHERE `term_taxonomy_id` = ?",[$term_taxonomy_id])->fetchAll();
                }
                 function get_by_obj($object_id)
                {
                    return $this->getDB($this->tabelName)->select("WHERE `object_id` = ?",[$object_id])->fetchAll();
                }
          }

    

      $product=new product();
    //$product->create(["game","this is post content","this is post mini","dsfasdfada","product"]);


