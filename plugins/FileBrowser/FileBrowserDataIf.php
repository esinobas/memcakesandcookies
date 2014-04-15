<?php

/**
 * Interface that defines the common methods for get the files information
 */

interface FileBrowserDataIf {
   
   /**
    * Method that get the full path files
    * 
    * @return A JSON object with files information
    */
   public function getFiles(); 
}
?>