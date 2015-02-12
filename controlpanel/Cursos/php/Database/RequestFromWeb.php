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

   /*** Definition of the global variables and constants ***/
   /**
    * Object for write the log in a file
    */

   $logger = null;

   $COMMAND = "command";
   $PARAMS = "paramsCommand";
   $PARAM_TABLE = "Table";
   $PARAM_ROWS = "rows";
   $PARAM_DATA = "data";
   $COMMAND_INSERT = "I";
   $COMMAND_UPDATE = "U";
   $PARAM_KEY = "key";


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
      $logger->trace("Exit");
      return  $returnedTable;
   }

   function updateData($theTable, $theRows){
      global $logger;
      global $PARAM_KEY;

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
            }

            $logger->trace("Update the data in the database");
            $theTable->updateRow();
         }else{
            $logger->trace("The Key has not been found.");
         }
      }
   }

   function insertData($theTable, $theData){
      global $logger;
      $logger->trace("Enter");
      $logger->trace("Insert data: [ ".json_encode($theData)." ]");
      $logger->trace("Into [ " . $theTable->getTableName() ." ]");
            if (strcmp($theTable->getTableName(),TB_Configuration::TB_ConfigurationTableC) == 0){
               //Declare variables
               $varValue = $theData["Value"];
               $varDescription = $theData["Description"];
               $varLabel = $theData["Label"];

               $theTable->insert($varValue
                                ,$varDescription
                                ,$varLabel
                                );
            }
            if (strcmp($theTable->getTableName(),TB_Level::TB_LevelTableC) == 0){
               //Declare variables
               $varLevel = $theData["Level"];

               $theTable->insert($varLevel
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

               $theTable->insert($varName
                                ,$varDescription
                                ,$varImage
                                ,$varDuration
                                ,$varPrice
                                ,$varLevelId
                                ,$varLevel
                                );
            }
      $logger->trace("Exit");
   }

   
   /******************* MAIN *********************************/

  
   if (count($_POST) > 0){
      $logger = LoggerMgr::Instance()->getLogger("RequestFromWeb.php");
   

      $logger->info("A request has been received from web");
      $resultArray = array();
      if (!isset ($_POST[$COMMAND]) || ! isset ($_POST[$PARAMS])){
         $resultArray['ResultCode'] = "500";
         $resultArray['MsgError'] = "Unmatched format request. Absence of param $COMMAND or $PARAMS";
         $logger->error(json_encode($resultArray));
         //$logger->error("Unmatched format request. Absence of param $COMMAND or $PARAMS");
            //print("ERROR 500. Unmatched format request. Absence of param $COMMAND or $PARAMS");
         
      }else{
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
            updateData($table, $params[$PARAM_ROWS]);
         }
         if (strcmp(strtoupper($strCommand), $COMMAND_INSERT) == 0){
            $logger->debug("It is a insert command in table [ ". $table->getTableName() . " ]");
            insertData($table, $params[$PARAM_DATA]);
         }
         $logger->trace("The request has been processed");
         $resultArray['ResultCode'] = "200";
         
      }
      print(json_encode($resultArray));
   } 
   
?>