<?php
   /**
    * This file has the entry and methods necesaries for upload a file
    * from a web page to the server where the file is saved.
    * 
    * The tmp and the target diretories must have write permissions in the server
    */
   
   /*** Includes ***/
   set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'].
                '/controlpanel/Cursos/php');

   include_once 'LoggerMgr/LoggerMgr.php';
   
   /*** Constants definition ***/
   $RESULT_CODE = "ResultCode";
   $MSG_ERROR = "ErrorMsg";
   $RESULT_CODE_SUCCESS = 200;
   $RESULT_CODE_INTERNAL_ERROR = 500;
   $PARAM_FILE_NAME_TO_SEND = "fileNameToSend";
   $PARAM_ERROR = "error";
   $PARAM_TMP_DIR = "tmp_name";
   $PARAM_FILE_NAME = "name";
   $PARAM_PATH = "path";
   
   /*** Global variables definition ***/
   
   /**
    * Object that writes a log in a file
    */
   $logger = LoggerMgr::Instance()->getLogger("FileBrowser-UploadFile.php");
   
   /**
    * Array where the result is saved for be sent to the client
    */
   $resultArray = array();
   
   /*** Private functions ***/
   
   /**
    * Function that maps the code error with its corresponding text
    * @param integer $theErrorCode The code error
    * @return string The error text.
    */
   function getTextError($theErrorCode){
      global $logger;
      $logger->trace("Enter");
      $textError = "";
      switch ($theErrorCode){
         case UPLOAD_ERR_INI_SIZE://1
            $textError = "El archivo excede la directiva \"upload_max_filesize\" en php.ini.";
            break;
         case UPLOAD_ERR_FORM_SIZE: //2
            $textError = "El archivo excede la directiva \"MAX_FILE_SIZE\" especificada en el formulario.";
            break;
         case UPLOAD_ERR_PARTIAL: //3
            $textError = "El archivo fue sólo parcialmente cargado.";
            break;
         case UPLOAD_ERR_NO_FILE: //4
            $textError = "Ningún archivo fue subido.";
            break;
         case UPLOAD_ERR_NO_TMP_DIR: //5
            $textError = "No existe la carpeta temporal.";
            break;
         case UPLOAD_ERR_CANT_WRITE: //6
            $textError = "No se pudo escribir el archivo en el disco";
            break;
         case UPLOAD_ERR_EXTENSION: //8
            $textError = "Error desconocido. Una extensión de PHP detuvo la carga de archivos.";
            break;
      }
      $logger->trace("Exit");
      return $textError;
   }
    
   
   /*** Main ***/
   
   $logger->trace("Enter");
   if ($_FILES[$PARAM_FILE_NAME_TO_SEND][$PARAM_ERROR] == UPLOAD_ERR_OK){
      //Check if in the param "path", the root document is present.
      
      $pattern = json_encode($_SERVER['DOCUMENT_ROOT']);
      preg_match($pattern,
                  $_POST[$PARAM_PATH],
                  $arrayMatches);
      $logger->trace("Matches [ {$arrayMatches[0]} ]");
      $dir_destin = "";
      if (strlen($arrayMatches[0]) > 0 ){
         //The root path is present in the path
         $logger->trace("The root path is present in the path");
         $dir_destin = $_POST[$PARAM_PATH].'/';
      }else{
         $logger->trace("The root path is NOT present in the path");
         $dir_destin = $_SERVER['DOCUMENT_ROOT'].'/'.$_POST[$PARAM_PATH].'/';
      }
      $logger->trace("XXX. Directory destin: $dir_destin");
     
      $logger->trace("Trying move [ " . 
            $_FILES[$PARAM_FILE_NAME_TO_SEND][$PARAM_FILE_NAME] . " ] from [ ".
            $_FILES[$PARAM_FILE_NAME_TO_SEND][$PARAM_TMP_DIR] ." ] to [ " . 
            $dir_destin . " ]");
      if (! move_uploaded_file($_FILES[$PARAM_FILE_NAME_TO_SEND][$PARAM_TMP_DIR],
             $dir_destin.$_FILES[$PARAM_FILE_NAME_TO_SEND][$PARAM_FILE_NAME])){
         /*$returnValue = array();
         $returnValue["Error"] = "Se ha producido un error";
         $returnValue["tmp_name"] =  $_FILES["fileNameToSend"]["tmp_name"];
         $returnValue["dir_destin"] = $dir_destin;
         $returnValue["file_name"] = $dir_destin.$_FILES["fileNameToSend"]["name"];
         echo json_encode($returnValue);*/
         $errorMsg = "The file [ " . $_FILES["fileNameToSend"]["name"] .
                    " ] has not been uploaded to [ $dir_destin ]";
         $resultArray[$RESULT_CODE] = $RESULT_CODE_INTERNAL_ERROR;
         $resultArray[$MSG_ERROR] = $errorMsg;
         $logger->error($errorMsg);
      }else{
         $logger->debug("The file [ " .
               $_FILES[$PARAM_FILE_NAME_TO_SEND][$PARAM_FILE_NAME] . 
               " ] has been uploaded successfull");
         $resultArray[$RESULT_CODE] = $RESULT_CODE_SUCCESS;
         $resultArray[$PARAM_FILE_NAME] = $_FILES[$PARAM_FILE_NAME_TO_SEND][$PARAM_FILE_NAME];
      }
   }else{
      $errorMsg = getTextError($_FILES[$PARAM_FILE_NAME_TO_SEND][$PARAM_ERROR]);
      $logger->error("An error has been produced uploaded file [ " .
            $_FILES[$PARAM_FILE_NAME_TO_SEND][$PARAM_FILE_NAME] . " ]. Error msg [ $errorMsg ]");
      $resultArray[$RESULT_CODE] =  $RESULT_CODE_INTERNAL_ERROR;
      $resultArray[$MSG_ERROR] = $errorMsg;
   }
   $logger->trace("Result [ ". json_encode($resultArray) ." ]");
   print(json_encode($resultArray));
   $logger->trace("Exit");
 
?>