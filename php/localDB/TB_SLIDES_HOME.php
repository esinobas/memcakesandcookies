<?php

   include_once('ddbb.php');
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/MySqlDAO.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/DBIterator.php");
   
   // Definition of the data base tables
   define('tableNameC', 'TB_SLIDES_HOME');
   define('IdC', 'Id');
   define('pathC','ImagePath');
   
   
   class TB_SLIDES_HOME{
      
      /**
       * Properties
       */
      private $idM;
      
      private $pathM;
            
      private $existM;
      
      /**
       * Constructor
       */
      public function __construct(){

         $this->existM = false;         
      
      }   
      
      /**
       * Desctructor
       */
      public function __destruct(){
         
      }
      
      protected function setId($theId){
      
         $this->idM = $theId;
      }
      
      protected function setExists($theValue){
      
         $this->existM = $theValue;
      }
      
      public function setPath($thePath){
      
         $this->pathM = $thePath;      
      }
      
      public function getId() {
      
         return $this->idM;      
      }
      public function getPath(){
      
         return $this->pathM;   
      }
      
      public function exists(){
      
           return $this->existsM;   
      }
      
      
     static protected function insertIntoTable($thePath){
         
                 
         $query = sprintf("Insert Into %s (%s) Values ('%s')", tableNameC
                                                                       ,pathC
                                                                       ,$thePath
                                                                       );
        
          $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
           
          $conn->connect();
          $result = 0;
                   
          if($conn->isConnected()) {
             
             $result = $conn->sqlCommand($query);
             
          }
          $conn->closeConnection();
          return $result;
      }
      
      static public function create($thePath){
      
         $result = TB_SLIDES_HOME::insertIntoTable($thePath);         
         if  ($result== 0){     
            
            $obj = new TB_SLIDES_HOME();
         
            $obj->setPath($thePath);
            
            return $obj;
            
         }else{
            return null;
         }
           
      }
      
      static public function getAll(){
        
         $query = sprintf("select %s, %s from %s order by %s", IdC, pathC, tableNameC, IdC);
          
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
                    
                    $obj = new TB_SLIDES_HOME();
                    $obj->setId($result[$idx][IdC]);
                    $obj->setExists(true);
                    $obj->setPath($result[$idx][pathC]);
                    $rows[$idx] = $obj;
                    $idx ++;                 
                 }
                   
             }
             $conn->closeConnection();   
          }
          
          return new DBIterator($rows);
           
      }

      static public function delete($theId){

         $query = sprintf("delete from %s where %s=%d", tableNameC
                                                        ,IdC
                                                        ,$theId);
                                                        
         
         $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
           
         $conn->connect();
         $result = 0;
                   
         if($conn->isConnected()) {
             
            $result = $conn->sqlCommand($query);
             
         }else{
           $result = -1;         
         }
         $conn->closeConnection();
         return $result;       
      
      }      
      
      static public function getById($theId){
         
         $query = sprintf("select %s, %s from %s", IdC, pathC, tableNameC);
         
         $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
           
         $conn->connect();
         $result;
         $obj = new TB_SLIDES_HOME();
             
         if($conn->isConnected()) {
            
             $result = $conn->query($query);
             
              if ($result != null){
                
                 $numRows = count($result);
                 
                 if ($numRows > 0){
                    
                    
                    $obj->setId($result[0][IdC]);
                    $obj->setPath($result[0][pathC]);
                    $obj->setExists(true);
                                    
                 }
                   
             }
             
             $conn->closeConnection();
         }   
         return $obj;
      }
   }
?>
