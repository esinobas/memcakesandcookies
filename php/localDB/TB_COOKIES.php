<?php
   include_once('TableImage.php');
   
   class TB_COOKIES extends TableImage{

      function __construct(){
      //   parent::__construct();
      }
      
      public function  __destruct(){
         
      }
      
      static public function create($thePath, $theName, $theDesc){
         
         
         TableImage::insertIntoTable($thePath,$theName, $theDesc, TypeCookieC);    
      }
      
      static public function getAll(){
        
         return TableImage::getAll(TypeCookieC);     
      }
      
  }
?>