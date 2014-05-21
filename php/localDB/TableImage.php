<?php

   include_once("ddbb.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/MySqlDAO.php");
   
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/DBIterator.php");
   
   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');

   /**
    * File with the definition of the  table that allows access to the data image
    */
       
   define('TableNameC','TB_IMAGES');
   define('IdC','Id');
   define('PathC', 'Path');
   define('NameC', 'Name');
   define('DescC','Descripcion');
   define('TypeC', 'Type');   
   
   define('TypeCakeC', 1);
   define('TypeCookieC', 2);
   define('TypeModelC', 3);
      
   class TableImage{
      
      protected $idM;
      protected $pathM;
      protected $nameM;
      protected $descriptionM;
      protected $typeM;
      protected $existM;
      
     
      private $loggerM;
      
      function __construct(){
         //Logger::configure($_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
         $this->loggerM = Logger::getLogger(__CLASS__);
         /*$this->loggerM->trace(("Enter"));
         $this->loggerM->trace(("Exit"));*/
      }        
      
      function __destruct(){
        
      }
      
      protected function setId($theId){
     
         $this->idM = $theId;
      }
      
      public function getId(){
            
         return $this->idM;   
      }    
      
      public function setPath($thePath){
         
         $this->pathM = $thePath;   
      }
      
      public function getPath() {
      
         return $this->pathM;      
      }
      
      public function setNameFile($theName){
      
         $this->nameM = $theName;   
      }
      
      public function getNameFile(){
      
         return $this->nameM;   
      }
      
      public function setDescription($theDesc){
      
         $this->descriptionM = $theDesc;  
      }
      
      public function getDescription(){
         
         return $this->descriptionM;      
      }
     
      protected function setType($theType){
        
         $this->typeM = $theType;     
      }
     
      public function getType(){
      
         return $this->typeM;     
      }
      
      static protected function insertIntoTable($thePath, $theName, $theDesc, $theType){
         
         $query = sprintf("insert into %s (%s,%s,%s,%s) values ('%s', '%s', '%s', %d)",
                                          TableNameC
                                          ,PathC
                                          ,NameC
                                          ,DescC
                                          ,TypeC
                                          ,$thePath
                                          ,$theName
                                          ,$theDesc
                                          ,$theType  
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
      
      static public function getAll($theType) {
       
         
         $query = sprintf("select %s, %s, %s ,%s from %s where %s=%d order by %s desc",
          
                                   IdC
                                   ,PathC
                                   ,NameC
                                   ,DescC
                                   ,TableNameC
                                   ,TypeC
                                   ,$theType
                                   ,IdC 
                                    );  
                       
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
                    
                   $obj = new TableImage();
                   $obj->setId($result[$idx][IdC]);
                   $obj->setPath($result[$idx][PathC]);
                   $obj->setNameFile($result[$idx][NameC]);
                   $obj->setDescription($result[$idx][DescC]);
                   $obj->setType($theType);
                   $rows[$idx] = $obj;
                   $idx ++;                 
                }
                   
            }
            $conn->closeConnection();   
         }
          
          return new DBIterator($rows);
      }
      
      static public function delete($theId){

         $query = sprintf("delete from %s where %s=%d", TableNameC
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
  
  static public function selectImageById($theId){
  
     $query = sprintf("select %s, %s, %s ,%s ,%s from %s where %s=%d",
          
                                   IdC
                                   ,PathC
                                   ,NameC
                                   ,DescC
                                   ,TypeC
                                   ,TableNameC
                                   ,IdC 
                                   ,$theId
                                    );   
              $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
          
     $conn->connect();
     $result;
     $obj = null;
     
                   
     if($conn->isConnected()) {
             
        $result = $conn->query($query);
             
        if ($result != null){
               
           if (count($result) > 0){
              $obj = new TableImage();
              $obj->setId($result[0][IdC]);
              $obj->setPath($result[0][PathC]);
              $obj->setNameFile($result[0][NameC]);
              $obj->setDescription($result[0][DescC]);
              $obj->setType($result[0][TypeC]);
           }
       }
       $conn->closeConnection();
    }

    return $obj;
           
  }
  
  static public function updateDescription($theId, $theDescription){
  
     $query = sprintf("update %s set %s='%s' where %s=%d"
                      ,TableNameC
                      ,DescC
                      ,$theDescription
                      ,IdC
                      ,$theId);
                      
                      
      $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
           
      $conn->connect();
      $result = 0;
                
       if($conn->isConnected()) {
             
          $result = $conn->sqlCommand($query);
             
       }
              
       $conn->closeConnection();
                    
     
  } 
  
  /**
   * It checks if an image now is stored in the table or it is not stored.
   * 
   * @param String $theImage: The file name of the image
   * 
   * @return A boolean value that indicates if the image is stored or it is 
   * not stored in the table.
   */
  static public function existImage($theImage){
     
     //Logger::configure($_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
     $logger = Logger::getLogger(__CLASS__);
 
     
     $logger->trace("Enter");
     $logger->debug("Search the image [ ".$theImage." ] in table [ " .
              TableNameC." ]");
     
     $thePath = substr($theImage,0,strrpos($theImage, "/"));
     $theName = substr($theImage, strrpos($theImage, "/") + 1, 
                            strlen($theImage) - strrpos($theImage, "/"));
     
     $logger->trace("Path [ " . $thePath . " ]. File Name [ " . $theName . " ]");

     
     $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
     
     $conn->connect();
     $result;
     $obj = null;
     $returnValue = false;
     
     if($conn->isConnected()) {
        $logger->trace("The connection was established sucessfully");
        $query = sprintf("select count(%s) as existsRow from %s where %s='%s' and %s='%s'"
              ,IdC
              ,TableNameC
              ,PathC
              ,$thePath
              ,NameC
              ,$theName);
        $logger->trace("Run query [ " .$query . " ]");
        $result = $conn->query($query);
         
        if ($result != null){
           $logger->trace("A result was obtained sucessfully");
           if (count($result) > 0){
              $logger->trace("The image [ ".
                     ($result[0]['existsRow'] >0 ? "exists" : "doesn't exist") 
                      . " ]");
              $returnValue = ($result[0]['existsRow'] > 0);
           }
           
        }else{
           $logger->warn("The query result can not be obtained");
        }
     }else{
        $logger->error("The connection with the database can not establisehd");
     }
     
     $logger->trace("Exit");
     return $returnValue;
  }
}
?>