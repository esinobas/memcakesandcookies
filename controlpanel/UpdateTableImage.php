<?php
   require_once($_SERVER['DOCUMENT_ROOT']."/php/localDB/TableImage.php");   
   $id = $_POST['id']; 
   $desc = $_POST['desc'];
   
   TableImage::updateDescription($id, $desc);
   
   
?>