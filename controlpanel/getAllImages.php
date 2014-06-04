<?php

/**
 * File used for get all cakes from data base through AJAX.
 */
 
 require_once(dirname(__FILE__).'/ControlPanelQueries.php');
 require_once($_SERVER['DOCUMENT_ROOT'].'/php/ddbb/DBIterator.php');
 
 $type = $_GET['typeImage'];
 $collection = $_GET['collection'];
 

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
    while($images->next()){
       $path = $images->getRow()->getPath().'/'.$images->getRow()->getNameFile();
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
    
    $idx = 0;
    while($images->next()){
       $path = $images->getRow()->getImagePath().'/'.$images->getRow()->getImageName();
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
