<?php
   /**
    * Class with the specific methods and properties to access to the table data
    * 
    * In this class the logical structure table is defined.
    */
   set_include_path( get_include_path() . PATH_SEPARATOR . dirname(__FILE__));
   
   include_once dirname(__FILE__).'/DatabaseCore/TableDef.php';
   include_once dirname(__FILE__).'/DatabaseCore/ColumnDef.php';
   include_once dirname(__FILE__).'/DatabaseCore/ColumnType.php';
   include_once dirname(__FILE__).'/DatabaseCore/TableMapping.php';
   include_once dirname(__FILE__).'/DatabaseCore/GenericTable.php';
   include_once 'LoggerMgr/LoggerMgr.php';

   class TB_Users extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_UsersTableC = "TB_Users";

 
     /*
      * Contants table columns
      */
     const IdColumnC = "Id";
     const NameColumnC = "Name";
     const EmailColumnC = "Email";
     const PasswordColumnC = "Password";
      
      /*** Phisical constants ***/

   
      const phisicalTB_USERSC = "TB_USERS";
      const phisicalTB_USERSIdColumnC = "Id";
      const phisicalTB_USERSNameColumnC = "Name";
      const phisicalTB_USERSEmailColumnC = "Email";
      const phisicalTB_USERSPasswordColumnC = "Password";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_UsersTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::IdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::NameColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::EmailColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::PasswordColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::IdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_USERSC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_USERSC ,
            self::phisicalTB_USERSIdColumnC ,
            self::IdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_USERSC ,
            self::phisicalTB_USERSNameColumnC ,
            self::NameColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_USERSC ,
            self::phisicalTB_USERSEmailColumnC ,
            self::EmailColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_USERSC ,
            self::phisicalTB_USERSPasswordColumnC ,
            self::PasswordColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addKey(self::phisicalTB_USERSC,
            self::phisicalTB_USERSIdColumnC );
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theName
                              ,$theEmail
                              ,$thePassword
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::NameColumnC] = $theName;
         $arrayData[self::EmailColumnC] = $theEmail;
         $arrayData[self::PasswordColumnC] = $thePassword;
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
      public function getEmail(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::EmailColumnC);
      }
      
      public function setEmail($Email){
         $this->loggerM->trace("Enter");
         $this->set(self::EmailColumnC, $Email);
         $this->loggerM->trace("Exit");
      }
      public function getPassword(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::PasswordColumnC);
      }
      
      public function setPassword($Password){
         $this->loggerM->trace("Enter");
         $this->set(self::PasswordColumnC, $Password);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_UsersTableC;
      }
   }
?>
