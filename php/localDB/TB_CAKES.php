<?php
   include_once('TableImage.php');
   
   
   class TB_CAKES extends TableImage{

      function __construct(){
      //   parent::__construct();
      }
      
      public function  __destruct(){
         
      }
      
      static public function create($thePath, $theName, $theDesc){
         
         printf("path: %s. file: %s. Desc: %s<br>\n", $thePath, $theName, $theDesc);
         $result = TableImage::insertIntoTable($thePath, $theName, $theDesc, TypeCakeC);
         
        /* if  ($result== 0){     
            
            $obj = new TB_CAKES();
            $obj->setPath($thePath);
            $obj->setNameFile($theName);
            $obj->setDescription($theDesc);
            $obj->setType(TypeCakeC);    
            
            return $obj;
            
         }else{
            return null;
         }*/
     }
     
      static public function getAll(){
        
         return TableImage::getAll(TypeCakeC);     
      }
      
  }
?>