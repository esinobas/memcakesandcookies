<?php

   require_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_CAKES.php');
   require_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_COOKIES.php');
   require_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_MODELING.php');

   $path = $_POST['path'];
   $file = $_POST['file'];
   $desc = $_POST['desc'];
   $type = $_POST['typeImage'];
   
   if ($type == "Cakes"){
      TB_CAKES::create($path, $file, $desc);
   }
   if ($type == "Cookies"){
      TB_COOKIES::create($path, $file, $desc);
      
   }
   if ($type == "Modelados"){
      TB_MODELING::create($path, $file, $desc);
   }

   echo "OK";


?>