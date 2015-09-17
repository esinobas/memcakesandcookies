<?php

/**
 * File with the necesary functions for scan a directory and return the files
 * and directories those are under the root directory.
 * The root directoy is passed like a paramter
 */

/***** includes *****/
   include_once $_SERVER['DOCUMENT_ROOT'].'/controlpanel/Cursos/php/LoggerMgr/LoggerMgr.php';

/****** Declaration of the global variables ****/
   
   $rootDirectoryParamC = "rootDirectory";
   $typeParamC = "type";
   $filterParamC = "filter";

   $loggerM = LoggerMgr::Instance()->getLogger("Filebrowser.php");
   
/***** Functions **********/
   
   /**
    * Get the files and directories those are under the directory
    * @param string $theDirectory
    * @param string $theType
    */
   function getFilesAndDirectories($theDirectory, $theType){
      
      global $loggerM;
      $loggerM->trace("Enter");
      $loggerM->debug("Getting the files & directories under [ $theDirectory ] with type [ $theType ]");
      $localFilesAndDirectories = scandir($theDirectory);
      $returnData = array();
      if ($localFilesAndDirectories != false){
         foreach ($localFilesAndDirectories as $candidate){
            if (preg_match('/^\./', $candidate) == 0 ){
               if (is_dir($theDirectory.'/'.$candidate)){ 
                  if((strcasecmp($theType, "A") == 0 || 
                                (strcasecmp($theType, "D") == 0))){
                     $loggerM->trace("Directory [ $candidate ]");
                     if (strcmp($candidate, ".") != 0 && strcmp($candidate, "..") != 0){
                        $returnData[$candidate] = getFilesAndDirectories($theDirectory.'/'.$candidate, $theType);
                     }
                  }
               }else{
                  if (strcasecmp($theType, "A") == 0 || 
                                (strcasecmp($theType, "F") == 0)){
                     $loggerM->trace("File [ $candidate ]");
                     $returnData[$candidate] = NULL;
                  }
               }
            }
         }
      }
      $loggerM->trace("Exit");
      return $returnData;
      
   }

   /******** MAIN ************/
   $loggerM->trace("Enter");
   
   $rootDirectory = $_POST[$rootDirectoryParamC];
   $type = $_POST[$typeParamC];
   $filter = $_POST[$filterParamC];
   
   $loggerM->debug("The root directory is [ $rootDirectory ]. The type [ $type ] and the filter [ $filter ]");
   $returnFilesAndDirectories = getFilesAndDirectories($rootDirectory, $type);
   $loggerM->trace("Return JSON data [ " .json_encode($returnFilesAndDirectories) . " ]" );
   $loggerM->trace("Exit");
   print(json_encode($returnFilesAndDirectories));
   
?>
