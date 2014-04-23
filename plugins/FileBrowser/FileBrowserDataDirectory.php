<?php
include_once ('FileBrowserDataIf.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
/**
 * Class that searchs the files in a directory in the server
 * This class extends from FileBrowserDataIf
 * 
 * @author tebi
 *
 */
class FileBrowserDataDirectory extends FileBrowserDataIf{
   
   /**
    * 
    * @var Logger. Object that permits write traces in a file for debugging
    */
   private $loggerM;
   
   /**
    * 
    * @var paramPathC is a constant with the key for search a value in JSON
    * params
    */
   const paramPathC = "path";
   
   /**
    *
    * @var paramFilterC is a constant with the key for search a value in JSON
    * params
    */
   const paramFilterC = "filter";
   
   /**
    * Constructor of the class
    *  
    * @param JSON object $theParams. Params to be used in the search of the 
    * files.
    */
   public function __construct($theParams){
      
      Logger::configure($_SERVER['DOCUMENT_ROOT'].'/plugins/FileBrowser/LogConfig.xml');
      $this->loggerM = Logger::getLogger(__CLASS__);
      $this->loggerM->trace("Enter");
      parent::__construct();
      $this->paramsM = $theParams;
      $this->loggerM->trace("Params [ " . $this->paramsM . " ]");
      $this->loggerM->trace("Exit");
   }
   
   /**
    * (non-PHPdoc)
    * @see FileBrowserDataIf::searchFiles()
    */
   protected function searchFiles(){
      $this->loggerM->trace("Enter");
      
      $this->loggerM->trace("Decode params [ ".$this->paramsM. "]");
      $jsonParams = json_decode($this->paramsM,true);
      
      $thePath = $jsonParams[FileBrowserDataDirectory::paramPathC];
      $theFilter =$jsonParams[FileBrowserDataDirectory::paramFilterC];
      
      $this->loggerM->trace("Path [ " .$thePath." ] and filter [ " .$theFilter. " ]");
      
      //$this->loggerM->trace(var_dump($this->paramsM));
      $directory = $_SERVER['DOCUMENT_ROOT'].'/'.$thePath;
      $dirContent = scandir($directory);
      
       
      
      if ( $dirContent == FALSE ){
         $this->loggerM->warn("El directorio [ " . $directory . " ] no existe");
         return ("El directorio [ " . $directory . " ] no existe");
      }
       
      $arrayExtensions = explode(",", strtolower($theFilter));
      $this->loggerM->trace("Get all files that are within the directory [ " .
                                         $thePath . " ]");
      $idxArray = 0;
      for( $idx = 0; $idx < count($dirContent); $idx++){
          
         if (is_file($directory.'/'.$dirContent[$idx])){
            $fileName = $thePath.'/'. $dirContent[$idx];
             
            $theFileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
             
            if (in_array(strtolower($theFileExtension), $arrayExtensions)){
               $this->loggerM->trace("Add file to array [ " . $fileName . " ]");
               $this->returnValueM[$idxArray] = $fileName;
               $idxArray ++;
            }
         }
      }
      
      $this->loggerM->trace("The files has been getted. Now the files will be ordered");
      
      $this->returnValueM = $this->orderFilesByTimestamp( $_SERVER['DOCUMENT_ROOT'],
                                        $this->returnValueM, 'descending');
       
      
      $this->loggerM->trace("Exit");
   }
   

   public function removeFile($theFile){
      $this->loggerM->trace("Enter");
      $this->loggerM->trace("The file [ " . $theFile . " ] will be removed");
      $result = unlink($_SERVER['DOCUMENT_ROOT'].'/'.$theFile);
      if ( $result ){
         $this->loggerM->trace("The file [ " . $theFile . " ] was removed sucessfully");
      }else{
         $this->loggerM->warn("The file [ " . $theFile . " ] has not been removed.");
      }
      
      $this->loggerM->trace("Exit");
      return $result;
   }
}
?>