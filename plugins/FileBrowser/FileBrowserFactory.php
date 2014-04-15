<?php

/**
 * Class that creates a FileBrowserIf object (class) and it returns them.
 */

include_once ('FileBrowserDataIf.php');
//include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
include_once ('/home/tebi/Datos/webserver/MEMcakesandcookies/www/php/log4php/Logger.php');

class FileBrowserFactory{
   
   /**
    * Static method that cretates the FileBrowserIf depending of the parameter
    * 
    * @param theType of the interface that will be created
    * @param theParameters is a JSON object with the parameters used by the
    * object to get the files
    * 
    * @return A FileBrowser object
    */
   public static function getFileBrowserData($theType, $theParameters = NULL){
      
      
       Logger::configure('LogConfig.xml');
       $logger = Logger::getLogger(__CLASS__);
       $logger->trace("ENTER");
       $logger->trace("EXIT");
      
   }
}
?>