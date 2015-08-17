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

   class TB_SlideImagesHome extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_SlideImagesHomeTableC = "TB_SlideImagesHome";

 
     /*
      * Contants table columns
      */
     const IdColumnC = "Id";
     const PathColumnC = "Path";
      
      /*** Phisical constants ***/

   
      const phisicalTB_SLIDES_HOMEC = "TB_SLIDES_HOME";
      const phisicalTB_SLIDES_HOMEIdColumnC = "Id";
      const phisicalTB_SLIDES_HOMEImagePathColumnC = "ImagePath";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_SlideImagesHomeTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::IdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::PathColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::IdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_SLIDES_HOMEC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_SLIDES_HOMEC ,
            self::phisicalTB_SLIDES_HOMEIdColumnC ,
            self::IdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_SLIDES_HOMEC ,
            self::phisicalTB_SLIDES_HOMEImagePathColumnC ,
            self::PathColumnC,
            ColumnType::stringC);
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $thePath
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::PathColumnC] = $thePath;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::IdColumnC);
      }
      
      public function getPath(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::PathColumnC);
      }
      
      public function setPath($Path){
         $this->loggerM->trace("Enter");
         $this->set(self::PathColumnC, $Path);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_SlideImagesHomeTableC;
      }
   }
?>
