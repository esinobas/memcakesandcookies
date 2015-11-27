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

   class TB_MenuCollection extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_MenuCollectionTableC = "TB_MenuCollection";

 
     /*
      * Contants table columns
      */
     const MenuIdColumnC = "MenuId";
     const MenuOptionColumnC = "MenuOption";
     const CollectionIdColumnC = "CollectionId";
     const CollectionNameColumnC = "CollectionName";
      
      /*** Phisical constants ***/

   
      const phisicalTB_MENUC = "TB_MENU";
      const phisicalTB_MENUoption_menuColumnC = "option_menu";

   
      const phisicalTB_COLLECTIONC = "TB_COLLECTION";
      const phisicalTB_COLLECTIONIdColumnC = "Id";
      const phisicalTB_COLLECTIONNameColumnC = "Name";
      const phisicalTB_COLLECTIONId_MenuColumnC = "Id_Menu";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_MenuCollectionTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::MenuIdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::MenuOptionColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CollectionIdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CollectionNameColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::CollectionIdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_MENUC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_MENUC ,
            self::phisicalTB_MENUoption_menuColumnC ,
            self::MenuOptionColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addTable(self::phisicalTB_COLLECTIONC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_COLLECTIONC ,
            self::phisicalTB_COLLECTIONIdColumnC ,
            self::CollectionIdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_COLLECTIONC ,
            self::phisicalTB_COLLECTIONNameColumnC ,
            self::CollectionNameColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_COLLECTIONC ,
            self::phisicalTB_COLLECTIONId_MenuColumnC ,
            self::MenuIdColumnC,
            ColumnType::integerC);
      
      $this->tableMappingM->addKey(self::phisicalTB_COLLECTIONC,
            self::phisicalTB_COLLECTIONIdColumnC );

      $this->tableMappingM->addCondition("TB_MENU.ID = TB_COLLECTION.Id_Menu");
      
      $this->tableMappingM->addOrderBy(array("column"=>"TB_COLLECTION.Id", "type"=>"DESC"));
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theMenuId
                              ,$theMenuOption
                              ,$theCollectionName
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::MenuIdColumnC] = $theMenuId;
         $arrayData[self::MenuOptionColumnC] = $theMenuOption;
         $arrayData[self::CollectionNameColumnC] = $theCollectionName;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getMenuId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::MenuIdColumnC);
      }
      
      public function setMenuId($MenuId){
         $this->loggerM->trace("Enter");
         $this->set(self::MenuIdColumnC, $MenuId);
         $this->loggerM->trace("Exit");
      }
      public function getMenuOption(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::MenuOptionColumnC);
      }
      
      public function setMenuOption($MenuOption){
         $this->loggerM->trace("Enter");
         $this->set(self::MenuOptionColumnC, $MenuOption);
         $this->loggerM->trace("Exit");
      }
      public function getCollectionId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::CollectionIdColumnC);
      }
      
      public function getCollectionName(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::CollectionNameColumnC);
      }
      
      public function setCollectionName($CollectionName){
         $this->loggerM->trace("Enter");
         $this->set(self::CollectionNameColumnC, $CollectionName);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_MenuCollectionTableC;
      }
   }
?>
