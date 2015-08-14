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

   class TB_ImageType extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_ImageTypeTableC = "TB_ImageType";

 
     /*
      * Contants table columns
      */
     const IdColumnC = "Id";
     const TypeColumnC = "Type";
      
      /*** Phisical constants ***/

   
      const phisicalTB_TYPESC = "TB_TYPES";
      const phisicalTB_TYPESIDColumnC = "ID";
      const phisicalTB_TYPESTYPEColumnC = "TYPE";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_ImageTypeTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::IdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::TypeColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::IdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_TYPESC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_TYPESC ,
            self::phisicalTB_TYPESIDColumnC ,
            self::IdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_TYPESC ,
            self::phisicalTB_TYPESTYPEColumnC ,
            self::TypeColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addKey(self::phisicalTB_TYPESC,
            self::phisicalTB_TYPESIDColumnC );
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theType
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::TypeColumnC] = $theType;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::IdColumnC);
      }
      
      public function getType(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::TypeColumnC);
      }
      
      public function setType($Type){
         $this->loggerM->trace("Enter");
         $this->set(self::TypeColumnC, $Type);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_ImageTypeTableC;
      }
   }
?>
