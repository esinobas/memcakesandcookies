<?php
   require_once($_SERVER['DOCUMENT_ROOT']."/php/localDB/TableImage.php");   
   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
   
   Logger::configure($_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
   $logger = Logger::getLogger("UpdateTableImage");
   $logger->trace("Enter");
   $id = $_POST['id']; 
   $desc = $_POST['desc'];
   $descUpdated = true;
   $logger->debug("Update description to [" . $desc ." ] for image id [ " . $id ." ]");
   $descUpdated = true;
   
   if (TableImage::updateDescription($id, $desc) == 0){
      $logger->trace("The Description was updated successfully");
   }else{
      $logger->error("The description was not updated");
      $descUpdated = false;
   }
   echo ($descUpdated?"true":"false");
   $logger->trace("Exit");
?>