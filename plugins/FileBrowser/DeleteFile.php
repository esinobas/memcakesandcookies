<?php
   /**
    * File that contains the commands for remove files in the server
    */

   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
   include_once ($_SERVER['DOCUMENT_ROOT'].'/plugins/FileBrowser/FileBrowserDataIf.php');
   include_once ($_SERVER['DOCUMENT_ROOT'].'/plugins/FileBrowser/FileBrowserFactory.php');

   Logger::configure($_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
   $logger = Logger::getLogger('DeleteFile');
 
   const typeC = "type";
   const fileC = "file";

   $type ="Directory";
   $file = "";
   
   if (isset($_POST[typeC])){

      $type = $_POST[typeC];
   }
   if (isset($_POST[fileC])){
      
      $file = $_POST[fileC];
   }else{
      $logger->warn("In the http post absence the file");
      $logger->trace("Exit with ERROR");
      echo "ERROR";
      return;
   }
  
 
   $logger->debug("The type of the file browser is [ " .$type ." ]");
   $logger->debug("The file is [ ". $file . " ]");
   
   $fileBrowserDataIf = FileBrowserFactory::getFileBrowserData($type);
   
   if ($fileBrowserDataIf->removeFile($file)){
      
      $logger->debug("The file [ " . $file . " ] was removed successfully");
      echo "OK";
      return;
   }else{
      $logger->warn("The file [ " . $file . " ] was not removed");
      echo "ERROR";
      return;
   }
?>