<?php
   include_once('TableImage.php');
   
   class TB_MODELING extends TableImage{

      function __construct(){
      //   parent::__construct();
      }
      
      public function  __destruct(){
         
      }
      
      static public function create($thePath,$theName,$theDesc){
         
         //printf("Cretate TB_CAKES::%s, %s<br>", $thePath, $theDesc);
         TableImage::insertIntoTable($thePath, $theName,$theDesc, TypeModelC);    
      }
      
      static public function getAll(){
        
         return TableImage::getAll(TypeModelC);     
      }
      
  }
?>