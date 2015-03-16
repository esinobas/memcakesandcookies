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

   class TB_Curse_Step extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_Curse_StepTableC = "TB_Curse_Step";

 
     /*
      * Contants table columns
      */
     const IdColumnC = "Id";
     const TitleColumnC = "Title";
     const HtmlColumnC = "Html";
     const Curse_IdColumnC = "Curse_Id";
     const CurseNameColumnC = "CurseName";
     const CurseDescriptionColumnC = "CurseDescription";
     const CurseImageColumnC = "CurseImage";
     const CurseDurationColumnC = "CurseDuration";
     const CursePriceColumnC = "CursePrice";
     const CursePublicColumnC = "CursePublic";
     const CurseLevelIdColumnC = "CurseLevelId";
     const CurseLevelColumnC = "CurseLevel";
      
      /*** Phisical constants ***/

   
      const phisicalTB_CursoC = "TB_Curso";
      const phisicalTB_CursoNameColumnC = "Name";
      const phisicalTB_CursoDescriptionColumnC = "Description";
      const phisicalTB_CursoImageColumnC = "Image";
      const phisicalTB_CursoDurationColumnC = "Duration";
      const phisicalTB_CursoPriceColumnC = "Price";
      const phisicalTB_CursoLevel_IdColumnC = "Level_Id";
      const phisicalTB_CursoPublicColumnC = "Public";

   
      const phisicalTB_LevelC = "TB_Level";
      const phisicalTB_LevelLevelColumnC = "Level";

   
      const phisicalTB_StepC = "TB_Step";
      const phisicalTB_StepIdColumnC = "Id";
      const phisicalTB_StepTitleColumnC = "Title";
      const phisicalTB_StepHtmlColumnC = "Html";
      const phisicalTB_StepCurso_IdColumnC = "Curso_Id";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_Curse_StepTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::IdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::TitleColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::HtmlColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::Curse_IdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CurseNameColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CurseDescriptionColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CurseImageColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CurseDurationColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CursePriceColumnC,ColumnType::floatC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CursePublicColumnC,ColumnType::booleanC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CurseLevelIdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::CurseLevelColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::IdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_CursoC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoNameColumnC ,
            self::CurseNameColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoDescriptionColumnC ,
            self::CurseDescriptionColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoImageColumnC ,
            self::CurseImageColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoDurationColumnC ,
            self::CurseDurationColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoPriceColumnC ,
            self::CursePriceColumnC,
            ColumnType::floatC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoLevel_IdColumnC ,
            self::CurseLevelIdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_CursoC ,
            self::phisicalTB_CursoPublicColumnC ,
            self::CursePublicColumnC,
            ColumnType::booleanC);
      
      $this->tableMappingM->addTable(self::phisicalTB_LevelC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_LevelC ,
            self::phisicalTB_LevelLevelColumnC ,
            self::CurseLevelColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addTable(self::phisicalTB_StepC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_StepC ,
            self::phisicalTB_StepIdColumnC ,
            self::IdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_StepC ,
            self::phisicalTB_StepTitleColumnC ,
            self::TitleColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_StepC ,
            self::phisicalTB_StepHtmlColumnC ,
            self::HtmlColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_StepC ,
            self::phisicalTB_StepCurso_IdColumnC ,
            self::Curse_IdColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addKey(self::phisicalTB_StepC,
            self::phisicalTB_StepIdColumnC );

      $this->tableMappingM->addCondition("TB_Curso.Id = TB_Step.Curso_Id");

      $this->tableMappingM->addCondition("TB_Curso.Level_Id = TB_Level.Id");
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theTitle
                              ,$theHtml
                              ,$theCurse_Id
                              ,$theCurseName
                              ,$theCurseDescription
                              ,$theCurseImage
                              ,$theCurseDuration
                              ,$theCursePrice
                              ,$theCursePublic
                              ,$theCurseLevelId
                              ,$theCurseLevel
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::TitleColumnC] = $theTitle;
         $arrayData[self::HtmlColumnC] = $theHtml;
         $arrayData[self::Curse_IdColumnC] = $theCurse_Id;
         $arrayData[self::CurseNameColumnC] = $theCurseName;
         $arrayData[self::CurseDescriptionColumnC] = $theCurseDescription;
         $arrayData[self::CurseImageColumnC] = $theCurseImage;
         $arrayData[self::CurseDurationColumnC] = $theCurseDuration;
         $arrayData[self::CursePriceColumnC] = $theCursePrice;
         $arrayData[self::CursePublicColumnC] = $theCursePublic;
         $arrayData[self::CurseLevelIdColumnC] = $theCurseLevelId;
         $arrayData[self::CurseLevelColumnC] = $theCurseLevel;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::IdColumnC);
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
      public function getHtml(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::HtmlColumnC);
      }
      
      public function setHtml($Html){
         $this->loggerM->trace("Enter");
         $this->set(self::HtmlColumnC, $Html);
         $this->loggerM->trace("Exit");
      }
      public function getCurse_Id(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::Curse_IdColumnC);
      }
      
      public function setCurse_Id($Curse_Id){
         $this->loggerM->trace("Enter");
         $this->set(self::Curse_IdColumnC, $Curse_Id);
         $this->loggerM->trace("Exit");
      }
      public function getCurseName(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::CurseNameColumnC);
      }
      
      public function setCurseName($CurseName){
         $this->loggerM->trace("Enter");
         $this->set(self::CurseNameColumnC, $CurseName);
         $this->loggerM->trace("Exit");
      }
      public function getCurseDescription(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::CurseDescriptionColumnC);
      }
      
      public function setCurseDescription($CurseDescription){
         $this->loggerM->trace("Enter");
         $this->set(self::CurseDescriptionColumnC, $CurseDescription);
         $this->loggerM->trace("Exit");
      }
      public function getCurseImage(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::CurseImageColumnC);
      }
      
      public function setCurseImage($CurseImage){
         $this->loggerM->trace("Enter");
         $this->set(self::CurseImageColumnC, $CurseImage);
         $this->loggerM->trace("Exit");
      }
      public function getCurseDuration(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::CurseDurationColumnC);
      }
      
      public function setCurseDuration($CurseDuration){
         $this->loggerM->trace("Enter");
         $this->set(self::CurseDurationColumnC, $CurseDuration);
         $this->loggerM->trace("Exit");
      }
      public function getCursePrice(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::CursePriceColumnC);
      }
      
      public function setCursePrice($CursePrice){
         $this->loggerM->trace("Enter");
         $this->set(self::CursePriceColumnC, $CursePrice);
         $this->loggerM->trace("Exit");
      }
      public function getCursePublic(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::CursePublicColumnC);
      }
      
      public function setCursePublic($CursePublic){
         $this->loggerM->trace("Enter");
         $this->set(self::CursePublicColumnC, $CursePublic);
         $this->loggerM->trace("Exit");
      }
      public function getCurseLevelId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::CurseLevelIdColumnC);
      }
      
      public function setCurseLevelId($CurseLevelId){
         $this->loggerM->trace("Enter");
         $this->set(self::CurseLevelIdColumnC, $CurseLevelId);
         $this->loggerM->trace("Exit");
      }
      public function getCurseLevel(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::CurseLevelColumnC);
      }
      
      public function setCurseLevel($CurseLevel){
         $this->loggerM->trace("Enter");
         $this->set(self::CurseLevelColumnC, $CurseLevel);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_Curse_StepTableC;
      }
   }