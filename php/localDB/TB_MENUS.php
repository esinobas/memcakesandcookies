<?php

   include_once("ddbb.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/MySqlDAO.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/DBIterator.php");
   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
   include_once 'TB_COLLECTION.php';
   
   define('tableMenuC','TB_MENU');
   define('idC','ID');
   define('optionC','option_menu');
   
   define('logConfigurationC', $_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
   
   
   class TB_MENUS{
     
      protected $idM;
      protected $optionM;
      private $loggerM;
      
      /*function __construct(){
         
      } */  
      
      function __construct($theId){
         
         $this->loggerM = Logger::getLogger(__CLASS__);
         $this->loggerM->trace("Enter");
         $this->loggerM->trace("Create menu con Id [ " . $theId ." ]");
         $this->idM = $theId;
         $this->loggerM->trace("Exit");
         
      }     

      
      function __destruct(){
         $this->loggerM->trace("Enter");
         $this->loggerM->trace("Exit");
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
  

     static public function getMenu(){
        
        
        Logger::configure(logConfigurationC);
        $logger = Logger::getLogger(__CLASS__);
        
        $logger->trace("Enter");

        $query = sprintf("select %s, %s from %s"
                           ,idC
                           ,optionC
                           ,tableMenuC);
                           
        
                     
         $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC); 
         
         $conn->connect();
         
         $result;
         $rows;
                
         if($conn->isConnected()) {
           $logger->trace("The connection was established successfully");
           $logger->debug("Run query [ " . $query ." ]");
           $result = $conn->query($query);
            
             if ($result != null){
               
              $numRows = count($result);
               
                $idx = 0;
                while ( $idx < $numRows){
                   
                   /*$option = new TB_MENUS();
                   $option->setId($result[$idx][idC]);*/
                   $logger->debug("Create option menu with id [ ". 
                                      $result[$idx][idC] ." ] and option [ ".
                                    $result[$idx][optionC] ." ]" );
                   $option = new TB_MENUS($result[$idx][idC]);
                   $option->setOption($result[$idx][optionC]);
                   $rows[$idx] = $option;
                   $idx ++;
                }
            }
            $conn->closeConnection();       
         }else{
            $logger->error("An error is produced in database connection");
         }   
        
         $logger->trace("Exit");
       return new DBIterator($rows);
      
      
      }
  
      static public function hasSubmenu($theId){
         
         Logger::configure(logConfigurationC);
         $logger = Logger::getLogger(__CLASS__);
         
      
         $logger->trace("Enter");
         $logger->trace("Check if the menu id [ " . $theId . " ] has collections");
         $collections = TB_COLLECTION::getCollectionsFromMenu($theId);
         $logger->trace("The menu id [ ". $theId . " ] has [ "
               . $collections->getNumRows() . " ] collections");
         if ($collections->getNumRows() != 0 ){
            $logger->trace("The menu id [ " . $theId . " ] has submenu");
         }else{
            $logger->trace("The menu id [ " . $theId . " ] has NOT submenu");
         }
         $logger->trace("Exit");
         return ($collections->getNumRows() != 0);

      }
  
     static public function getIdByOption($theOption){
        
        Logger::configure(logConfigurationC);
        $logger = Logger::getLogger(__CLASS__);
        
        $logger->trace("Enter");
        
        $query = sprintf("select %s from %s where UCASE(%s) = '%s'"
                         ,idC
                         ,tableMenuC
                         ,optionC
                         ,strtoupper($theOption));
       
        $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC); 
         
        $conn->connect();
         
        $result;
        $id; 
       
        if($conn->isConnected()) {
           $logger->trace("The connection was established successfully");
           $logger->debug("Run query [ " . $query ." ]");
           $result = $conn->query($query);
            
           if ($result != null){
              $id = $result[0][idC];  
              $logger->debug("The ".idC." obtained is [ " . $id ." ]");  
           }
          $conn->closeConnection(); 
        }
        $logger->trace("Exit");
        return $id;
     }
 
     static public function insertSubMenu($theParent, $theSubmenu){
        
        $logger->trace("Enter");
        $query = sprintf("insert into %s (%s,%s) values ('%s',%s)"
                           ,tableMenuC
                           ,optionC
                           ,optionParentC
                           ,$theSubmenu
                           ,$theParent);
                        
       $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
           
       $conn->connect();
       $result = 0;
                
       if($conn->isConnected()) {
             
       $result = $conn->sqlCommand($query);
             
       }
       $lastId = $conn->getLastId();       
       $conn->closeConnection();
       $logger->trace("Exit");
       return $lastId;                                 
     
     }
   };

?>
