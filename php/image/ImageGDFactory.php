<?php
   
   include_once('ImageGDjpg.php');
   
   class ImageGDFactory{
      
      /**
       * Static method that creates a based gd image for create thumbnails
       *
       * @param thePath: The image path
       * @param theFile: The file image
       *
       * @return The corresponding based gd image.
       */
      public static function getGDImage($thePath, $theFile) {
         
         $returnImage;
        
         $arrayImageSize = getimagesize($thePath.'/'.$theFile);
         //get the image type
         $imageType =  $arrayImageSize[2];
         switch($imageType) {
            case 1://gif
                  break;
            case 2://jpg      
                  $returnImage = new ImageGDjpg($thePath, $theFile);
                  break;
            case 3: //png
                  break;
         }   
         return $returnImage;      
      }
   
   }
?>