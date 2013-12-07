<?php

/**
 * File used for get all cakes from data base through AJAX.
 */
 
 require_once(dirname(__FILE__).'/CakesQueries.php');
 require_once($_SERVER['DOCUMENT_ROOT'].'/php/ddbb/DBIterator.php');
 
 $type = $_GET['typeImage'];
 

 
 $images = null;
 if ($type == "CAKES"){
  
    $images =  getAllCakes();  
 }
 
 $arrayImages = array();
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
 echo json_encode($arrayImages);
  
?>
