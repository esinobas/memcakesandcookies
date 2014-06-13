<?php
/**
 * Library that contains functions to handle images
 */
  require_once(dirname(__FILE__).'/ImageGDFactory.php');
  require_once(dirname(__FILE__).'/AbstractImageGD.php');
  
  include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
  
  
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
    
    ($theLogger != null ? $theLogger->trace("Enter"):null);
    ($theLogger != null ? $theLogger->trace("Create thumbnail with :\n".
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
    ($theLogger != null ? $theLogger->trace("Exit"):null);
    
    return $image->converToThumbnail($theThumbnailPath, $theWitdh, $theHeight,$theThumbnailPrefix, true);
           
     
 }

?>
