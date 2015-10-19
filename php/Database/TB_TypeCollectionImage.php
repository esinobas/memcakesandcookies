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

   class TB_TypeCollectionImage extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_TypeCollectionImageTableC = "TB_TypeCollectionImage";

 
     /*
      * Contants table columns
      */
     const TypeIdColumnC = "TypeId";
     const TypeNameColumnC = "TypeName";
     const CollectionIdColumnC = "CollectionId";
     const CollectionNameColumnC = "CollectionName";
     const CollectionMenuIdColumnC = "CollectionMenuId";
     const ImagePathColumnC = "ImagePath";
     const ImageNameColumnC = "ImageName";
     const ImageDescriptionColumnC = "ImageDescription";
      
      /*** Phisical constants ***/

   
      const phisicalTB_TYPESC = "TB_TYPES";
      const phisicalTB_TYPESIDColumnC = "ID";
      const phisicalTB_TYPESTYPEColumnC = "TYPE";

   
      const phisicalTB_COLLECTIONC = "TB_COLLECTION";
      const phisicalTB_COLLECTIONIdColumnC = "Id";
      const phisicalTB_COLLECTIONNameColumnC = "Name";
      const phisicalTB_COLLECTIONId_MenuColumnC = "Id_Menu";

   
      const phisicalTB_IMAGES_COLLECTIONC = "TB_IMAGES_COLLECTION";
      const phisicalTB_IMAGES_COLLECTIONPathColumnC = "Path";
      const phisicalTB_IMAGES_COLLECTIONNameColumnC = "Name";
      const phisicalTB_IMAGES_COLLECTIONDescriptionColumnC = "Description";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_TypeCollectionImageTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::TypeIdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::TypeNameColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CollectionIdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CollectionNameColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CollectionMenuIdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::ImagePathColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::ImageNameColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::ImageDescriptionColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::ImagePathColumnC);
		$this->tableDefinitionM->addKey(self::ImageNameColumnC);
		$this->tableDefinitionM->addKey(self::CollectionIdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_TYPESC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_TYPESC ,
            self::phisicalTB_TYPESIDColumnC ,
            self::TypeIdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_TYPESC ,
            self::phisicalTB_TYPESTYPEColumnC ,
            self::TypeNameColumnC,
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
            self::CollectionMenuIdColumnC,
            ColumnType::integerC);
      
      $this->tableMappingM->addTable(self::phisicalTB_IMAGES_COLLECTIONC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_IMAGES_COLLECTIONC ,
            self::phisicalTB_IMAGES_COLLECTIONPathColumnC ,
            self::ImagePathColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_IMAGES_COLLECTIONC ,
            self::phisicalTB_IMAGES_COLLECTIONNameColumnC ,
            self::ImageNameColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_IMAGES_COLLECTIONC ,
            self::phisicalTB_IMAGES_COLLECTIONDescriptionColumnC ,
            self::ImageDescriptionColumnC,
            ColumnType::stringC);

      $this->tableMappingM->addCondition("TB_TYPES.Id = TB_IMAGES_COLLECTION.TypeId");

      $this->tableMappingM->addCondition("TB_COLLECTION.Id = TB_IMAGES_COLLECTION.Collection.Id");
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theTypeId
                              ,$theTypeName
                              ,$theCollectionId
                              ,$theCollectionName
                              ,$theCollectionMenuId
                              ,$theImageName
                              ,$theImageDescription
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::TypeIdColumnC] = $theTypeId;
         $arrayData[self::TypeNameColumnC] = $theTypeName;
         $arrayData[self::CollectionIdColumnC] = $theCollectionId;
         $arrayData[self::CollectionNameColumnC] = $theCollectionName;
         $arrayData[self::CollectionMenuIdColumnC] = $theCollectionMenuId;
         $arrayData[self::ImageNameColumnC] = $theImageName;
         $arrayData[self::ImageDescriptionColumnC] = $theImageDescription;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getTypeId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::TypeIdColumnC);
      }
      
      public function setTypeId($TypeId){
         $this->loggerM->trace("Enter");
         $this->set(self::TypeIdColumnC, $TypeId);
         $this->loggerM->trace("Exit");
      }
      public function getTypeName(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::TypeNameColumnC);
      }
      
      public function setTypeName($TypeName){
         $this->loggerM->trace("Enter");
         $this->set(self::TypeNameColumnC, $TypeName);
         $this->loggerM->trace("Exit");
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
      public function getCollectionMenuId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::CollectionMenuIdColumnC);
      }
      
      public function setCollectionMenuId($CollectionMenuId){
         $this->loggerM->trace("Enter");
         $this->set(self::CollectionMenuIdColumnC, $CollectionMenuId);
         $this->loggerM->trace("Exit");
      }
      public function getImagePath(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::ImagePathColumnC);
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
      public function getImageDescription(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::ImageDescriptionColumnC);
      }
      
      public function setImageDescription($ImageDescription){
         $this->loggerM->trace("Enter");
         $this->set(self::ImageDescriptionColumnC, $ImageDescription);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_TypeCollectionImageTableC;
      }
   }
?>
