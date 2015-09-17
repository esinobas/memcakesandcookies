<?php

   /**
    * File with file system commands for handle the server file system
    * The php commands are accessed from the web browser by a http post
    */
   /*** Includes ***/
   include_once $_SERVER['DOCUMENT_ROOT'].'/controlpanel/Cursos/php/LoggerMgr/LoggerMgr.php';
   /*** Consts and global variables definition ***/
   $PARAM_COMMAND = "command";
   $PARAM_PARAMETERS = "parameters";
   $COMMAND_CREATE_DIR = "mkdir";
   $COMMAND_DELETE = "rm";
   $PARAM_ROOT_DIRECTORY = "root_dir";
   $PARAM_NEW_DIRECTORY = "new_dir";
   $PARAM_ELEMENT_TO_REMOVE = "element_name";
   
   $RESULT_RETURN = "result";
   $MESSAGE_RETURN = "message_return";
   
   
   /**
    * Function that gets the last error occurred
    * 
    * @return A string with the error
    * 
    */
   function getLastError(){
      global $loggerM;
      $loggerM->trace("Enter");
      $loggerM->trace("Exit");
      return trim(substr(error_get_last()['message'],
                  strpos(error_get_last()['message'],":") + 1 ,
            (strlen(error_get_last()['message']))-strpos(error_get_last()['message'],":")));
      
   }
   
   
   /**
    * Function creates a directory
    * 
    * @param theParams: Parameters necessary for create the directory
    *                   This parameters are: newDirectory
    * @param result: [in|out]: Parameter where is saved the result of the
    *                creation of the directory
    */
   function createDirectory($theParameters, &$theResult){
      
      global $loggerM;
      global $RESULT_RETURN;
      global $MESSAGE_RETURN;
      global $PARAM_NEW_DIRECTORY;
      
      $loggerM->trace("Enter");
      $jsonParameter = json_decode($theParameters, JSON_UNESCAPED_SLASHES);
      
      $newDirectory = $jsonParameter[$PARAM_NEW_DIRECTORY];
      $loggerM->trace("Creating the directory [ $newDirectory ]");
      if ( ! mkdir($newDirectory)){
         
         $strError = getLastError();
         if (strcmp($strError, "File exists") == 0){
            $strError = "Directory Exists";
         }
         $loggerM->error("The directory [ $newDirectory ] has been not created.".
               " Reason [ $strError ]");
         $theResult[$RESULT_RETURN] = "ERROR";
         $theResult[$MESSAGE_RETURN] = $strError;
         
      }else{
         $loggerM->debug("The directory [ $newDirectory ] has been created successfuly");
      }
      
      $loggerM->trace("Exit");
      
   }
   
   /**
    * Removes a directory and its contained
    * 
    * @param $theDirName: The directory name to be removed
    * 
    * @return A boolean value that indicates the operation result
    */
   function removeDir($theDirName){
      global $loggerM;
      
      $result = true;
      
      $loggerM->trace("Enter");
      $loggerM->trace("Removing directory [ $theDirName ]");
      $elements = scandir($theDirName);
      foreach ($elements as $element){
         if (strcmp($element, ".") != 0 && strcmp($element, "..") != 0){
            
            if (is_dir($theDirName.'/'.$element)){
               $loggerM->trace("It is a directory");
               if ( !removeDir($theDirName.'/'.$element)){
                  $loggerM->debug("The directory [ $theDirName.'/'.$element ] can not be removed");
                  $result = false;
                  break;
               }
            }else{
               $loggerM->trace("it is a file");
               if ( ! unlink( $theDirName.'/'.$element) ){
                  $loggerM->error("The file [ $theDirName.'/'.$element ] can not be removed");
                  $result = false;
                  break;
               }
            }
         }
      }
      if ($result){
         if ( ! rmdir($theDirName)){
            $loggerM->error("The directory [ $theDirName ] can not be removed");
            $result = false;
         }
      }
      if ($result){
         $loggerM->trace("Directory removed");
      }
      $loggerM->trace("Exit");
      return $result;
   }
   
   /**
    * Removes a file or a directory in the file system.
    * 
    *  @param theParams: Parameters necessary for remove the directory or the file
    *                   This parameters are: theElementName
    * @param result: [in|out]: Parameter where is saved the result of the
    *                remove operation
    */
   function remove($theParams, &$theResult){
      
      global $loggerM;
      global $RESULT_RETURN;
      global $MESSAGE_RETURN;
      global $PARAM_ELEMENT_TO_REMOVE;
      
      $loggerM->trace("Enter");
      
      $jsonParameter = json_decode($theParams, JSON_UNESCAPED_SLASHES);
      $elementName = $jsonParameter[$PARAM_ELEMENT_TO_REMOVE];
      
      $loggerM->trace("Trying remove [ $elementName ]");
            
      if (is_dir($elementName)) {
         $loggerM->trace("It is a directory");
         if ( ! removeDir($elementName)){
            $theResult[$RESULT_RETURN] = "ERROR";
            $theResult[$MESSAGE_RETURN] = getLastError();
            $loggerM->error("The directory wasn't removed. Error [ ".
                   $theResult[$MESSAGE_RETURN]. " ]");
            
         }
      }else{
         $loggerM->trace("It is a file");
         if (! unlink($elementName)){
            $theResult[$RESULT_RETURN] = "ERROR";
            $theResult[$MESSAGE_RETURN] = getLastError();
            $loggerM->error("The file wasn't removed. Error [ ".
                  $theResult[$MESSAGE_RETURN]. " ]");
            
         }
      }
      
      $loggerM->trace("Exit");
   }
    
   
   /***  MAIN ***/
   $loggerM = LoggerMgr::Instance()->getLogger("FileSystem.php");
   $command = $_POST[$PARAM_COMMAND];
   $params = $_POST[$PARAM_PARAMETERS];
   $loggerM->trace("The command received is [ $command ]");
   $result = array();
   $result[$RESULT_RETURN] = "OK";
   switch ($command){
      case $COMMAND_CREATE_DIR:
         $loggerM->trace("A directory will be created");
         createDirectory($params, $result);
         break;
      case $COMMAND_DELETE:
         $loggerM->trace("An element will be removed");
         remove($params, $result);
         break;
      default:
         $loggerM->error("The command received is unkown");
         $result[$RESULT_RETURN] = "ERROR";
         $result[$MESSAGE_RETURN] = "Unkown command";
   }
   
   $loggerM->trace("The result is [ ".json_encode($result) ." ]");
   print(json_encode($result));
?>