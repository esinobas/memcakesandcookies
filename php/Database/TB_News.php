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

   class TB_News extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_NewsTableC = "TB_News";

 
     /*
      * Contants table columns
      */
     const IdColumnC = "Id";
     const DateTimeColumnC = "DateTime";
     const TitleColumnC = "Title";
     const NewColumnC = "New";
      
      /*** Phisical constants ***/

   
      const phisicalTB_NewsC = "TB_News";
      const phisicalTB_NewsIdColumnC = "Id";
      const phisicalTB_NewsDateTimeColumnC = "DateTime";
      const phisicalTB_NewsTitleColumnC = "Title";
      const phisicalTB_NewsNewColumnC = "New";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_NewsTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::IdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::DateTimeColumnC,ColumnType::timestampC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::TitleColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::NewColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::IdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_NewsC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_NewsC ,
            self::phisicalTB_NewsIdColumnC ,
            self::IdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_NewsC ,
            self::phisicalTB_NewsDateTimeColumnC ,
            self::DateTimeColumnC,
            ColumnType::timestampC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_NewsC ,
            self::phisicalTB_NewsTitleColumnC ,
            self::TitleColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_NewsC ,
            self::phisicalTB_NewsNewColumnC ,
            self::NewColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addKey(self::phisicalTB_NewsC,
            self::phisicalTB_NewsIdColumnC );
      
      $this->tableMappingM->addOrderBy(array("column"=>"DateTime", "type"=>"DESC"));
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theDateTime
                              ,$theTitle
                              ,$theNew
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::DateTimeColumnC] = $theDateTime;
         $arrayData[self::TitleColumnC] = $theTitle;
         $arrayData[self::NewColumnC] = $theNew;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::IdColumnC);
      }
      
      public function getDateTime(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::DateTimeColumnC);
      }
      
      public function setDateTime($DateTime){
         $this->loggerM->trace("Enter");
         $this->set(self::DateTimeColumnC, $DateTime);
         $this->loggerM->trace("Exit");
      }
      public function getTitle(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::TitleColumnC);
      }
      
      public function setTitle($Title){
         $this->loggerM->trace("Enter");
         $this->set(self::TitleColumnC, $Title);
         $this->loggerM->trace("Exit");
      }
      public function getNew(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::NewColumnC);
      }
      
      public function setNew($New){
         $this->loggerM->trace("Enter");
         $this->set(self::NewColumnC, $New);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_NewsTableC;
      }
   }
?>
