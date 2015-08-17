<?php
/**
 * Library that contains functions to handle images
 */

   if ( ! strpos(get_include_path(), dirname(__FILE__))){
      set_include_path( get_include_path() . PATH_SEPARATOR . dirname(__FILE__));
   }    

   $loggerImageLibrary =  LoggerMgr::Instance()->getLogger("ImageLibrary.php");
   $loggerImageLibrary->trace("ImageLibrary.php. Enter");
   
   require_once 'image/ImageGDFactory.php';
   require_once('image/AbstractImageGD.php');
  
   
 /**
  * Function that creates a thumbnail from an image and return the name and path
  * of the thumbnail.
  */
 function createThumbnail($theFilePath
                          ,$theFileName
                          ,$theWitdh
                          ,$theHeight
                          ,$theThumbnailPath = '.'
                          ,$theThumbnailPrefix = 'Thumb_'
                          ,$theLogger = null) {
    
    global $loggerImageLibrary;
    ($loggerImageLibrary != null ? $loggerImageLibrary->trace("Enter"):null);
    ($loggerImageLibrary != null ? $loggerImageLibrary->trace("Create thumbnail with :\n".
                                    "Path [ " . $theFilePath ." ]\n".
                                    "File [ " . $theFileName ." ]\n".
                                    "Width [ " .$theWitdh . " ] px\n".
                                    "Height [ " . $theHeight ." ] px\n".
                                    "Thumbnails Path [ " . $theThumbnailPath . " ]\n".
                                    "Thumbnail prefix [ " . $theThumbnailPrefix . " ]"):null);

    $image = ImageGDFactory::getGDImage($theFilePath,$theFileName, $theLogger);
    
    /*$nameFileThumbnail = $theThumbnailPath.'/'.$theThumbnailPrefix.$theFileName;
    ($theLogger != null ? $theLogger->trace("Name file thumbnail [ " . $nameFileThumbnail ." ]"):null);
    */
    ($loggerImageLibrary != null ? $loggerImageLibrary->trace("Exit"):null);
    
    return $image->converToThumbnail($theThumbnailPath, $theWitdh, $theHeight,$theThumbnailPrefix, true);
           
     
 }
 $loggerImageLibrary->trace("ImageLibrary.php. Exit");
?>
