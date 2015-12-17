<?php
/**
 * File with the commands for send emails from web request
 */

   set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'].
      '/php/');
   
   include_once 'LoggerMgr/LoggerMgr.php';
   
   const RESULT_CODE_OK = 0;
   const RESULT_CODE_ERROR = 1;
   const EMAILS_DATA = 'emailsData';
   
   const EMAIL_ADDRESS = "address";
   const EMAIL_MESSAGE = "message";
   const EMAIL_SUBJECT = "subject";
   const EMAIL_FROM = "from";
   
   $loggerM = LoggerMgr::Instance()->getLogger(basename(__FILE__));
   
   $loggerM->debug("A request from web has been received");
   
   if (!isset($_POST[EMAILS_DATA])){
      $loggerM->error("The request has not the parameter \"" . EMAILS_DATA . "\"");
      
      print(RESULT_CODE_ERROR);
   }else{
      $emailsData = $_POST[EMAILS_DATA];
      $loggerM->trace("Parameters [ $emailsData ]");
      $jsonEmailsData = json_decode($emailsData, true);
      $error = false;
      foreach ($jsonEmailsData as $emailData){
         $toMail = $emailData[EMAIL_ADDRESS];
         $subject = $emailData[EMAIL_SUBJECT];
         $message = $emailData[EMAIL_MESSAGE];
         $from = $emailData[EMAIL_FROM];
         $headers = "From : $from \r\n";
         $headers .= "X-Mailer: ". phpversion() ."\r\n";
         $headers .= 'MIME-Version: 1.0' . "\r\n";
         $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
         $loggerM->debug("Sending email to [ $toMail ] from [ $from ] with subject [ $subject]");
         if (mail($toMail, $subject, $message, $headers)){
            $loggerM->debug("The email was sent succcessfull");
         }else{
            $loggerM->error("The email was not sent");
            $error = true;
         }
      }
      if (!$error){
         print(RESULT_CODE_OK);
      }else{
         print(RESULT_CODE_ERROR);
      }
   }
   $loggerM->trace("Exit");
?>