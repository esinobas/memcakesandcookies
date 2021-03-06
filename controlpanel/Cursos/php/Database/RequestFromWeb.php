<?php
   /**
    * File used for receive the request from the web and map the request params
    * in functions
    */

   /****************** INCLUDES ******************************/
   set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'].
                      '/controlpanel/Cursos/php');

   include_once 'LoggerMgr/LoggerMgr.php';
   include_once 'Database/TB_Configuration.php';
   include_once 'Database/TB_Level.php';
   include_once 'Database/TB_Curso.php';
   include_once 'Database/TB_Curse_Step.php';

   /*** Definition of the global variables and constants ***/
   /**
    * Object for write the log in a file
    */

   $logger = null;

   $COMMAND = "command";
   $PARAMS = "paramsCommand";
   $PARAM_TABLE = "Table";
   $PARAM_ROWS = "rows";
   $PARAM_ROW = "row";
   $PARAM_DATA = "data";
   $COMMAND_INSERT = "I";
   $COMMAND_UPDATE = "U";
   $COMMAND_DELETE = "D";
   $PARAM_KEY = "key";
   $RESULT_CODE = "ResultCode";
   $MSG_ERROR = "ErrorMsg";
   $RESULT_CODE_SUCCESS = 200;
   $RESULT_CODE_INTERNAL_ERROR = 500;
   $RETURN_LAST_ID = "lastID";

   /****************** Functions *****************************/

   function getTable($theTableName){
      global $logger;
      $logger->trace("Enter");
      $logger->trace("Create object [ $theTableName ]");
      $returnedTable = null;

      if (strcmp($theTableName, TB_Configuration::TB_ConfigurationTableC) == 0){
         $returnedTable = new TB_Configuration();
      }

      if (strcmp($theTableName, TB_Level::TB_LevelTableC) == 0){
         $returnedTable = new TB_Level();
      }

      if (strcmp($theTableName, TB_Curso::TB_CursoTableC) == 0){
         $returnedTable = new TB_Curso();
      }

      if (strcmp($theTableName, TB_Curse_Step::TB_Curse_StepTableC) == 0){
         $returnedTable = new TB_Curse_Step();
      }
      $logger->trace("Exit");
      return  $returnedTable;
   }

   function updateData($theTable, $theRows, &$theResult){
      global $logger;
      global $PARAM_KEY;

      global $RESULT_CODE;
      global $MSG_ERROR;
      global $RESULT_CODE_SUCCESS;
      global $RESULT_CODE_INTERNAL_ERROR;
      $logger->trace("Enter");
      $logger->trace("Rows: [ ".json_encode($theRows)." ]");
      $logger->trace("Update data of [ " . $theTable->getTableName() ." ]");
      foreach ( $theRows as $row){
         $key = $row[$PARAM_KEY];
         $logger->trace("Search by [ $key ]");
         if ( $theTable->searchByKey($key)){
            $logger->trace("The Key has been found.");
            if (strcmp($theTable->getTableName(),TB_Configuration::TB_ConfigurationTableC) == 0){
               if (isset($row[TB_Configuration::ValueColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Configuration::ValueColumnC ." ] -> [ ".
                             $row[TB_Configuration::ValueColumnC] ." ]");
                  $theTable->setValue($row[TB_Configuration::ValueColumnC ]);
                }
               if (isset($row[TB_Configuration::DescriptionColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Configuration::DescriptionColumnC ." ] -> [ ".
                             $row[TB_Configuration::DescriptionColumnC] ." ]");
                  $theTable->setDescription($row[TB_Configuration::DescriptionColumnC ]);
                }
               if (isset($row[TB_Configuration::LabelColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Configuration::LabelColumnC ." ] -> [ ".
                             $row[TB_Configuration::LabelColumnC] ." ]");
                  $theTable->setLabel($row[TB_Configuration::LabelColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_Level::TB_LevelTableC) == 0){
               if (isset($row[TB_Level::LevelColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Level::LevelColumnC ." ] -> [ ".
                             $row[TB_Level::LevelColumnC] ." ]");
                  $theTable->setLevel($row[TB_Level::LevelColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_Curso::TB_CursoTableC) == 0){
               if (isset($row[TB_Curso::NameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curso::NameColumnC ." ] -> [ ".
                             $row[TB_Curso::NameColumnC] ." ]");
                  $theTable->setName($row[TB_Curso::NameColumnC ]);
                }
               if (isset($row[TB_Curso::DescriptionColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curso::DescriptionColumnC ." ] -> [ ".
                             $row[TB_Curso::DescriptionColumnC] ." ]");
                  $theTable->setDescription($row[TB_Curso::DescriptionColumnC ]);
                }
               if (isset($row[TB_Curso::ImageColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curso::ImageColumnC ." ] -> [ ".
                             $row[TB_Curso::ImageColumnC] ." ]");
                  $theTable->setImage($row[TB_Curso::ImageColumnC ]);
                }
               if (isset($row[TB_Curso::DurationColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curso::DurationColumnC ." ] -> [ ".
                             $row[TB_Curso::DurationColumnC] ." ]");
                  $theTable->setDuration($row[TB_Curso::DurationColumnC ]);
                }
               if (isset($row[TB_Curso::PriceColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curso::PriceColumnC ." ] -> [ ".
                             $row[TB_Curso::PriceColumnC] ." ]");
                  $theTable->setPrice($row[TB_Curso::PriceColumnC ]);
                }
               if (isset($row[TB_Curso::LevelIdColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curso::LevelIdColumnC ." ] -> [ ".
                             $row[TB_Curso::LevelIdColumnC] ." ]");
                  $theTable->setLevelId($row[TB_Curso::LevelIdColumnC ]);
                }
               if (isset($row[TB_Curso::LevelColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curso::LevelColumnC ." ] -> [ ".
                             $row[TB_Curso::LevelColumnC] ." ]");
                  $theTable->setLevel($row[TB_Curso::LevelColumnC ]);
                }
               if (isset($row[TB_Curso::PublicColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curso::PublicColumnC ." ] -> [ ".
                             $row[TB_Curso::PublicColumnC] ." ]");
                  $theTable->setPublic($row[TB_Curso::PublicColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_Curse_Step::TB_Curse_StepTableC) == 0){
               if (isset($row[TB_Curse_Step::TitleColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curse_Step::TitleColumnC ." ] -> [ ".
                             $row[TB_Curse_Step::TitleColumnC] ." ]");
                  $theTable->setTitle($row[TB_Curse_Step::TitleColumnC ]);
                }
               if (isset($row[TB_Curse_Step::HtmlColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curse_Step::HtmlColumnC ." ] -> [ ".
                             $row[TB_Curse_Step::HtmlColumnC] ." ]");
                  $theTable->setHtml($row[TB_Curse_Step::HtmlColumnC ]);
                }
               if (isset($row[TB_Curse_Step::Curse_IdColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curse_Step::Curse_IdColumnC ." ] -> [ ".
                             $row[TB_Curse_Step::Curse_IdColumnC] ." ]");
                  $theTable->setCurse_Id($row[TB_Curse_Step::Curse_IdColumnC ]);
                }
               if (isset($row[TB_Curse_Step::CurseNameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curse_Step::CurseNameColumnC ." ] -> [ ".
                             $row[TB_Curse_Step::CurseNameColumnC] ." ]");
                  $theTable->setCurseName($row[TB_Curse_Step::CurseNameColumnC ]);
                }
               if (isset($row[TB_Curse_Step::CurseDescriptionColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curse_Step::CurseDescriptionColumnC ." ] -> [ ".
                             $row[TB_Curse_Step::CurseDescriptionColumnC] ." ]");
                  $theTable->setCurseDescription($row[TB_Curse_Step::CurseDescriptionColumnC ]);
                }
               if (isset($row[TB_Curse_Step::CurseImageColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curse_Step::CurseImageColumnC ." ] -> [ ".
                             $row[TB_Curse_Step::CurseImageColumnC] ." ]");
                  $theTable->setCurseImage($row[TB_Curse_Step::CurseImageColumnC ]);
                }
               if (isset($row[TB_Curse_Step::CurseDurationColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curse_Step::CurseDurationColumnC ." ] -> [ ".
                             $row[TB_Curse_Step::CurseDurationColumnC] ." ]");
                  $theTable->setCurseDuration($row[TB_Curse_Step::CurseDurationColumnC ]);
                }
               if (isset($row[TB_Curse_Step::CursePriceColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curse_Step::CursePriceColumnC ." ] -> [ ".
                             $row[TB_Curse_Step::CursePriceColumnC] ." ]");
                  $theTable->setCursePrice($row[TB_Curse_Step::CursePriceColumnC ]);
                }
               if (isset($row[TB_Curse_Step::CursePublicColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curse_Step::CursePublicColumnC ." ] -> [ ".
                             $row[TB_Curse_Step::CursePublicColumnC] ." ]");
                  $theTable->setCursePublic($row[TB_Curse_Step::CursePublicColumnC ]);
                }
               if (isset($row[TB_Curse_Step::CurseLevelIdColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curse_Step::CurseLevelIdColumnC ." ] -> [ ".
                             $row[TB_Curse_Step::CurseLevelIdColumnC] ." ]");
                  $theTable->setCurseLevelId($row[TB_Curse_Step::CurseLevelIdColumnC ]);
                }
               if (isset($row[TB_Curse_Step::CurseLevelColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Curse_Step::CurseLevelColumnC ." ] -> [ ".
                             $row[TB_Curse_Step::CurseLevelColumnC] ." ]");
                  $theTable->setCurseLevel($row[TB_Curse_Step::CurseLevelColumnC ]);
                }
            }

            }else{
               $theResult[$RESULT_CODE] = $RESULT_CODE_INTERNAL_ERROR;
               $theResult[$MSG_ERROR] = "The Key has not been found.";
               $logger->warn($theResult[$MSG_ERROR]);
               break;
            }
         }
         $logger->trace("Update the data in the database");
         if ( ! $theTable->update()){
            $theResult[$RESULT_CODE] = $RESULT_CODE_INTERNAL_ERROR;
            $theResult[$MSG_ERROR] = $theTable->getStrError();
            $logger->error("The update failed. Error [ " . $theResult[$MSG_ERROR] . " ]");
         }
      $logger->trace("Exit");
   }

   function insertData($theTable, $theData, &$theResult){
      global $logger;
      global $RESULT_CODE;
      global $MSG_ERROR;
      global $RESULT_CODE_SUCCESS;
      global $RESULT_CODE_INTERNAL_ERROR;
      global $RETURN_LAST_ID;
      $logger->trace("Enter");
      $logger->trace("Insert data: [ ".json_encode($theData)." ]");
      $logger->trace("Into [ " . $theTable->getTableName() ." ]");

      if (strcmp($theTable->getTableName(),TB_Configuration::TB_ConfigurationTableC) == 0){

         //Declare variables
         $varValue = $theData["Value"];
         $varDescription = $theData["Description"];
         $varLabel = $theData["Label"];

         $newId = $theTable->insert($varValue
                                ,$varDescription
                                ,$varLabel
                                );
      }

      if (strcmp($theTable->getTableName(),TB_Level::TB_LevelTableC) == 0){

         //Declare variables
         $varLevel = $theData["Level"];

         $newId = $theTable->insert($varLevel
                                );
      }

      if (strcmp($theTable->getTableName(),TB_Curso::TB_CursoTableC) == 0){

         //Declare variables
         $varName = $theData["Name"];
         $varDescription = $theData["Description"];
         $varImage = $theData["Image"];
         $varDuration = $theData["Duration"];
         $varPrice = $theData["Price"];
         $varLevelId = $theData["LevelId"];
         $varLevel = $theData["Level"];
         $varPublic = $theData["Public"];

         $newId = $theTable->insert($varName
                                ,$varDescription
                                ,$varImage
                                ,$varDuration
                                ,$varPrice
                                ,$varLevelId
                                ,$varLevel
                                ,$varPublic
                                );
      }

      if (strcmp($theTable->getTableName(),TB_Curse_Step::TB_Curse_StepTableC) == 0){

         //Declare variables
         $varTitle = $theData["Title"];
         $varHtml = $theData["Html"];
         $varCurse_Id = $theData["Curse_Id"];
         $varCurseName = $theData["CurseName"];
         $varCurseDescription = $theData["CurseDescription"];
         $varCurseImage = $theData["CurseImage"];
         $varCurseDuration = $theData["CurseDuration"];
         $varCursePrice = $theData["CursePrice"];
         $varCursePublic = $theData["CursePublic"];
         $varCurseLevelId = $theData["CurseLevelId"];
         $varCurseLevel = $theData["CurseLevel"];

         $newId = $theTable->insert($varTitle
                                ,$varHtml
                                ,$varCurse_Id
                                ,$varCurseName
                                ,$varCurseDescription
                                ,$varCurseImage
                                ,$varCurseDuration
                                ,$varCursePrice
                                ,$varCursePublic
                                ,$varCurseLevelId
                                ,$varCurseLevel
                                );
      }

      if( $newId != -1){
           $logger->trace("The insertion was exectuted successfully. ".
                           "The new Id is [ $newId ]");
           $theResult[$RETURN_LAST_ID]=$newId;
        }else{
           $theResult[$RESULT_CODE] = $RESULT_CODE_INTERNAL_ERROR;
           $theResult[$MSG_ERROR] = $theTable->getStrError();
           $logger->error("The insert failed. Error [ " . $theResult[$MSG_ERROR] . " ]");
        }
      $logger->trace("Exit");
   }

   function delete($theTable, $theData, &$theResult){
      global $logger;
      global $RESULT_CODE;
      global $MSG_ERROR;
      global $RESULT_CODE_SUCCESS;
      global $RESULT_CODE_INTERNAL_ERROR;
      global $PARAM_KEY;
      $logger->trace("Enter");
      $jsonKey = $theData[$PARAM_KEY];
      $logger->trace("Delete from table ".$theTable->getTableName().
                    " with key [ ".json_encode($jsonKey)." ]");

      if (strcmp($theTable->getTableName(),TB_Configuration::TB_ConfigurationTableC) == 0){
         $composedKey = array();
         $composedKey["Property"] = $jsonKey["Property"];
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
         
      }

      if (strcmp($theTable->getTableName(),TB_Level::TB_LevelTableC) == 0){
         $composedKey = array();
         $composedKey["Id"] = $jsonKey["Id"];
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
         
      }

      if (strcmp($theTable->getTableName(),TB_Curso::TB_CursoTableC) == 0){
         $composedKey = array();
         $composedKey["Id"] = $jsonKey["Id"];
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
          
      }

      if (strcmp($theTable->getTableName(),TB_Curse_Step::TB_Curse_StepTableC) == 0){
         $composedKey = array();
         $composedKey["Id"] = $jsonKey["Id"];
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
          
      }
      $logger->trace("Delete data in the database");
      if (! $theTable->delete()){
         $theResult[$RESULT_CODE] = $RESULT_CODE_INTERNAL_ERROR;
         $theResult[$MSG_ERROR] = $theTable->getStrError();
         $logger->error("The delete failed. Error [ " . $theResult[$MSG_ERROR] . " ]");
      }
      $logger->trace("Exit");
   }

   
   /******************* MAIN *********************************/

  
   if (count($_POST) > 0){
      $logger = LoggerMgr::Instance()->getLogger("RequestFromWeb.php");
   

      $logger->info("A request has been received from web");
      $resultArray = array();
      if (!isset ($_POST[$COMMAND]) || ! isset ($_POST[$PARAMS])){
         $resultArray[$RESULT_CODE] = $RESULT_CODE_INTERNAL_ERROR;
         $resultArray[$MSG_ERROR] = "Unmatched format request. Absence of param $COMMAND or $PARAMS";
         $logger->error(json_encode($resultArray));
         //$logger->error("Unmatched format request. Absence of param $COMMAND or $PARAMS");
            //print("ERROR 500. Unmatched format request. Absence of param $COMMAND or $PARAMS");
         
      }else{
         $resultArray[$RESULT_CODE] = $RESULT_CODE_SUCCESS;
         $strCommand = $_POST[$COMMAND];
         $strParams = $_POST[$PARAMS];
         $logger->trace("The command is [ $strCommand ] and the params are [ $strParams ]");
         $params = json_decode($strParams, true);
         $table = getTable($params[$PARAM_TABLE]);
         $logger->trace("The command parameter is [ $strCommand ]");
         $logger->trace("Open the table [ $params[$PARAM_TABLE] ]");
         $table->open();
      
         if (strcmp(strtoupper($strCommand), $COMMAND_UPDATE) == 0){
            $logger->debug("It is a update command in table [ ". $table->getTableName() . " ]");
            updateData($table, $params[$PARAM_ROWS],$resultArray);
         }
         if (strcmp(strtoupper($strCommand), $COMMAND_INSERT) == 0){
            $logger->debug("It is a insert command in table [ ". $table->getTableName() . " ]");
            insertData($table, $params[$PARAM_DATA], $resultArray);
         }
         if (strcmp(strtoupper($strCommand), $COMMAND_DELETE) == 0){
            $logger->debug("It is a delete command in table [ ". $table->getTableName() . " ]");
            delete($table, $params[$PARAM_DATA], $resultArray);
         }
         $logger->trace("The request has been processed. Result [ " . json_encode($resultArray) ." ]");
        
      }
      print(json_encode($resultArray));
   } 
   
?>