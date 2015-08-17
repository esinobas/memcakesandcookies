<?php
   
   include_once 'php/LoggerMgr/LoggerMgr.php';
   require_once 'image/ImageGDjpg.php';
   
   class ImageGDFactory{
      
      /**
       * Static method that creates a based gd image for create thumbnails
       *
       * @param thePath: The image path
       * @param theFile: The file image
       *
       * @return The corresponding based gd image.
       */
      public static function getGDImage($thePath, $theFile, $theLogger= null) {
         
         $logger = LoggerMgr::Instance()->getLogger(__CLASS__);
         ($logger != null ? $logger->trace("Enter"):null);
         ($logger != null ? $logger->trace("Path [ " .$thePath ." ]. ".
                                          "The file Name [ " . $theFile ." ]"):null);
         
         $returnImage;
        
         $arrayImageSize = getimagesize($thePath.'/'.$theFile);
         
         //get the image type
         $imageType =  $arrayImageSize[2];
         ($logger != null ? $logger->trace("Image type [ " . $imageType ." ]"):null);
         switch($imageType) {
            case 1://gif
                  break;
            case 2://jpg
               ($logger != null ? $logger->trace("The image is jpg"):null);
                  $returnImage = new ImageGDjpg($thePath, $theFile);
                  break;
            case 3: //png
                  break;
         }   
         ($logger != null ? $logger->trace("Exit"):null);
         return $returnImage;      
      }
   
   }
?>