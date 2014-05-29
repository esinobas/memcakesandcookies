<?php

   define('logConfigurationC', $_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');

   require_once($_SERVER['DOCUMENT_ROOT']."/php/localDB/TableImage.php");
   require_once($_SERVER['DOCUMENT_ROOT']."/php/localDB/TB_IMAGE_COLLECTION.php");
   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
   
   Logger::configure(logConfigurationC);
   $logger = Logger::getLogger("DeleteImage");
   
   $logger->trace("Enter");
   $id = $_POST['id']; 
   $collectionId = $_POST['idCollection'];
   
   $logger->trace("The image id is [ ". $id 
                ." ] and the collection id is [ " . $collectionId . " ]");
   
   //if the collection id is 0, then delete the images of the all collections
   // which belongs to the image
   $imageDeleted = true;
   if ($collectionId != 0 ){
      $logger->trace("Delete relationship image-collection");
      if( TB_IMAGE_COLLECTION::delete($id, $collectionId) == 0){
         
         $logger->debug("The relation image-collection was deleted successfully");
      }else{
         $logger->error("The relation image - collection can not be delete");
         $imageDeleted = false;
      }
      
      
   }else{
      $logger->trace("Delete the image and its relations with the collections");
   }

   /*
   $image = TableImage::selectImageById($id);
   
   if (TableImage::delete($id) == 0){
       $path = sprintf("../%s/%s",  $image->getPath(),$image->getNameFile());
       unlink($path);
       $path = sprintf("../%s/thumbnails/*.*",  $image->getPath());
       array_map("unlink",glob($path));   
   }
   */
   
   echo ($imageDeleted?"true":"false");
   
   $logger->trace("Exit");
   

?>
