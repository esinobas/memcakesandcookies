<?php
   
   include_once('ImageGDjpg.php');
   
   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
   
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
         
         ($theLogger != null ? $theLogger->trace("Enter"):null);
         ($theLogger != null ? $theLogger->trace("Path [ " .$thePath ." ]. ".
                                          "The file Name [ " . $theFile ." ]"):null);
         
         $returnImage;
        
         $arrayImageSize = getimagesize($thePath.'/'.$theFile);
         
         //get the image type
         $imageType =  $arrayImageSize[2];
         ($theLogger != null ? $theLogger->trace("Image type [ " . $imageType ." ]"):null);
         switch($imageType) {
            case 1://gif
                  break;
            case 2://jpg
               ($theLogger != null ? $theLogger->trace("The image is jpg"):null);
                  $returnImage = new ImageGDjpg($thePath, $theFile);
                  break;
            case 3: //png
                  break;
         }   
         ($theLogger != null ? $theLogger->trace("Exit"):null);
         return $returnImage;      
      }
   
   }
?>