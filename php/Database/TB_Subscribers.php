<?php
   /**
    * Class with the specific methods and properties to access to the table data
    * 
    * In this class the logical structure table is defined.
    */
   
   if ( ! strpos(get_include_path(), dirname(__FILE__))){ 
      set_include_path( get_include_path() . PATH_SEPARATOR . dirname(__FILE__));
   }
   
   include_once dirname(__FILE__).'/DatabaseCore/TableDef.php';
   include_once dirname(__FILE__).'/DatabaseCore/ColumnDef.php';
   include_once dirname(__FILE__).'/DatabaseCore/ColumnType.php';
   include_once dirname(__FILE__).'/DatabaseCore/TableMapping.php';
   include_once dirname(__FILE__).'/DatabaseCore/GenericTable.php';
   include_once 'LoggerMgr/LoggerMgr.php';

   class TB_Subscribers extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_SubscribersTableC = "TB_Subscribers";

 
     /*
      * Contants table columns
      */
     const IdColumnC = "Id";
     const NameColumnC = "Name";
     const SurnameColumnC = "Surname";
     const EmailColumnC = "Email";
      
      /*** Phisical constants ***/

   
      const phisicalTB_SubscribersC = "TB_Subscribers";
      const phisicalTB_SubscribersIdColumnC = "Id";
      const phisicalTB_SubscribersNameColumnC = "Name";
      const phisicalTB_SubscribersSurnameColumnC = "Surname";
      const phisicalTB_SubscribersEmailColumnC = "Email";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_SubscribersTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::IdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::NameColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::SurnameColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::EmailColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::IdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_SubscribersC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_SubscribersC ,
            self::phisicalTB_SubscribersIdColumnC ,
            self::IdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_SubscribersC ,
            self::phisicalTB_SubscribersNameColumnC ,
            self::NameColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_SubscribersC ,
            self::phisicalTB_SubscribersSurnameColumnC ,
            self::SurnameColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_SubscribersC ,
            self::phisicalTB_SubscribersEmailColumnC ,
            self::EmailColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addKey(self::phisicalTB_SubscribersC,
            self::phisicalTB_SubscribersIdColumnC );
      
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theName
                              ,$theSurname
                              ,$theEmail
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::NameColumnC] = $theName;
         $arrayData[self::SurnameColumnC] = $theSurname;
         $arrayData[self::EmailColumnC] = $theEmail;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::IdColumnC);
      }
      
      public function getName(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::NameColumnC);
      }
      
      public function setName($Name){
         $this->loggerM->trace("Enter");
         $this->set(self::NameColumnC, $Name);
         $this->loggerM->trace("Exit");
      }
      public function getSurname(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::SurnameColumnC);
      }
      
      public function setSurname($Surname){
         $this->loggerM->trace("Enter");
         $this->set(self::SurnameColumnC, $Surname);
         $this->loggerM->trace("Exit");
      }
      public function getEmail(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::EmailColumnC);
      }
      
      public function setEmail($Email){
         $this->loggerM->trace("Enter");
         $this->set(self::EmailColumnC, $Email);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_SubscribersTableC;
      }
   }
?>
