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
   
   $RETURN_RESULT = "result";
   
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
      $loggerM->trace("Enter");
      $jsonParameter = json_decode($theParameters);
      $newDirectory = $jsonParameter[$PARAM_NEW_DIRECTORY];
      $loggerM->trace("Creating the directory [ $newDirectory ]");
      if ( ! mkdir($newDirectory)){
         $logger->error("The directory [ $newDirectory ] has been not created");
         $result[$RETURN_RESULT] = "ERROR";
      }else{
         $logger->debug("The directory [ $newDirectoyr ] has beeb created successfuly");
      }
      
      $loggerM->trace("Exit");
      
   }
   
   /***  MAIN ***/
   $loggerM = LoggerMgr::Instance()->getLogger("FileSystem.php");
   $command = $_POST[$PARAM_COMMAND];
   $params = $_POST[$PARAM_PARAMETERS];
   $logger->trace("The command received is [ $command ]");
   $result = array();
   $result[$RETURN_RESULT] = "OK";
   switch ($command){
      case $COMMAND_CREATE_DIR:
         $logger->trace("A directory will be created");
         createDirectory($params, $result);
         break;
      default:
         $logger->error("The command received is unkown");
         $result[$RETURN_RESULT] = "ERROR";
   }
   
   print(json_encode($result));
?>