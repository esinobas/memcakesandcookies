<?php

   include_once("ddbb.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/MySqlDAO.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/DBIterator.php");
   
   define('tableNameC','TB_MENU');
   define('idC','ID');
   define('optionC','option_menu');
   define('optionParentC','option_parent');
   
   class TB_MENUS{
     
      protected $idM;
      protected $optionM;
      protected $optionParentM;
      
       
      
      /*function __construct(){
         
      } */  
      
      function __construct($theId){
         $this->idM = $theId;
      }     
      
      function __destruct(){
        
      }
  
      protected function setId($theId) {
         
         $this->idM = $theId;
      }
  
      public function getId(){
         
        return  $this->idM;
      
      }
  
      public function getOption(){

        return  $this->optionM;      
      }
      public function setOption($theOption){
      
         $this->optionM = $theOption;      
      }
  
      public function setOptionParent($theOptionParent){
         
         $this->optionParentM = $theOptionParent;
      }
  
      public function getOptionParent(){

         return $this->optionParentM;      
      }
  
      static public function getMenu($theParentMenu){
 
         $query = sprintf("select %s, %s, %s from %s where %s = %s"
                           ,idC
                           ,optionC
                           ,optionParentC
                           ,tableNameC
                           ,optionParentC
                           ,$theParentMenu);
                           
        
                     
         $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC); 
         
         $conn->connect();
         
         $result;
         $rows;
                
         if($conn->isConnected()) {
             
           $result = $conn->query($query);
            
             if ($result != null){
               
              $numRows = count($result);
               
                $idx = 0;
                while ( $idx < $numRows){
                   
                   /*$option = new TB_MENUS();
                   $option->setId($result[$idx][idC]);*/
                   $option = new TB_MENUS($result[$idx][idC]);
                   $option->setOption($result[$idx][optionC]);
                   $option->setOptionParent($result[$idx][optionParentC]);
                   $rows[$idx] = $option;
                   $idx ++;
                }
            }
            $conn->closeConnection();       
         }   
        
      
       return new DBIterator($rows);
      
      
      }
  
      static public function hasSubmenu($theId){
      
 
         $query = sprintf("select count(%s) from %s where %s = %s"
                          ,idC
                          ,tableNameC
                          ,optionParentC
                          ,$theId);
                          
         $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC); 
         
         $conn->connect();
         
         $result;
         $hasSubmenu = false;
                
         if($conn->isConnected()) {
            $result = $conn->query($query);
            $conn->closeConnection();   
         }else{
            return false;
         }
         
         if (intval($result[0]['count('.idC.')'] > 0 )){
            return true;         
         }else{
            return false;
         } 
         
              
      }
   };

?>