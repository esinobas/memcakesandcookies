<?php
   /**
    * File that contains the commmands to get the files from the server
    */

   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
   include_once ($_SERVER['DOCUMENT_ROOT'].'/plugins/FileBrowser/FileBrowserDataIf.php');
   include_once ($_SERVER['DOCUMENT_ROOT'].'/plugins/FileBrowser/FileBrowserFactory.php');

   Logger::configure($_SERVER['DOCUMENT_ROOT'].'/plugins/FileBrowser/LogConfig.xml');
   $logger = Logger::getLogger(__FILE__);
   
   
   $path = $_POST["path"];
   $filter = "";
   $params = "";
   $type ="Directory";
   
   $logger->trace("Parameters received in post: path [ ".$path." ]");
   if (isset($_POST["filter"])){
      $filter = $_POST["filter"];
      $logger->trace("Parameters receive in post: filter [ ".$filter. " ]");
   }
   if (isset($_POST["$params"])){
      $params = $_POST["$params"];
      $logger->trace("Parameters receive in post: $params [ ".$params. " ]");
   }
   
   //sacar los parametros. Ha que sacar el type, que por defecto es Directory.
   
   $logger->trace("The type of the file browser is [ " .$type ." ]");
   //Crear el jason con los parametros dependiendo del tipo
   //para el tipo directory, con el path y es suficiente
   //path->....
   $fileBrowserDataIf = FileBrowserFactory::getFileBrowserData($type, $path);
   echo '/php/log4php/Logger.php';
   
?>