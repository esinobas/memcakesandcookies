<?php

   
   /*include_once($_SERVER["DOCUMENT_ROOT"]."/php/localDB/ddbb.php");*/
   include_once('ddbb.php');
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/MySqlDAO.php");
   
   // Definition of the data base tables
   
   define('tableNameC', 'TB_USERS');
   define('columnIdC', 'Id');
   define('columnNameC', 'Name');
   define('columnPwdC', 'Password');
   define('columnEmailC', 'Email');
   
   /**
    * Object where are stored the users login information
    */
   class TB_USERS {
      
      /**
       * Property where is saved the user login
       */
      protected $loginM;
      
      /**
       * Property where is saved the user name
      */
      protected $nameM;
   
      /**
       *  Property where is saved the user password
       */
      protected $pwdM;
   
      /**
       * Property where is saved the user email
       */
      protected $emailM;
   
      /**
       * Property for know when a user exists or doesn't exist
       */
      protected $existM;
   
         
      /**
       * Constructor
       */
      public function __construct(){
   
         $this->existM = false;
         
      }   
      /**
       * Destructor
       */
      function __destruct(){
      
      }
      
      /**
       *       
       */
      public function getLogin(){
         $this->loginM;   
      }
      
      /**
       *       
       */
      public function getPassword() {
         return $this->pwdM;      
      } 
      
      /**
       *       
       */
      public function getName(){
         return $this->nameM;      
      }
   
      /**
       *       
       */
      public function getEmail(){
         return $this->emailM;      
      }
      
      /**
       *
       */
      public function exists(){
         return $this->existM;     
      }
        
      public function getUserByLogin($theLogin){
          
          $query = "select ".columnIdC.",".columnNameC." ,".columnPwdC." ,"; 
          $query .= columnEmailC." from ".tableNameC." where ".columnIdC ."= '".$theLogin."'";
          
         
          
          $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
           //printf("%s,%s,%s,%s<br>\n", serverC, userC, pwdC, ddbbC);
          $conn->connect();
                   
          if($conn->isConnected()) { 
           
            $result = $conn->query($query);
            
            if ($result != NULL){ 
          
               $this->existM = true;
               $row = $result[0];
               $this->loginM = $row[columnIdC];
               $this->pwdM = $row[columnPwdC];
               $this->nameM = $row[columnNameC];
               $this->emailM = $row[columnEmailC];
            }
            
            $conn->closeConnection();
          }
                 
      }
          
        
   }
      

?>