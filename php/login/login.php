<?php

require_once 'LoggerMgr/LoggerMgr.php';
$logger =  LoggerMgr::Instance()->getLogger("login.php");

/*function checkData(){

  if (!isset($_POST["user"]) || !isset($_POST["password"])){

      return false;   
   }
   
   if (strlen($_POST["user"]) == 0 || strlen($_POST["password"]) == 0 ){
      return  false;   
   }
   
   return true;
}*/

function checkLogin($theLogin, $thePassword){
   
   global $logger;
   require_once 'Database/TB_Users.php';
   
   $logger->trace("Enter");
   $logger->trace("Login [ $theLogin ]. Password [ $thePassword ]");
  
   $tableUsers = new TB_Users();
   $tableUsers->open();
   $tableUsers->searchByKey($theLogin);
   
   if ( ! $tableUsers->isEmpty()){
      $logger->trace("The user [ $theLogin ] has been found.");
      if ($thePassword == $tableUsers->getPassword()){
         $logger->trace("The result is success");
         $logger->trace("Exit");
        return true; 
     }else{
        $logger->debug("The password [ $thePassword ] is not correct for the login [ $theLogin ]");
        $logger->trace("Exit");
         return false;     
     }   
   }else{  
      $logger->debug("The login [ $theLogin ] has been not found.");
      $logger->trace("Exit");
      return false;
     
   }
     
}
?>