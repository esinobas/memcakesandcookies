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

   class TB_Curso extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_CursoTableC = "TB_Curso";

 
     /*
      * Contants table columns
      */
     const IdColumnC = "Id";
     const NameColumnC = "Name";
     const DescriptionColumnC = "Description";
     const ImageColumnC = "Image";
     const DurationColumnC = "Duration";
     const PriceColumnC = "Price";
     const LevelIdColumnC = "LevelId";
     const LevelColumnC = "Level";
      
      /*** Phisical constants ***/

   
      const phisicalTB_LevelC = "TB_Level";
      const phisicalTB_LevelLevelColumnC = "Level";

   
      const phisicalTB_CursoC = "TB_Curso";
      const phisicalTB_CursoIdColumnC = "Id";
      const phisicalTB_CursoNameColumnC = "Name";
      const phisicalTB_CursoDescriptionColumnC = "Description";
      const phisicalTB_CursoImageColumnC = "Image";
      const phisicalTB_CursoDurationColumnC = "Duration";
      const phisicalTB_CursoPriceColumnC = "Price";
      const phisicalTB_CursoLevel_IdColumnC = "Level_Id";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_CursoTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::IdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::NameColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::DescriptionColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::ImageColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::DurationColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::PriceColumnC,ColumnType::floatC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::LevelIdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::LevelColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::IdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_LevelC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_LevelC ,
            self::phisicalTB_LevelLevelColumnC ,
            self::LevelColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addTable(self::phisicalTB_CursoC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoIdColumnC ,
            self::IdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoNameColumnC ,
            self::NameColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoDescriptionColumnC ,
            self::DescriptionColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoImageColumnC ,
            self::ImageColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoDurationColumnC ,
            self::DurationColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoPriceColumnC ,
            self::PriceColumnC,
            ColumnType::floatC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoLevel_IdColumnC ,
            self::LevelIdColumnC,
            ColumnType::integerC);
      
      $this->tableMappingM->addKey(self::phisicalTB_CursoC,
            self::phisicalTB_CursoIdColumnC );

      $this->tableMappingM->addCondition("TB_Curso.Level_Id = TB_Level.Id");
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theName
                              ,$theDescription
                              ,$theImage
                              ,$theDuration
                              ,$thePrice
                              ,$theLevelId
                              ,$theLevel
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::NameColumnC] = $theName;
         $arrayData[self::DescriptionColumnC] = $theDescription;
         $arrayData[self::ImageColumnC] = $theImage;
         $arrayData[self::DurationColumnC] = $theDuration;
         $arrayData[self::PriceColumnC] = $thePrice;
         $arrayData[self::LevelIdColumnC] = $theLevelId;
         $arrayData[self::LevelColumnC] = $theLevel;
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
      public function getDescription(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::DescriptionColumnC);
      }
      
      public function setDescription($Description){
         $this->loggerM->trace("Enter");
         $this->set(self::DescriptionColumnC, $Description);
         $this->loggerM->trace("Exit");
      }
      public function getImage(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::ImageColumnC);
      }
      
      public function setImage($Image){
         $this->loggerM->trace("Enter");
         $this->set(self::ImageColumnC, $Image);
         $this->loggerM->trace("Exit");
      }
      public function getDuration(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::DurationColumnC);
      }
      
      public function setDuration($Duration){
         $this->loggerM->trace("Enter");
         $this->set(self::DurationColumnC, $Duration);
         $this->loggerM->trace("Exit");
      }
      public function getPrice(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::PriceColumnC);
      }
      
      public function setPrice($Price){
         $this->loggerM->trace("Enter");
         $this->set(self::PriceColumnC, $Price);
         $this->loggerM->trace("Exit");
      }
      public function getLevelId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::LevelIdColumnC);
      }
      
      public function setLevelId($LevelId){
         $this->loggerM->trace("Enter");
         $this->set(self::LevelIdColumnC, $LevelId);
         $this->loggerM->trace("Exit");
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
         return self::TB_CursoTableC;
      }
   }