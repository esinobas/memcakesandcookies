<?php 
/**
 * 
 * Class with the functions to handler the information about files (images)
 * in a server with database 
 * 
 */

   include_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TableImage.php');
   include_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_IMAGE_COLLECTION.php');
   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
   
   
       /*Declare constants for the operations
       */
     /**
       * 
       * @var Constant to indicates the command to check if a file exists in DDBB
       */
     const commandExistsC = "ExistFile";
     
     /**
      * 
      * @var Constant to indicates the commnad to insert a new image in the DDBB
      */
     const commandInsertNewImageC = "Insert new Image";
     
     /**
      * 
      * @var Constant to indicates the commando to insert the relationship 
      * between the collections and the images
      */
     const commandInsertImageInCollectionC = "Insert image in collection";
   
      /**
       * 
       * @var Constant to define the parameter name of the file.
       */
      const fileNameC = "FileName";
      
      const pathC = "path";
      const fileC = "file";
      const descC = "desc";
      const imageTypeC = "typeImage";
      const collectionC = "collection";
      
   
      
   
   function existImageInDDBB($theImage, $theLogger){
      
      $theLogger->trace("Enter");
      $theLogger->debug("Checking if the image [ ".$theImage." ] exist in the DDBB");
      $returnValue = false;
      if (TableImage::existImage($theImage)){
         $returnValue =  true;
      }
      
      $theLogger->debug("The image [ ".$theImage." ] " .
            ($returnValue ? " exists in Database":"doesn't exist in the database"));
      $theLogger->trace("Exit");
      return $returnValue;
   }
   
   /**
    * Function that inserts a new image in the database. First it inserts the 
    * image in a table where are all the images and after, it inserts in other
    * table the relationship between the image and the collection to which the 
    * image belongs.
    * 
    * @param string $thePath. Path where the file is saved in the server
    * @param string $theFile. The file name
    * @param string $theDesc. Image description
    * @param string $theType. Type of image
    * @param string $theCollection. Collection to which the image belongs
    * @param Logger $theLogger. Objecto to logs the actions.
    * @return boolean True value when the image is successfuly inserted.
    */
   function insertNewImage($thePath, $theFile, $theDesc , $theType, 
                                        $theCollection, $theLogger){
      
      $theLogger->trace("Enter");
      $theLogger->debug("Trying insert new image with the following parameters:\n".
      "Path [ " . $thePath . " ]\nFile Name [ " . $theFile . " ]\n".
       "Description [ " . $theDesc . " ]\nType [ " . $theType . " ]\n".
      "Collection [ " . $theCollection . " ]\n");
      
      $result = TB_IMAGE_COLLECTION::insertNewImage($thePath, $theFile, $theDesc, $theType, 
                                                       $theCollection);
      
      $theLogger->debug("Result [ " .($result ? "true": "false"). " ]");
      $theLogger->trace("Exit");
      return $result;
   }
   
   
   
   function insertImageCollection($thePath, $theImage, $theCollection, $theLogger){
      $theLogger->trace("Enter");
      $theLogger->debug("Trying insert the image [ ".$theImage." ] in collection [ ".
            $theCollection . " ]");
      
      $result = TB_IMAGE_COLLECTION::insertImageInCollection($thePath, $theImage, $theCollection);
      $theLogger->degug("Result [ " .($result ? "true": "false"). " ]");
      $theLogger->trace("Exit");
      return $result;
      
   }
   
   /**
    * Set up and initialize the object logger for write log
    */
   Logger::configure($_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
   $loggerM = Logger::getLogger('FileBrowserDataBaseCommands');
  
   $theCommand = $_POST["command"];
   $loggerM->debug("The command is [ ". $theCommand ." ]");
   $returnValue = "command unkonwn";
   switch ($theCommand){
      case commandExistsC:
         $theFile = $_POST[fileNameC];
         if (existImageInDDBB($theFile, $loggerM)){
            $returnValue = "true";
         }else{
            $returnValue = "false";
         }
         break;
         
      case commandInsertNewImageC:
         $thePath = $_POST[pathC];
         $theFile = $_POST[fileC];
         $theDesc = $_POST[descC];
         $theImageType = $_POST[imageTypeC];
         $theCollection = $_POST[collectionC];
         
         if (insertNewImage($thePath, $theFile, $theDesc, $theImageType, 
                  $theCollection, $loggerM)){
            
            $returnValue = "true";
         }else{
            $returnValue = "false";
         }
         break;
         
      case commandInsertImageInCollectionC:
         
         $thePath = $_POST[pathC];
         $theFile = $_POST[fileC];
         $theCollection = $_POST[collectionC];
         if (insertImageCollection($thePath, $theFile, $theCollection, $loggerM)){
            
            $returnValue = "true";
         }else{
            $returnValue = "false";
         }
         break;
         
      
   }
   $loggerM->debug("Exit with result [ " . $returnValue . " ]");
   echo $returnValue;
?>