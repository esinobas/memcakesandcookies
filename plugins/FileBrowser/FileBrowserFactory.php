<?php

/**
 * Class that creates a FileBrowserIf object (class) and it returns them.
 */

   include_once ('FileBrowserDataIf.php');
   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');


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
      
      
       Logger::configure($_SERVER['DOCUMENT_ROOT'].'/plugins/FileBrowser/LogConfig.xml');
       $logger = Logger::getLogger(__CLASS__);
       $logger->trace("ENTER");
       
       $logger->trace("Type of FileBrowser to be created [ " .$theType. " ]".
                             " with this parameters [ " .$theParameters . " ]" );
       
       $logger->trace("EXIT");
      
   }
}
?>