<?php
/**
 * Library that contains functions to handle images
 */
  require_once(dirname(__FILE__).'/ImageGDFactory.php');
  require_once(dirname(__FILE__).'/AbstractImageGD.php');
  
 /**
  * Function that creates a thumbnail from an image and return the name and path
  * of the thumbnail.
  */
 function createThumbnail($theFilePath
                          ,$theFileName
                          ,$theWitdh
                          ,$theHeight
                          ,$theThumbnailPath = '.'
                          ,$theThumbnailPrefix = 'Thumb_') {

    $image = ImageGDFactory::getGDImage($theFilePath,$theFileName);
    
    $nameFileThumbnail = $theThumbnailPath.'/'.$theThumbnailPrefix.$theFileName;
    
    return $image->converToThumbnail($theThumbnailPath, $theWitdh, $theHeight,$theThumbnailPrefix, true);
           
    //return $nameFileThumbnail; 
 }

?>
