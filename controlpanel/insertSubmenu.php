<?php
 
 
 $parent = $_POST['parent'];
 $menu = $_POST['menu'];
 
 require_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_MENUS.php');

 $lastId = TB_MENUS::insertSubMenu($_POST['parent'], $_POST['menu']);
 
 $returnValue = array();
 $returnValue['id'] = $lastId;
 $returnValue['menu'] = $menu;
 echo json_encode($returnValue); 

?>