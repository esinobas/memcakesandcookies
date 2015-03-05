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

   class TB_Level extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_LevelTableC = "TB_Level";

 
     /*
      * Contants table columns
      */
     const IdColumnC = "Id";
     const LevelColumnC = "Level";
      
      /*** Phisical constants ***/

   
      const phisicalTB_LevelC = "TB_Level";
      const phisicalTB_LevelIdColumnC = "Id";
      const phisicalTB_LevelLevelColumnC = "Level";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_LevelTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::IdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::LevelColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::IdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_LevelC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_LevelC ,
            self::phisicalTB_LevelIdColumnC ,
            self::IdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_LevelC ,
            self::phisicalTB_LevelLevelColumnC ,
            self::LevelColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addKey(self::phisicalTB_LevelC,
            self::phisicalTB_LevelIdColumnC );
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theLevel
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::LevelColumnC] = $theLevel;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::IdColumnC);
      }
      
      public function getLevel(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::LevelColumnC);
      }
      
      public function setLevel($Level){
         $this->loggerM->trace("Enter");
         $this->set(self::LevelColumnC, $Level);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_LevelTableC;
      }
   }