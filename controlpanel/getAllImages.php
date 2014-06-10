<?php

/**
 * File used for get all cakes from data base through AJAX.
 */
 
 require_once(dirname(__FILE__).'/ControlPanelQueries.php');
 require_once($_SERVER['DOCUMENT_ROOT'].'/php/ddbb/DBIterator.php');
 require_once($_SERVER['DOCUMENT_ROOT'].'/php/localConfiguration/configuration.php');
 require_once($_SERVER['DOCUMENT_ROOT'].'/php/image/ImageLibrary.php');
 include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
 
 Logger::configure($_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
 $logger = Logger::getLogger("getAllImages");
 
 $logger->trace("Enter");
 
 $type = $_GET['typeImage'];
 $collection = $_GET['collection'];
 
 $logger->trace("Image type [ " . $type . " ] and collection [ " . $collection ." ]");
 

 $images = null;
 $arrayImages = array();
 if ($collection == 0){
    
    if ($type == "CAKES"){
  
       $images =  getAllCakes();
    }
    if ($type == "COOKIES"){
 
       $images =  getAllCookies();
    }
    if ($type == "MODELADOS"){
       
       $images = getAllModels();
    }
    
    $idx = 0;
    $logger->trace("Number of images: [ ". $images->getNumRows() . " ]");
    while($images->next()){
       
       
       $path = createThumbnail($_SERVER['DOCUMENT_ROOT'].'/'.$images->getRow()->getPath(), //Path  
                                 $images->getRow()->getNameFile(), //FileName
                                 150, //thumbnail width in pixels
                                 112,//thumbnail height in pixels
                                 $images->getRow()->getPath().thumbnailsPath,
                                 "Thumb_", $logger);
       $len = strlen($_SERVER['DOCUMENT_ROOT'].'/');
       $path = substr($path, $len);
       $logger->trace("Thumbnail [ $path ]");
       
       //$path = $images->getRow()->getPath().'/'.$images->getRow()->getNameFile();
       $desc = $images->getRow()->getDescription();
       $id = $images->getRow()->getId();
       $image = array();
       $image['id'] = $id;
       $image['path'] = $path;
       $image['description'] = $desc;
       $arrayImages[$idx] = $image;
       $idx ++;
    }

 }else{
    $images = getCollectionImages($collection);
    $logger->trace("Number of images: [ ". $images->getNumRows() . " ]");
    $idx = 0;
    while($images->next()){
       //$path = $images->getRow()->getImagePath().'/'.$images->getRow()->getImageName();
       $path = createThumbnail($_SERVER['DOCUMENT_ROOT'].'/'.$images->getRow()->getImagePath(), //Path
             $images->getRow()->getImageName(), //FileName
             150, //thumbnail width in pixels
             112,//thumbnail height in pixels
             $images->getRow()->getImagePath().thumbnailsPath,
             "Thumb_", $logger);
       $len = strlen($_SERVER['DOCUMENT_ROOT'].'/');
       $path = substr($path, $len);
       $logger->trace("Thumbnail [ $path ]");
       $desc = $images->getRow()->getDescription();
       $id = $images->getRow()->getImageId();
       $image = array();
       $image['id'] = $id;
       $image['path'] = $path;
       $image['description'] = $desc;
       $arrayImages[$idx] = $image;
       $idx ++;
    }
 }
 
 echo json_encode($arrayImages);
  
?>
