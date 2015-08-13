<?php
   /**
    * Class writes in a log flow traces
    * The Logger is a singleton and it only instance one time in all program
    * The class returns the log4php object or class, it allows access to its methods
    * to write in the log.
    */
   
   set_include_path( get_include_path() . PATH_SEPARATOR . dirname(__FILE__));
   
   include_once dirname(__FILE__).'/log4php/Logger.php';
   
   class LoggerMgr{
            
      /*
       * Class consts
       */
      /**
       * 
       * @var confFileC: The log configuration file.
       */
      const confFileC = "cfg/LoggerMgr.xml";
      
      /*
       * Class properties
       */
      
      /**
       * 
       * @var instanceM: It is a instance of LoggerMgr that provides the object 
       * loggers.
       */
      protected static $instanceM = NULL;
      
      /*
       * Protected methods
       */
      
      /**
       * Constructor
       */
      protected function __construct(){
         
         //Initialize the log4php object
         $confFile = dirname(__FILE__)."/".LoggerMgr::confFileC;
         Logger::configure($confFile);
      }
      
      /*
       * Public methods
       */
      
      /**
       * Static function that creates the object LoggerMgr whenever this is not
       * created and returns the object to allowd get a logger
       *
       * @return instanceM: A instance of LoggerMgr;
       */
      static public function Instance(){
         
         
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
       * Funtions that returns a logger.
       * 
       * @param string $theLoggerName: The name of the logger that will be used
       * to write a log.
       * 
       * @return A Logger.
       */
      public function getLogger($theLoggerName){
         
         return Logger::getLogger($theLoggerName);
      }
   }
?>