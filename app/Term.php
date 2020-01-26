<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Term
 *
 * @author omid
 */
    require_once __DIR__.'/object_data.php';
    
    class Term  extends object_data{

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
    
         