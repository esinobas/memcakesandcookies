<?php

   include_once("ddbb.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/MySqlDAO.php");
   
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/DBIterator.php");

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
      
      function __construct(){
        
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
}
?>