<?php
   /**
    * File that contains the commmands to get the files from the server
    */

   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
   

   Logger::configure($_SERVER['DOCUMENT_ROOT'].'/plugins/FileBrowser/LogConfig.xml');
   $logger = Logger::getLogger(__FILE__);
   
   $path = $_POST["path"];
   $filter = $_POST["filter"];
   
   $logger->trace("Parameters received in post: path [ ".$path." ] filter [ ". $filter . "]");
   echo '/php/log4php/Logger.php';
?>