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
       * private properties
       */
      
      /**
       * Static methods
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
               $query=sprintf("select %s from %s where %s='%s'"
                                                ,TB_Collection_IdCollectionC
                                                ,TableCollectionC
                                                ,TB_Collection_CollectionNameC
                                                ,$theCollection);
            
               $logger->trace("Get the collection id [ " . $query ." ]");
               $result = $conn->query($query);
               $collectionId = 0;
               if ($result != null){
            
                  if ( count($result) != 0){
                     $collectionId = $result[0][TB_Collection_IdCollectionC];
                  }else{
                     $returnValue = false;
                  }
                
               }else{
                  $returnValue = false;
               }
               $logger->trace("The collection ID is [ " . $collectionId . " ]");
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
               }else{
                  $logger->error("An error is produced in stament");
                  $returnValue = false;
               }
            }
            
            if ($returnValue ){
               $logger->trace("Insert the relationship between [ " . $theFileName .
                     " ] and [ " . $theCollection . " ]");
            
               $query = sprintf("insert into %s(%s,%s) values (%d,%d)"
                                             ,TableImageCollectionC
                                             ,TB_ImageCollection_idImageC
                                              ,TB_ImageCollection_idCollectionC
                                              ,$typeId
                                              ,$collectionId);
            
               $logger->debug("Executing stament [ " . $query . " ]");
            
               $result = $conn->sqlCommand($query);
               $lastId = 0;
               if ($result == 0){
                  $logger->debug("The stament was executed correctly");
               
               }else{
                  $logger->error("An error is produced in stament");
                  $returnValue = false;
               }
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
      
   }
 
?>