<?php
/**
 *  Class that allows extract the information from the table TB_COLLECTION
 *  from the database and it is transformed in a login structure.
 */


   include_once("ddbb.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/MySqlDAO.php");
   include_once($_SERVER['DOCUMENT_ROOT']."/php/ddbb/DBIterator.php");
   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');

   
   define('TableNameC', 'TB_COLLECTION');
   define('IdCollectionC', 'Id');
   define('CollectionC', 'Name');
   define('MenuC', 'Id_Menu');
   
   define('logConfigurationC', $_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
   
   class TB_COLLECTION{
      
      /**
       * Class properties
       */
      
      /**
       * 
       * @var IdM: Collection identifier
       */
      private $idM;
      
      /**
       * 
       * @var collection: The collection name
       */
      private $collectionM;
      
      /**
       * 
       * @var menuId: It is the menu identifier of the collection wich it belongs
       */
      private $menuIdM;
      
      /**
       * Methods
       */
      
      /**
       * Constructor
       */
      function __construct($theId){
         
         $this->idM = $theId;
      }
      
      /**
       * Destructor
       */
      function __destruct(){
         
      }
      
      /**
       * It returns the collection Id.
       * 
       * @return IdM: The collection identifier 
       */
      public function getId(){
         return $this->idM;
      }
      
      /**
       * It sets the name to the collection.
       * @param string theCollectionName: The name that is set to the collection
       */
      public function setName($theCollectionName){
         
         $this->collectionM = $theCollectionName;
      }
      
      /**
       * It returns the collection name.
       * @return The collection name
       */
      public function getName(){
         
         return $this->collectionM;
      }
      
      /**
       * Method that sets the menu id to which the collection belongs.
       * @param integer $theMenuId: The menu id.
       */
      public function setMenuId($theMenuId){
         
         $this->menuIdM = $theMenuId;
      }
      
      /**
       * It returns the menu id to wich the collection belongs
       * 
       * @return The menu id.
       */
      public function getMenuId(){
         
         return $this->menuIdM;
      }
      
      /**
       * Function what inserts in the table TB_COLLECTION a new collection
       * that belongs to menu option.
       * 
       * @param string $theCollectionName. The new collection name
       * @param number $theMenuId. The menu id to which the new collection 
       * belongs
       * @return number: The new collection ID when the insert was done 
       * successfuly. Other way the returned value is -1.
       */
      
      static public function insert($theCollectionName, $theMenuId){
         
         
         $logger = Logger::getLogger(__CLASS__);
         
         $logger->trace("Enter");
         
         $query = sprintf("insert into %s (%s,%s) values ('%s', %d)",
                                                   TableNameC,
                                                   CollectionC,
                                                   MenuC,
                                                   $theCollectionName,
                                                   $theMenuId);
         
         $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
          
         $conn->connect();
         $result = 0;
         $lastId = -1;
         if($conn->isConnected()) {
            $logger->trace("The connection with the database was established succcessfully");
            
            
            $logger->debug("Run the stament [ " . $query . " ]");
            $result = $conn->sqlCommand($query);
            if ($result == 0){
               $logger->debug("The stament was executed correctly");
               $lastId = $conn->getLastId();
               $logger->debug("New collection id [ " .$lastId ." ]");
            }else{
               $logger->error("An error was produced in the stament");
            }
         }
         $conn->closeConnection();
         
         $logger->trace("Exit");
         return $lastId;
      }
      
      
      static public function getCollectionsFromMenu($theMenuId){
         
         Logger::configure($_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
         $logger = Logger::getLogger(__CLASS__);
          
         $logger->trace("Enter");
         
         $logger->debug("Search collections from menu [ " . $theMenuId ." ]");
         
         $query = sprintf("select %s, %s from %s where %s=%d"
                                                       ,IdCollectionC
                                                       ,CollectionC
                                                       ,TableNameC
                                                       ,MenuC
                                                       ,$theMenuId);
         
         $conn = new MySqlDAO(serverC, userC, pwdC, ddbbC);
          
         $conn->connect();
          
         $result;
         $rows;
         
         if($conn->isConnected()) {
            $logger->trace("The connection was established successfully");
            $logger->debug("Run query [ " . $query ." ]");
            $result = $conn->query($query);
         
            if ($result != null){
                
             $numRows = count($result);
              $idx = 0;
               while ( $idx < $numRows){
                   
                  /*$option = new TB_MENUS();
                   $option->setId($result[$idx][idC]);*/
                  $logger->debug("Create collection  with id [ ".
                        $result[$idx][IdCollectionC] ." ] and name [ ".
                        $result[$idx][CollectionC] ." ]" );
                  
                  $collection = new TB_COLLECTION($result[$idx][IdCollectionC]);
                  $collection->setName($result[$idx][CollectionC]);
                  $collection->setMenuId($theMenuId);
                  $rows[$idx] = $collection;
                  $idx ++;
               }
            }
            $conn->closeConnection();
         }else{
            $logger->error("An error is produced in database connection");
         }
         
         $logger->trace("Exit");
         return new DBIterator($rows);
      }
   }
   
?>