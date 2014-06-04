<?php

/**
 * File that contains the queries for search the cakes in the database and
 * show them.
 */
 
require_once($_SERVER['DOCUMENT_ROOT'].'/php/ddbb/DBIterator.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_CAKES.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_COOKIES.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_IMAGE_COLLECTION.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_MODELING.php');


function getAllCakes(){

   return TB_CAKES::getAll();
}
function getAllCookies(){
    
    return TB_COOKIES::getAll();
}
function getAllModels (){
   
   return TB_MODELING::getAll();
}
function getCollectionImages($theCollectionId){
   
   return TB_IMAGE_COLLECTION::getImagesfromCollectionID($theCollectionId);
}
?>
