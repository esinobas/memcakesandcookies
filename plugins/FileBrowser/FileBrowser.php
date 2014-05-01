<?php
   /**
    * File that contains the commmands to get the files from the server
    */

   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
   include_once ($_SERVER['DOCUMENT_ROOT'].'/plugins/FileBrowser/FileBrowserDataIf.php');
   include_once ($_SERVER['DOCUMENT_ROOT'].'/plugins/FileBrowser/FileBrowserFactory.php');

   Logger::configure($_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
   $logger = Logger::getLogger('FileBrowser');
   
   
   const paramsC = "params";
   const typeC = "type";
   
   $params = $_POST[paramsC];
   $type ="Directory";
   if (isset($_POST[typeC])){
      
      $type = $_POST[typeC];
   }
   
  
   $logger->trace("Parameters received in post: ".paramsC." [ ".$params. " ]");
   
   
   $logger->trace("The type of the file browser is [ " .$type ." ]");
   $fileBrowserDataIf = FileBrowserFactory::getFileBrowserData($type, $params);
   //echo '/php/log4php/Logger.php';
   echo $fileBrowserDataIf->getFiles();
   
?>