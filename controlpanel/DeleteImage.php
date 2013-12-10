<?php
   require_once($_SERVER['DOCUMENT_ROOT']."/php/localDB/TableImage.php");   
   $id = $_POST['id']; 
   
   $image = TableImage::selectImageById($id);
   
   if (TableImage::delete($id) == 0){
       $path = sprintf("../%s/%s",  $image->getPath(),$image->getNameFile());
       unlink($path);
       $path = sprintf("../%s/thumbnails/*.*",  $image->getPath());
       array_map("unlink",glob($path));   
   }
   
   
  

?>
