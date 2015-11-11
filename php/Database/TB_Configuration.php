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

   class TB_Configuration extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_ConfigurationTableC = "TB_Configuration";

 
     /*
      * Contants table columns
      */
     const PropertyColumnC = "Property";
     const ValueColumnC = "Value";
     const DescriptionColumnC = "Description";
     const LabelColumnC = "Label";
     const DataTypeColumnC = "DataType";
      
      /*** Phisical constants ***/

   
      const phisicalTB_CONFIGURATIONC = "TB_CONFIGURATION";
      const phisicalTB_CONFIGURATIONPropertyColumnC = "Property";
      const phisicalTB_CONFIGURATIONValueColumnC = "Value";
      const phisicalTB_CONFIGURATIONDescriptionColumnC = "Description";
      const phisicalTB_CONFIGURATIONLabelColumnC = "Label";
      const phisicalTB_CONFIGURATIONDataTypeColumnC = "DataType";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_ConfigurationTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::PropertyColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::ValueColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::DescriptionColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::LabelColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::DataTypeColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::PropertyColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_CONFIGURATIONC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CONFIGURATIONC ,
            self::phisicalTB_CONFIGURATIONPropertyColumnC ,
            self::PropertyColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CONFIGURATIONC ,
            self::phisicalTB_CONFIGURATIONValueColumnC ,
            self::ValueColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CONFIGURATIONC ,
            self::phisicalTB_CONFIGURATIONDescriptionColumnC ,
            self::DescriptionColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CONFIGURATIONC ,
            self::phisicalTB_CONFIGURATIONLabelColumnC ,
            self::LabelColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CONFIGURATIONC ,
            self::phisicalTB_CONFIGURATIONDataTypeColumnC ,
            self::DataTypeColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addKey(self::phisicalTB_CONFIGURATIONC,
            self::phisicalTB_CONFIGURATIONPropertyColumnC );
      
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theValue
                              ,$theDescription
                              ,$theLabel
                              ,$theDataType
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::ValueColumnC] = $theValue;
         $arrayData[self::DescriptionColumnC] = $theDescription;
         $arrayData[self::LabelColumnC] = $theLabel;
         $arrayData[self::DataTypeColumnC] = $theDataType;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getProperty(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::PropertyColumnC);
      }
      
      public function getValue(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::ValueColumnC);
      }
      
      public function setValue($Value){
         $this->loggerM->trace("Enter");
         $this->set(self::ValueColumnC, $Value);
         $this->loggerM->trace("Exit");
      }
      public function getDescription(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::DescriptionColumnC);
      }
      
      public function setDescription($Description){
         $this->loggerM->trace("Enter");
         $this->set(self::DescriptionColumnC, $Description);
         $this->loggerM->trace("Exit");
      }
      public function getLabel(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::LabelColumnC);
      }
      
      public function setLabel($Label){
         $this->loggerM->trace("Enter");
         $this->set(self::LabelColumnC, $Label);
         $this->loggerM->trace("Exit");
      }
      public function getDataType(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::DataTypeColumnC);
      }
      
      public function setDataType($DataType){
         $this->loggerM->trace("Enter");
         $this->set(self::DataTypeColumnC, $DataType);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_ConfigurationTableC;
      }
   }
?>
