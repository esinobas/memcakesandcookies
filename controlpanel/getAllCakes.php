<?php

/**
 * File used for get all cakes from data base through AJAX.
 */
 
 require_once(dirname(__FILE__).'/CakesQueires.php');
 require_once($_SERVER['DOCUMENT_ROOT'].'/php/ddbb/DBIterator.php');
  
 var $cakes = getAllCakes();
 
 var_dump($cakes);
  
?>
