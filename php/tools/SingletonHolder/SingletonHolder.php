<?php
   /**
    * Singleton Class where are stored objects to be used in several place in 
    * the code
    */
   class SingletonHolder{
      
      /*** Private variables ***/
      /**
       * Static variable where is saved itself
       * @var SingletonHolder
       */
      private static $instanceM = null;
      
      /**
       * Array where the objects are saved. The key will be a string  to refers
       * to the object
       * @var array
       */
      private $containerM = array();
      
      
      /*** Private methods ***/
      
      /**
       * Constructor
       */
      private function __construct(){
         
      }
      
      /**
       * Destructor
       */
      private function __destruct(){
         
      }
      
      
      /*** Public functions ***/
      
      static public function getInstance(){
         
         if (!isset(self::$instanceM)){
            $className = __CLASS__;
            self::$instanceM = new $className;
         }
         return self::$instanceM;
      }
      
      /**
       * Method that clones the current object.
       * The clonation of the object is not allowed.
       */
      public function __clone(){
         //Avoid the class can be cloned
         trigger_error('The clonation of this object is not allowed',
               E_USER_ERROR);
      }
      
      /**
       * Saves an object in the memory to be used in a future by the application and
       * only it is created once.
       * 
       * @param string $theKey: Key to identify the object;
       * @param unknown $theObject
       */
      public function setObject($theKey, $theObject){
         $this->containerM[$theKey] = $theObject;
      }
      
      /**
       * Returns a object saved in the memory that it is searched by its key
       * @param string $theKey
       * @return multitype:|NULL
       */
      public function getObject($theKey){
         if (array_key_exists($theKey, $this->containerM)){
            return $this->containerM[$theKey];
         }else{
            return null;
         }
         
      }
      
      
   }
?>