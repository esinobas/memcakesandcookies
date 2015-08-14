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

   class TB_ModelsByCollection extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_ModelsByCollectionTableC = "TB_ModelsByCollection";

 
     /*
      * Contants table columns
      */
     const CollectionIdColumnC = "CollectionId";
     const CollectionNameColumnC = "CollectionName";
     const ImageIdColumnC = "ImageId";
     const ImagePathColumnC = "ImagePath";
     const ImageDescriptionColumnC = "ImageDescription";
     const ImageNameColumnC = "ImageName";
      
      /*** Phisical constants ***/

   
      const phisicalTB_IMAGESC = "TB_IMAGES";
      const phisicalTB_IMAGESIdColumnC = "Id";
      const phisicalTB_IMAGESPathColumnC = "Path";
      const phisicalTB_IMAGESDescriptionColumnC = "Description";
      const phisicalTB_IMAGESNameColumnC = "Name";

   
      const phisicalTB_COLLECTIONC = "TB_COLLECTION";
      const phisicalTB_COLLECTIONIdColumnC = "Id";
      const phisicalTB_COLLECTIONNameColumnC = "Name";

   
      const phisicalTB_COLLECTION_IMAGESC = "TB_COLLECTION_IMAGES";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_ModelsByCollectionTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CollectionIdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CollectionNameColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::ImageIdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::ImagePathColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::ImageDescriptionColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::ImageNameColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::ImageIdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_IMAGESC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_IMAGESC ,
            self::phisicalTB_IMAGESIdColumnC ,
            self::ImageIdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_IMAGESC ,
            self::phisicalTB_IMAGESPathColumnC ,
            self::ImagePathColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_IMAGESC ,
            self::phisicalTB_IMAGESDescriptionColumnC ,
            self::ImageDescriptionColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_IMAGESC ,
            self::phisicalTB_IMAGESNameColumnC ,
            self::ImageNameColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addKey(self::phisicalTB_IMAGESC,
            self::phisicalTB_IMAGESIdColumnC );
      
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
      
      $this->tableMappingM->addTable(self::phisicalTB_COLLECTION_IMAGESC);

      $this->tableMappingM->addCondition("TB_COLLECTION.Id = TB_COLLECTION_IMAGES.Id_Collection");

      $this->tableMappingM->addCondition("TB_IMAGES.Id = TB_COLLECTION_IMAGES.Id_Image");

      $this->tableMappingM->addCondition("TB_IMAGES.Type = 3");
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theCollectionId
                              ,$theCollectionName
                              ,$theImagePath
                              ,$theImageDescription
                              ,$theImageName
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::CollectionIdColumnC] = $theCollectionId;
         $arrayData[self::CollectionNameColumnC] = $theCollectionName;
         $arrayData[self::ImagePathColumnC] = $theImagePath;
         $arrayData[self::ImageDescriptionColumnC] = $theImageDescription;
         $arrayData[self::ImageNameColumnC] = $theImageName;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getCollectionId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::CollectionIdColumnC);
      }
      
      public function setCollectionId($CollectionId){
         $this->loggerM->trace("Enter");
         $this->set(self::CollectionIdColumnC, $CollectionId);
         $this->loggerM->trace("Exit");
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
      public function getImageId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::ImageIdColumnC);
      }
      
      public function getImagePath(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::ImagePathColumnC);
      }
      
      public function setImagePath($ImagePath){
         $this->loggerM->trace("Enter");
         $this->set(self::ImagePathColumnC, $ImagePath);
         $this->loggerM->trace("Exit");
      }
      public function getImageDescription(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::ImageDescriptionColumnC);
      }
      
      public function setImageDescription($ImageDescription){
         $this->loggerM->trace("Enter");
         $this->set(self::ImageDescriptionColumnC, $ImageDescription);
         $this->loggerM->trace("Exit");
      }
      public function getImageName(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::ImageNameColumnC);
      }
      
      public function setImageName($ImageName){
         $this->loggerM->trace("Enter");
         $this->set(self::ImageNameColumnC, $ImageName);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_ModelsByCollectionTableC;
      }
   }
?>
