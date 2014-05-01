<?php

/**
 * Abstract class that defines the common methods for get the files information
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');

abstract class FileBrowserDataIf {
   
   /**
    * 
    * @var $returnValueM array where the full path file is saved
    */
   protected $returnValueM = array();
   
   /**
    * 
    * @var paramsM. Variable where the params to the search are saved in the
    * constructor of the childs class.
    */
   protected $paramsM;
   
   /**
    * @var loggerM pointer to the logger
    */
   private $loggerM;
   
   
   /**********************************************************************/
   // Methods
   
   /**
    * Constructor
    */
   public function __construct(){
      
      Logger::configure($_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
      $this->loggerM = Logger::getLogger(__CLASS__);
      $this->loggerM->trace("Enter");
      $this->loggerM->trace("Exit");
   }
   /**
    * Method that orders a list of files by their timestamp
    * 
    * @param string $theDirectory Root directory where the files are stored
    * @param array $theFiles. Files list
    * @param string $theSortType Order type. Possible values (ascending, descending)
    * @return An array with the files ordered by timestamp
    */
   protected function orderFilesByTimestamp($theDirectory, $theFiles, $theSortType = 'ascending'){
      
      $this->loggerM->trace("Enter");
      $this->loggerM->trace("Root directory [ " .$theDirectory ." ]. Order type [ " .
                       $theSortType . " ]");
      
      $arrayAux = array();
      $idx = 0;
   
      foreach($theFiles as $file){
         $fileTimestamp = filemtime($theDirectory.'/'.$file);
         $arrayAux[$idx] = array("file" => $file,
                             "timestamp" => $fileTimestamp);
       
         $idx ++;   
      }
   
  
      usort($arrayAux, create_function('$fileA, $fileB', 
         'if($fileA["timestamp"] === $fileB["timestamp"]){
             return 0;
         }
         return ($fileA["timestamp"] < $fileB["timestamp"]) ? -1 : 1;'));
   
      if (strtolower($theSortType) == 'descending'){
         krsort($arrayAux);   
      }
   
      $returnArray = array();
      $idx = 0;
      foreach($arrayAux as $orderedFile){
         $returnArray[$idx] = $orderedFile["file"];
         $idx ++;   
      }
      $this->loggerM->trace("Exit");
      return $returnArray;
   

}
   /**
    * Method that retuns the files in a JSON
    * 
    * @return A JSON object with the files
    */
   public function getFiles(){
      $this->loggerM->trace("Enter");
     
      $this->searchFiles();
      $this->loggerM->trace("Exit");
      return json_encode($this->returnValueM);
      
   }
   
   /**
    * Abstract method that will be write in its childs class.
    * This method searchs the files and it saves their in a local array.
    */
   protected abstract function searchFiles();
   
   /**
    * Abstract method that will be over written in its childs class.
    * This method removes the file on the server
    * 
    * @param theFile Full path and file name of the file that is removed
    * 
    * @return a boolean value that indicates the result of the operation:
    *    true when the removed file has been done successfuly
    *    false when the file has not can be removed
    */
   public abstract function removeFile($theFile); 
}
?>