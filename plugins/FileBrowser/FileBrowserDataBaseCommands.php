<?php 
/**
 * 
 * Class with the functions to handler the information about files (images)
 * in a server with database 
 * 
 */

   include_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TableImage.php');
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
       * @var Constant to define the parameter name of the file.
       */
      const fileNameC = "FileName";
   
      
   
   function existImageInDDBB($theImage, $theLogger){
      
      $theLogger->trace("Enter");
      $theLogger->debug("Checking if the image [ ".$theImage." ] exist in the DDBB");
      $returnValue = false;
      if (TableImage::existImage($theImage)){
         $returnValue =  true;
      }
      
      $theLogger->debug("The image [ ".$theImage." ] " .
            ($returnValue ? " exists in Database":"doesn't exist in database"));
      $theLogger->trace("Exit");
      return $returnValue;
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
      
   }
   $loggerM->debug("Exit with result [ " . $returnValue . " ]");
   echo $returnValue;
?>