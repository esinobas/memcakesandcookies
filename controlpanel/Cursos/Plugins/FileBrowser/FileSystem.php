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
   $COMMAND_DELETE_DIR = "rmdir";
   $PARAM_ROOT_DIRECTORY = "root_dir";
   $PARAM_NEW_DIRECTORY = "new_dir";
   
   $RESULT_RETURN = "result";
   $MESSAGE_RETURN = "message_return";
   
   /**
    * Function creates a directory
    * 
    * @param theParams: Parameters necessary for create the directory
    *                   This parameters are: directory, newDirectory
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
         
         $strError = substr(error_get_last()['message'], 
               strpos(error_get_last()['message'],":") + 1 , 
               (strlen(error_get_last()['message']))-strpos(error_get_last()['message'],":"));
         $loggerM->error("The directory [ $newDirectory ] has been not created.".
               " Reason [ $strError ]");
         $theResult[$RESULT_RETURN] = "ERROR";
         $theResult[$MESSAGE_RETURN] = $strError;
         
      }else{
         $loggerM->debug("The directory [ $newDirectory ] has been created successfuly");
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
      default:
         $loggerM->error("The command received is unkown");
         $result[$RESULT_RETURN] = "ERROR";
         $result[$MESSAGE_RETURN] = "Unkown command";
   }
   
   $loggerM->trace("The result is [ ".json_encode($result) ." ]");
   print(json_encode($result));
?>