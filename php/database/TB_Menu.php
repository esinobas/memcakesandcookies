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

   class TB_Menu extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_MenuTableC = "TB_Menu";

 
     /*
      * Contants table columns
      */
     const IdColumnC = "Id";
     const OptionColumnC = "Option";
      
      /*** Phisical constants ***/

   
      const phisicalTB_MENUC = "TB_MENU";
      const phisicalTB_MENUIDColumnC = "ID";
      const phisicalTB_MENUoption_menuColumnC = "option_menu";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_MenuTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::IdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::OptionColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::IdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_MENUC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_MENUC ,
            self::phisicalTB_MENUIDColumnC ,
            self::IdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_MENUC ,
            self::phisicalTB_MENUoption_menuColumnC ,
            self::OptionColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addKey(self::phisicalTB_MENUC,
            self::phisicalTB_MENUIDColumnC );
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theOption
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::OptionColumnC] = $theOption;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::IdColumnC);
      }
      
      public function getOption(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::OptionColumnC);
      }
      
      public function setOption($Option){
         $this->loggerM->trace("Enter");
         $this->set(self::OptionColumnC, $Option);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_MenuTableC;
      }
   }
?>
