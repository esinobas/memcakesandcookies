<?php

   define('VARCHAR',0);
   define('INT',1);
   define('FLOAT',2);
   define('BOOLEAN',3);
   define('TIMESTAMP',4);
    
   class MySqlDAO{
           
      /**
       * Property
       */
      private $hostM;
      
      private $userM;
      
      private $pwdM;
      
      private $ddbbM;
      
      private $connectionM;
      
      private $isConnectedM;
      
      function __construct($theHost, $theUser, $thePwd, $theDDBB){

         $this->hostM = $theHost;
         $this->userM = $theUser;
         $this->pwdM = $thePwd;
         $this->ddbbM = $theDDBB;      
         $this->isConnectedM = false;  
      }
      
      /**
      * Destructor
      */
     function __destruct(){
     
        if ($this->isConnectedM){
           $this->closeConnection();        
        }     
     }
     
     
     
           
      public function connect() {
      
         if (! $this->isConnectedM){
            
            $this->connectionM = new mysqli($this->hostM, $this->userM, $this->pwdM,$this->ddbbM);
      
            if ($this->connectionM->connect_errno){
          
               return false;
            }   
            
            $this->isConnectedM = true;
         }
            return true;
      }
   


      public function getConnectError(){
         
         
         return $this->connectionM->connect_error;
            
      }
     
      public function isConnected(){
        
         return $this->isConnectedM;     
      }
     
      public function closeConnection(){
           if ($this->isConnectedM){
        
              $this->connectionM->close();
              $this->isConnectedM = false;
           }
      }
      
      public function query($theQuery){
         
         
         $result = $this->connectionM->query($theQuery);     
         $resultQuery = null;         
             
         if ($result){
            
            
            if ($result->num_rows > 0){
               $idx = 0;
               while ($row = $result->fetch_assoc()){
                  foreach ($row as $column => $value){
                     $dataRow[$column] = $value;
                  }
                  $resultQuery[$idx] = $dataRow;
                  $idx ++;
               }
            }            
            $result->close();
         }
         return $resultQuery;
      }     
     
  
     public function sqlCommand($theCommand){
        
        $this->connectionM->query($theCommand);
        return $this->connectionM->errno;     
     }
     
   
   }

?>