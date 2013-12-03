<?php
/*require_once("ddbb.php");
require_once("MySqlDAO.php");
*/
function checkData(){

  if (!isset($_POST["user"]) || !isset($_POST["password"])){

      return false;   
   }
   
   if (strlen($_POST["user"]) == 0 || strlen($_POST["password"]) == 0 ){
      return  false;   
   }
   
   return true;
}

function checkLogin($theLogin, $thePassword){
   
  /*include_once($_SERVER["DOCUMENT_ROOT"]."/php/localDB/TB_USERS.php");*/
  include_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_USERS.php');
 
   $user = new TB_USERS();
   
   $user->getUserByLogin($theLogin); 
       
   if ($user->exists()){
          
     if ($thePassword == $user->getPassword()){
         return true; 
     }else{
         return false;     
     }   
  }else{  
      
      return false;
     
  }
     
}
?>