<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    require_once __DIR__.'/object_data.php';

/**
 * Description of meta_data
 *
 * @author omid
 */
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
        