<?php
 
 
 $parent = $_POST['menu'];
 $collection = $_POST['collection'];
 
 require_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_COLLECTION.php');
 include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');

 Logger::configure($_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
 $logger= Logger::getLogger("insertSubMenu");
 
 $logger->trace("Enter");
 $logger->debug("Parameters: menu id [ " . $_POST['menu'] ." ]. New collection [ ".
               $_POST['collection']. " ]");
 //$lastId = TB_MENUS::insertSubMenu($_POST['menu'], $_POST['collection']);
 $lastId = TB_COLLECTION::insert($_POST['collection'], $_POST['menu']);
 
 $logger->debug("The new collection ID is [ " . $lastId . " ]");
 
 $returnValue = array();
 $returnValue['id'] = $lastId;
 $returnValue['collection'] = $collection;
 $logger->trace("Exit");
 echo json_encode($returnValue); 

?>