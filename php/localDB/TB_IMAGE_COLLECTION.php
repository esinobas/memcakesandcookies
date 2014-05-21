<?php

/**
 * Class to access to the data in the table TB_IMAGE_COLLECTION
 */

   include_once("ddbb.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/MySqlDAO.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/DBIterator.php");
   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
   
 
   define('TableImageCollectionC', 'TB_COLLECTION_IMAGES');
   define('TB_ImageCollection_idImageC', 'Id_Image');
   define('TB_ImageCollection_idCollectionC', 'Id_Collection');
   
   define('TableCollectionC', 'TB_COLLECTION');
   define('TB_Collection_IdCollectionC', 'Id');
   define('TB_Collection_CollectionNameC', 'Name');
   
   define('TableImageC', 'TB_IMAGES');
   define('TB_Image_IdC','Id');
   define('TB_Image_PathC', 'Path');
   define('TB_Image_NameC', 'Name');
   define('TB_Image_DescC','Descripcion');
   define('TB_Image_TypeC', 'Type');
   
   define('TableTypes', 'TB_TYPES');
   define('TB_Types_Id', 'ID');
   define('TB_Types_Type', 'TYPE');
 
   define('logConfigurationC', $_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
   
   class TB_IMAGE_COLLECTION{
      
      /**
       * protected properties
       * 
       */
      protected $imageIdM;
      protected $collectionIdM;
      protected $collectionNameM;
      protected $pathM;
      protected $imageNameM;
      protected $descriptionM;
      
      /**
       * private properties
       */
      private $loggerM = null;
      
      /**
       * public methods
       */
      
      /**
       * Class constructor
       * @param Number $theImageId
       * @param Number $theCollectioId
       * @param String $theCollectionName
       * @param String $thePath
       * @param String $theImageName
       * @param String $theDescription
       */
      function __construct($theImageId, $theCollectioId, $theCollectionName,
                            $thePath, $theImageName, $theDescription){
         
         $this->loggerM = Logger::getLogger(__CLASS__);
         $this->loggerM->trace("Enter");
         
         $this->imageIdM = $theImageId;
         $this->collectionIdM = $theCollectioId;
         $this->collectionNameM = $theCollectionName;
         $this->pathM = $thePath;
         $this->imageNameM = $theImageName;
         $this->descriptionM = $theDescription;
         
         $this->loggerM->trace("Exit");
      }
      
      /**
       * Class destructor
       */
      function __destruct(){
         
         $this->loggerM->trace("Enter");
         
         $this->loggerM->trace("Exit");
      }
      /**
       * @return Number
       */
      public function getImageId(){
         return $this->imageIdM;
      }
      /**
       * 
       * @return Number
       */
      public function getCollectionId(){
         return $this->collectionIdM;
      }
      /**
       * 
       * @return String
       */
      public function getCollectioName(){
         return $this->collectionNameM;
      }
      /**
       * 
       * @return String
       */
      public function getImagePath(){
         return $this->pathM;
      }
      /**
       * 
       * @return String
       */
      public function  getImageName(){
         return $this->imageNameM;
      }
      /**
       * 
       * @return String
       */
      public function getDescription(){
         return $this->descriptionM;
      }
      /**
       * private methods
       */
      
      /**
       * 
       * @param MySQLDAO $theConnection. Connection to access to the database
       * @param String $theCollection. The collection name that will be searched
       * @param Number $collectionId.The collection id that is returned
       * @return boolean. Search status.
       */
      static private function getCollectionIdByName($theConnection, $theCollection,
                                     &$collectionId){
         
         $logger = Logger::getLogger(__CLASS__);
         $logger->trace("Enter");
         
         $logger->trace("Search ID of Collection  [ " . $theCollection ." ]");
         
         $query=sprintf("select %s from %s where %s='%s'"
               ,TB_Collection_IdCollectionC
               ,TableCollectionC
               ,TB_Collection_CollectionNameC
               ,$theCollection);
             
         $logger->trace("Get the collection id [ " . $query ." ]");
         $result = $theConnection->query($query);
         
         $returnValue = true;
         if ($result != null){
         
            if ( count($result) != 0){
               $collectionId = $result[0][TB_Collection_IdCollectionC];
               $logger->trace("The collection ID is [ " . $collectionId . " ]");
            }
         
         }else{
            $returnValue = false;
            $logger->error("A error has been produced [ " . $theConnection->getSqlError() ." ]");
         }
         
         
         $logger->trace("Exit");
         
         return $returnValue;
         
         
      }
      
      /**
       * 
       * @param MySqlDAO $theConnection. The opened connection to the database
       * @param Number $theImageId. The image identifier
       * @param Number $theCollectionId. The collection identifier
       * @return boolean. True if the insertion was done with successfuly.
       */
      static private function insertRelationImageCollection($theConnection,
                                                            $theImageId,
                                                            $theCollectionId){
      
         $logger = Logger::getLogger(__CLASS__);
         $logger->trace("Enter");
         $logger->trace("Insert relation image [ " . $theImageId . 
               " ] and collection [ " . $theCollectionId ." ]");
         
         
         $query = sprintf("insert into %s(%s,%s) values (%d,%d)"
               ,TableImageCollectionC
               ,TB_ImageCollection_idImageC
               ,TB_ImageCollection_idCollectionC
               ,$theImageId
               ,$theCollectionId);
         
         $logger->debug("Executing stament [ " . $query . " ]");
         
         $result = $theConnection->sqlCommand($query);
         $returnValue = true;

         if ($result == 0){
            $logger->debug("The stament was executed correctly");
             
         }else{
            $logger->error("An error is produced in stament [ ".
                  $conn->getSqlError() . " ]");
         
            $returnValue = false;
         }
         
         $logger->trace("Exit");
         return $returnValue;
      }
      
      /**
       * Static methods
       */
      
      /**
       * Method that insters a new image in the data base and its relationship
       * with the collection to which bleongs.
       * 
       * @param String $thePath. The path where the image is saved in the server
       * @param String $theFileName. The image file name
       * @param String $TheDescription. The image description
       * @param String $theType. The type of the image
       * @param String $theCollection. The collection to which belongs the image
       * @return boolean
       */
      static public function insertNewImage($thePath, $theFileName, 
                             $TheDescription, $theType, $theCollection){
         
         //Logger::configure(logConfigurationC);
         $logger = Logger::getLogger(__CLASS__);
         
         $returnValue = true;
         
         $logger->trace("Enter");
         
         $logger->debug("A new image will be inserted with the following parameters:\n".
              "Path [ " . $thePath . " ]\nFile Name [ " . $theFileName . " ]\n".
             "Description [ " . $TheDescription . " ]\nType [ " . $theType . " ]\n".
              "Collection [ " . $theCollection . " ]\n");
      
         
         $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
         $conn->connect(false);
         if($conn->isConnected()) {
            $logger->trace("The connection with the database was established succcessfully");
            
            $logger->trace("Start the transaction");
            
            $query = sprintf("select %s from %s where %s='%s'"
                                          ,TB_Types_Id
                                          ,TableTypes
                                          ,TB_Types_Type
                                          ,$theType);
            
            $logger->trace("Get the type id [ " . $query ." ]");
            $result = $conn->query($query);
            $typeId = 0; 
            if ($result != null){
            
               if ( count($result) != 0){
                  $typeId = $result[0][TB_Types_Id];
               }else{
                  $returnValue = false;
               }
               
            }else{
               $returnValue = false;
            }
            $logger->trace("The type ID is [ " . $typeId . " ]");
            if ($returnValue ){
               
               $collectionId = 0;
               $returnValue = TB_IMAGE_COLLECTION::getCollectionIdByName($conn,
                                               $theCollection, $collectionId);
               if ($returnValue){
                  $logger->trace("The collection ID is [ " . $collectionId . " ]");
               }
            }
            
            if ($returnValue ){
               $logger->trace("Insert the image in the table [ " . TableImageC .
                  " ]");
            
               $query = sprintf("insert into %s (%s, %s, %s, %s) values ('%s','%s',%d, '%s')"
                                    ,TableImageC
                                    ,TB_Image_PathC
                                    ,TB_Image_DescC
                                    ,TB_Image_TypeC
                                    ,TB_Image_NameC
                                     ,$thePath
                                     ,$TheDescription
                                     ,$typeId
                                     ,$theFileName);
            
               $logger->debug("Executing stament [ " . $query . " ]");
            
               $result = $conn->sqlCommand($query);
               $lastId = 0;
               if ($result == 0){
                  $logger->debug("The stament was executed correctly");
                  $lastId = $conn->getLastId();
                  $logger->trace("The new image id is [ " .$lastId ." ]");
               }else{
                  $logger->error("An error is produced in stament");
                  $returnValue = false;
               }
            }
            
            if ($returnValue ){
               $logger->trace("Insert the relationship between [ " . $theFileName .
                     " ] and [ " . $theCollection . " ]");
            
               
               $returnValue = TB_IMAGE_COLLECTION::insertRelationImageCollection($conn,
                                     $lastId, $collectionId);
            }
            if ($returnValue ){
               $logger->debug("Insertion completed with success");
               $conn->commit();
            }else{
               $logger->warn("Insertion has not been completed");
               $conn->rollback();
            }
            $conn->closeConnection();
         }else{
            $logger->error("The database has not connected");
            $returnValue = false;
         }
         
         $logger->trace("Exit");
         return $returnValue;
      }
      
      /**
       * Method that insert in the dabtabase the relation between a exising inmage
       * and a collection.
       * 
       * @param String $thePath. The image path
       * @param String  $theFile. The image file name
       * @param String $theCollection. The collection name
       * @return boolean. True when the relation is inserted.
       */
      static public function insertImageInCollection($thePath, $theFile, $theCollection){
         
         $logger = Logger::getLogger(__CLASS__);
          
         $returnValue = true;
          
         $logger->trace("Enter");
         
         $logger->debug("Trying insert the a image in a collection with the following parameters:\n".
                        "Path [ " . $thePath . " ]\nImage [ " . $theFile . " ]\n".
                        "Collection [ " . $theCollection ." ]");
         $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
         $conn->connect();
         
         if($conn->isConnected()){
            $logger->trace("The connection with the database was done with successfully");
            $collectionId = 0;
            
            if (TB_IMAGE_COLLECTION::getCollectionIdByName($conn, $theCollection, $collectionId)){
                $logger->trace("The collection [ " . $theCollection .
                     " ] was found and its id is [ " . $collectionId. " ]");
            }else{
                $logger->trace("The collection [ " . $theCollection . " ] has not been found");
                $returnValue = false;
            }
            
            
            $logger->trace("Get image id [ " . $thePath . "/" . $theFile . " ]");   
            
            $query = sprintf("select %s from %s where %s='%s' and %s='%s'"
                                          ,TB_Image_IdC
                                          ,TableImageC
                                          ,TB_Image_PathC
                                          ,$thePath
                                          ,TB_Image_NameC
                                          ,$theFile);
            
            
            
            $logger->trace("Execute query [ " . $query ." ]");
            
            $result = $conn->query($query);
             
           
            if ($result != null){
                
               if ( count($result) != 0){
                  $imageId = $result[0][TB_Image_IdC];
                  $logger->trace("The image ID is [ " . $imageId . " ]");
               }
                
            }else{
               $returnValue = false;
               $logger->error("A error has been produced [ " . $conn->getSqlError() ." ]");
            }
            
            if ($returnValue){
               if (TB_IMAGE_COLLECTION::insertRelationImageCollection($conn,
                $imageId, $collectionId)){
                  $logger->trace("The relation was inserted");
               }else{
                  $logger->error("The relation was not inserted, an error ".
                                  "was produced. [ " . $conn->getSqlError() . " ]");
                  $returnValue = false;
               }
            }
            
            $conn->closeConnection();
         }
         
         $logger->trace("Exit");
         return $returnValue;
      }
      
      static public function getImageFromCollection($theCollection){
         
         $logger=Logger::getLogger(__CLASS__);
         $logger->trace("Enter");
         
         $logger->trace("Get the images which to belong to collection [ " . 
                    $theCollection ." ]");
         
         $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
         $conn->connect();
         
         if($conn->isConnected()){
            $logger->trace("The connection with the database was done with successfully");
            
            $collectionId = 0;
            if (TB_IMAGE_COLLECTION::getCollectionIdByName($conn,
                      $theCollection, $collectionId)){
               $logger->trace("The collection [ " . $theCollection . " ] has the id [ " .
                            $collectionId . " ]");
               
               $query = sprintf("select %s.%s as ImageId,
                                        %s.%s as CollectionId, 
                                        %s.%s as CollectionName,
                                        %s.%s as ImageName,
                                        %s, %s from %s,%s,%s where 
                                        %s.%s=%s.%s and %s.%s=%s.%s and
                                         %s.%s= '%s'"
                                        ,TableImageC,TB_Image_IdC
                                        ,TableCollectionC,TB_Collection_IdCollectionC
                                        ,TableCollectionC,TB_Collection_CollectionNameC
                                        ,TableImageC,TB_Image_NameC
                                        ,TB_Image_PathC
                                        ,TB_Image_DescC
                                        ,TableImageC
                                        ,TableCollectionC
                                        ,TableImageCollectionC
                                        ,TableImageC,TB_Image_IdC
                                        ,TableImageCollectionC,TB_ImageCollection_idImageC
                                        ,TableImageCollectionC,TB_ImageCollection_idCollectionC
                                        ,TableCollectionC, TB_Collection_IdCollectionC
                                        ,TableCollectionC, TB_Collection_CollectionNameC
                                        ,$theCollection);
               
               $logger->trace("Execute query [ " . $query . " ]");
               
               $result = $conn->query($query);
               if ($result != null){
                  $rows;
                  $numRows = count($result);
                  $logger->trace("The query has [ " . $numRows ." ] rows");
                  for ($idx = 0;$idx < $numRows; $idx++){
                     $rows[$idx] = new TB_IMAGE_COLLECTION($result[$idx]["ImageId"], 
                                                          $result[$idx]["CollectionId"], 
                                                          $result[$idx]["CollectionName"], 
                                                          $result[$idx][TB_Image_PathC], 
                                                          $result[$idx]["ImageName"], 
                                                          $result[$idx][TB_Image_DescC]);
                  }
               }
            }
            $conn->closeConnection();
         }else{
            $logger->error("An error was produced in the connection  [ " .
                   $conn->getConnectError() . " ]");
         }
         $logger->trace("Exit");
         return new DBIterator($rows);
      }
      
   }
 
?>