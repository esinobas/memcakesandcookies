<?php

   include_once("ddbb.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/MySqlDAO.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/DBIterator.php");
   
   define('tableNameC','TB_MENU');
   define('idC','ID');
   define('menuC','menu');
   define('menuParentC','menu_parent'));
   
   class TableMenu{
     
      private $idM;
      private $menuM;
      private $menuParentM;
      
      function __construct(){
        
      }        
      
      function __destruct(){
        
      }
  
      public function getId(){
         
         $this->idM;
      
      }
  
      public function getMenu(){

         $this->menuM;      
      }
  
      public function menuParent(){

         $this->menuParentM;      
      }
  
      static public function getMenu($theParentMenu){
 
         $query = sprintf("select %s, %s, %s from %s, where %s = %s"
                           ,idC
                           ,menuC
                           ,menuParentC
                           ,tableNameC
                           ,menuParentC
                           ,$theParentMenu);
                     
        die($query);      
      
      }
   };

?>