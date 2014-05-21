<?php

include_once ('FileBrowserDataIf.php');
include_once($_SERVER['DOCUMENT_ROOT']."/php/localDB/TB_IMAGE_COLLECTION.php");
include_once ($_SERVER['DOCUMENT_ROOT']."/php/ddbb/DBIterator.php");
include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
/**
 * Class that searchs the files in a directory in the server and in a database.
 * The files selected are those that are not in the database and are in the 
 * directory
 * This class extends from FileBrowserDataIf
 */

   class FileBrowserDatabase extends FileBrowserDataIf{
      
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
       * 
       * @var customParamsC is a constant to access to the custom paramaters
       */
      const customParamsC = "custom_params";
      /**
       * 
       * @var paramCollectionC is a constant with the key for search a vlaue in 
       * JSON params
       */
      const paramCollectionC = "collection";
       
      /**
       * Constructor of the class
       *
       * @param JSON object $theParams. Params to be used in the search of the
       * files.
       */
      public function __construct($theParams){
      
         //Logger::configure($_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
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
         
         $jsonParams = json_decode($this->paramsM,true);
         $path = $jsonParams[FileBrowserDatabase::paramPathC];
         $filter = $jsonParams[FileBrowserDatabase::paramFilterC];
         $customParams = $jsonParams[FileBrowserDatabase::customParamsC];
         
         $collection = $customParams[FileBrowserDatabase::paramCollectionC];
         
         $this->loggerM->trace("Get the files that belong to the collection [ " .
               $collection ." ]");
         
         $filesInDatabase = TB_IMAGE_COLLECTION::getImageFromCollection($collection);
         
         $this->loggerM->trace("Get files from path [ " . $path ." ]");
         
         $fileBrowserDirectory = new FileBrowserDataDirectory($this->paramsM);
         $filesInDirectory = json_decode($fileBrowserDirectory->getFiles());
         
         $this->loggerM->debug("In the collection [ " . $collection . " ] has [ " . 
                        $filesInDatabase->getNumRows() . " ] images and in the directory there are [ " .
                      count($filesInDirectory) . " ]");
         
         $idx = 0;
         for ($idxFiles = 0; $idxFiles < count($filesInDirectory); $idxFiles++){
             
             $this->loggerM->trace("Search file [ " . $filesInDirectory[$idxFiles] .
                   " ] in collection files");
             $exit = false;
             $filesInDatabase->reset();
             while ($filesInDatabase->next() && ! $exit){
                
                $file = $filesInDatabase->getRow()->getImagePath()."/".
                   $filesInDatabase->getRow()->getImageName();
                
                if (strcmp($filesInDirectory[$idxFiles] ,$file) == 0){
                   $this->loggerM->trace("The file [ " .
                          $filesInDirectory[$idxFiles] . " ] is in the collection, skip it");
                   $exit = true;
                }
                
             }
             if (!$exit){
                $this->returnValueM[$idx] = $filesInDirectory[$idxFiles];
                $idx ++;
             }
         }
         
         $this->loggerM->debug("[ " . count($this->returnValueM) . " ] images will be returned");
         $this->loggerM->trace("Exit");
      }
      /**
       * (non-PHPdoc)
       * @see FileBrowserDataIf::removeFile()
       */
      public function removeFile($theFile){
         $this->loggerM->trace("Enter");
         $this->loggerM->trace("Exit");
      }
   }
?>