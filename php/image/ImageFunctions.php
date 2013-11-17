<?php 

/**
 * File that contains functions for be used in handle of image
 */

   /**
    * Function that creates thumbnails from images that are within a directory
    *
    * @param theSourceDir: The directory where are the images saved.
    * @param theExtesionsArray: Array where are saved the extensions for filter the image
    * by format.
    * @param theThumbailsDir: The directory where the thumbnails will be saved
    * @param theThumbWidth: The thumbnail width. Default 102
    * @param theThumHeight: The thumbnail height. Default 76
    * @param theThumbPrefix: The thumbnail prefix file name. Default "Thumb_"
    */
   function createThumbnailsFromDirectory($theSourceDir
                                          ,$theExtesionsArray 
                                          ,$theThumbnailsDir
                                          ,$theThumbWidth = 102
                                          ,$theThumHeight = 76
                                          ,$theThumbPrefix = ''){
                                       
       
     
      include_once($_SERVER['DOCUMENT_ROOT'].'/php/tools/directoryFunctions.php');
      include_once('ImageGDFactory.php');
      
      $imagesFiles = getDirectoryFilesFilterExtension($theSourceDir, $theExtesionsArray); 
      $orderedImagesFiles = orderFilesByTimestamp($theSourceDir,$imagesFiles, 'descending');
     
      foreach ($orderedImagesFiles as $imageFile){
         
         $file = $theSourceDir.'/'.$imageFile;
         
         $image = ImageGDFactory::getGDImage ($theSourceDir, $imageFile);
         
         $image->converToThumbnail($theThumbnailsDir
                                   ,$theThumbWidth
                                   ,$theThumHeight
                                   ,$theThumbPrefix);
         
      }
     
   }
   
   function test() {}
   
   

?>