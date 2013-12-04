<?php

/**
 * File that contains the queries for search the cakes in the database and
 * show them.
 */
 
require_once($_SERVER['DOCUMENT_ROOT'].'/php/ddbb/DBIterator.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_CAKES.php');


function getAllCakes(){

   return TB_CAKES::getAll();
}

?>
