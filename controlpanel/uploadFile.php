<?php

    //El directorio tmp y destino, deben de tener permisos de escritura en el servidor

    if ($_FILES["fileNameToSend"]["error"] == 0){   
        
       $dir_destin = $_SERVER['DOCUMENT_ROOT'].'/'.$_POST["path"].'/';
       if (! move_uploaded_file($_FILES["fileNameToSend"]["tmp_name"],$dir_destin.$_FILES["fileNameToSend"]["name"])){
           $returnValue = array();
           $returnValue["Error"] = "Se ha producido un error";
           $returnValue["tmp_name"] =  $_FILES["fileNameToSend"]["tmp_name"];
           $returnValue["dir_destin"] = $dir_destin;
           $returnValue["file_name"] = $dir_destin.$_FILES["fileNameToSend"]["name"];    
           echo json_encode($returnValue);     
       }else{
           echo "OK";       
       }
   }else{
        echo "Se ha producido un error";  
   }
   
  
   
?>