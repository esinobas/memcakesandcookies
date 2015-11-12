<?php
   /**
    * File used for receive the request from the web and map the request params
    * in functions
    */

   /****************** INCLUDES ******************************/
   set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'].
                      '/php/');

   include_once 'LoggerMgr/LoggerMgr.php';
   include_once 'Database/TB_Configuration.php';
   include_once 'Database/TB_Menu.php';
   include_once 'Database/TB_SlideImagesHome.php';
   include_once 'Database/TB_ImageType.php';
   include_once 'Database/TB_Users.php';
   include_once 'Database/TB_CookiesByCollection.php';
   include_once 'Database/TB_CakesByCollection.php';
   include_once 'Database/TB_ModelsByCollection.php';
   include_once 'Database/TB_MenuCollection.php';
   include_once 'Database/TB_ImagesAndCollection.php';
   include_once 'Database/TB_TypeCollectionImage.php';
   include_once 'Database/TB_News.php';

   /*** Definition of the global variables and constants ***/
   /**
    * Object for write the log in a file
    */

   $logger = null;

   define(COMMAND, "command");
   define(PARAMS, "paramsCommand");
   define(PARAM_TABLE, "Table");
   define(PARAM_ROWS, "rows");
   define(PARAM_ROW, "row");
   define(PARAM_DATA, "data");
   define(COMMAND_INSERT, "I");
   define(COMMAND_UPDATE, "U");
   define(COMMAND_DELETE, "D");
   define(PARAM_KEY, "key");
   define(RESULT_CODE, "ResultCode");
   define(MSG_ERROR, "ErrorMsg");
   define(RESULT_CODE_SUCCESS, 200);
   define(RESULT_CODE_INTERNAL_ERROR, 500);
   define(RETURN_LAST_ID, "lastID");


   /****************** Functions *****************************/

   function getTable($theTableName){
      global $logger;
      $logger->trace("Enter");
      $logger->trace("Create object [ $theTableName ]");
      $returnedTable = null;

      if (strcmp($theTableName, TB_Configuration::TB_ConfigurationTableC) == 0){
         $returnedTable = new TB_Configuration();
      }

      if (strcmp($theTableName, TB_Menu::TB_MenuTableC) == 0){
         $returnedTable = new TB_Menu();
      }

      if (strcmp($theTableName, TB_SlideImagesHome::TB_SlideImagesHomeTableC) == 0){
         $returnedTable = new TB_SlideImagesHome();
      }

      if (strcmp($theTableName, TB_ImageType::TB_ImageTypeTableC) == 0){
         $returnedTable = new TB_ImageType();
      }

      if (strcmp($theTableName, TB_Users::TB_UsersTableC) == 0){
         $returnedTable = new TB_Users();
      }

      if (strcmp($theTableName, TB_CookiesByCollection::TB_CookiesByCollectionTableC) == 0){
         $returnedTable = new TB_CookiesByCollection();
      }

      if (strcmp($theTableName, TB_CakesByCollection::TB_CakesByCollectionTableC) == 0){
         $returnedTable = new TB_CakesByCollection();
      }

      if (strcmp($theTableName, TB_ModelsByCollection::TB_ModelsByCollectionTableC) == 0){
         $returnedTable = new TB_ModelsByCollection();
      }

      if (strcmp($theTableName, TB_MenuCollection::TB_MenuCollectionTableC) == 0){
         $returnedTable = new TB_MenuCollection();
      }

      if (strcmp($theTableName, TB_ImagesAndCollection::TB_ImagesAndCollectionTableC) == 0){
         $returnedTable = new TB_ImagesAndCollection();
      }

      if (strcmp($theTableName, TB_TypeCollectionImage::TB_TypeCollectionImageTableC) == 0){
         $returnedTable = new TB_TypeCollectionImage();
      }

      if (strcmp($theTableName, TB_News::TB_NewsTableC) == 0){
         $returnedTable = new TB_News();
      }
      $logger->trace("Exit");
      return  $returnedTable;
   }

   function updateData($theTable, $theRows, &$theResult){
      global $logger;
      $logger->trace("Enter");
      $logger->trace("Rows: [ ".json_encode($theRows)." ]");
      $logger->trace("Update data of [ " . $theTable->getTableName() ." ]");
      foreach ( $theRows as $row){
         $key = $row[PARAM_KEY];
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
               if (isset($row[TB_Configuration::DataTypeColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Configuration::DataTypeColumnC ." ] -> [ ".
                             $row[TB_Configuration::DataTypeColumnC] ." ]");
                  $theTable->setDataType($row[TB_Configuration::DataTypeColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_Menu::TB_MenuTableC) == 0){
               if (isset($row[TB_Menu::OptionColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Menu::OptionColumnC ." ] -> [ ".
                             $row[TB_Menu::OptionColumnC] ." ]");
                  $theTable->setOption($row[TB_Menu::OptionColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_SlideImagesHome::TB_SlideImagesHomeTableC) == 0){
               if (isset($row[TB_SlideImagesHome::PathColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_SlideImagesHome::PathColumnC ." ] -> [ ".
                             $row[TB_SlideImagesHome::PathColumnC] ." ]");
                  $theTable->setPath($row[TB_SlideImagesHome::PathColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_ImageType::TB_ImageTypeTableC) == 0){
               if (isset($row[TB_ImageType::TypeColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_ImageType::TypeColumnC ." ] -> [ ".
                             $row[TB_ImageType::TypeColumnC] ." ]");
                  $theTable->setType($row[TB_ImageType::TypeColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_Users::TB_UsersTableC) == 0){
               if (isset($row[TB_Users::NameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Users::NameColumnC ." ] -> [ ".
                             $row[TB_Users::NameColumnC] ." ]");
                  $theTable->setName($row[TB_Users::NameColumnC ]);
                }
               if (isset($row[TB_Users::EmailColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Users::EmailColumnC ." ] -> [ ".
                             $row[TB_Users::EmailColumnC] ." ]");
                  $theTable->setEmail($row[TB_Users::EmailColumnC ]);
                }
               if (isset($row[TB_Users::PasswordColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Users::PasswordColumnC ." ] -> [ ".
                             $row[TB_Users::PasswordColumnC] ." ]");
                  $theTable->setPassword($row[TB_Users::PasswordColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_CookiesByCollection::TB_CookiesByCollectionTableC) == 0){
               if (isset($row[TB_CookiesByCollection::CollectionIdColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_CookiesByCollection::CollectionIdColumnC ." ] -> [ ".
                             $row[TB_CookiesByCollection::CollectionIdColumnC] ." ]");
                  $theTable->setCollectionId($row[TB_CookiesByCollection::CollectionIdColumnC ]);
                }
               if (isset($row[TB_CookiesByCollection::CollectionNameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_CookiesByCollection::CollectionNameColumnC ." ] -> [ ".
                             $row[TB_CookiesByCollection::CollectionNameColumnC] ." ]");
                  $theTable->setCollectionName($row[TB_CookiesByCollection::CollectionNameColumnC ]);
                }
               if (isset($row[TB_CookiesByCollection::ImagePathColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_CookiesByCollection::ImagePathColumnC ." ] -> [ ".
                             $row[TB_CookiesByCollection::ImagePathColumnC] ." ]");
                  $theTable->setImagePath($row[TB_CookiesByCollection::ImagePathColumnC ]);
                }
               if (isset($row[TB_CookiesByCollection::ImageDescriptionColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_CookiesByCollection::ImageDescriptionColumnC ." ] -> [ ".
                             $row[TB_CookiesByCollection::ImageDescriptionColumnC] ." ]");
                  $theTable->setImageDescription($row[TB_CookiesByCollection::ImageDescriptionColumnC ]);
                }
               if (isset($row[TB_CookiesByCollection::ImageNameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_CookiesByCollection::ImageNameColumnC ." ] -> [ ".
                             $row[TB_CookiesByCollection::ImageNameColumnC] ." ]");
                  $theTable->setImageName($row[TB_CookiesByCollection::ImageNameColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_CakesByCollection::TB_CakesByCollectionTableC) == 0){
               if (isset($row[TB_CakesByCollection::CollectionIdColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_CakesByCollection::CollectionIdColumnC ." ] -> [ ".
                             $row[TB_CakesByCollection::CollectionIdColumnC] ." ]");
                  $theTable->setCollectionId($row[TB_CakesByCollection::CollectionIdColumnC ]);
                }
               if (isset($row[TB_CakesByCollection::CollectionNameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_CakesByCollection::CollectionNameColumnC ." ] -> [ ".
                             $row[TB_CakesByCollection::CollectionNameColumnC] ." ]");
                  $theTable->setCollectionName($row[TB_CakesByCollection::CollectionNameColumnC ]);
                }
               if (isset($row[TB_CakesByCollection::ImagePathColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_CakesByCollection::ImagePathColumnC ." ] -> [ ".
                             $row[TB_CakesByCollection::ImagePathColumnC] ." ]");
                  $theTable->setImagePath($row[TB_CakesByCollection::ImagePathColumnC ]);
                }
               if (isset($row[TB_CakesByCollection::ImageDescriptionColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_CakesByCollection::ImageDescriptionColumnC ." ] -> [ ".
                             $row[TB_CakesByCollection::ImageDescriptionColumnC] ." ]");
                  $theTable->setImageDescription($row[TB_CakesByCollection::ImageDescriptionColumnC ]);
                }
               if (isset($row[TB_CakesByCollection::ImageNameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_CakesByCollection::ImageNameColumnC ." ] -> [ ".
                             $row[TB_CakesByCollection::ImageNameColumnC] ." ]");
                  $theTable->setImageName($row[TB_CakesByCollection::ImageNameColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_ModelsByCollection::TB_ModelsByCollectionTableC) == 0){
               if (isset($row[TB_ModelsByCollection::CollectionIdColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_ModelsByCollection::CollectionIdColumnC ." ] -> [ ".
                             $row[TB_ModelsByCollection::CollectionIdColumnC] ." ]");
                  $theTable->setCollectionId($row[TB_ModelsByCollection::CollectionIdColumnC ]);
                }
               if (isset($row[TB_ModelsByCollection::CollectionNameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_ModelsByCollection::CollectionNameColumnC ." ] -> [ ".
                             $row[TB_ModelsByCollection::CollectionNameColumnC] ." ]");
                  $theTable->setCollectionName($row[TB_ModelsByCollection::CollectionNameColumnC ]);
                }
               if (isset($row[TB_ModelsByCollection::ImagePathColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_ModelsByCollection::ImagePathColumnC ." ] -> [ ".
                             $row[TB_ModelsByCollection::ImagePathColumnC] ." ]");
                  $theTable->setImagePath($row[TB_ModelsByCollection::ImagePathColumnC ]);
                }
               if (isset($row[TB_ModelsByCollection::ImageDescriptionColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_ModelsByCollection::ImageDescriptionColumnC ." ] -> [ ".
                             $row[TB_ModelsByCollection::ImageDescriptionColumnC] ." ]");
                  $theTable->setImageDescription($row[TB_ModelsByCollection::ImageDescriptionColumnC ]);
                }
               if (isset($row[TB_ModelsByCollection::ImageNameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_ModelsByCollection::ImageNameColumnC ." ] -> [ ".
                             $row[TB_ModelsByCollection::ImageNameColumnC] ." ]");
                  $theTable->setImageName($row[TB_ModelsByCollection::ImageNameColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_MenuCollection::TB_MenuCollectionTableC) == 0){
               if (isset($row[TB_MenuCollection::MenuIdColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_MenuCollection::MenuIdColumnC ." ] -> [ ".
                             $row[TB_MenuCollection::MenuIdColumnC] ." ]");
                  $theTable->setMenuId($row[TB_MenuCollection::MenuIdColumnC ]);
                }
               if (isset($row[TB_MenuCollection::MenuOptionColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_MenuCollection::MenuOptionColumnC ." ] -> [ ".
                             $row[TB_MenuCollection::MenuOptionColumnC] ." ]");
                  $theTable->setMenuOption($row[TB_MenuCollection::MenuOptionColumnC ]);
                }
               if (isset($row[TB_MenuCollection::CollectionNameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_MenuCollection::CollectionNameColumnC ." ] -> [ ".
                             $row[TB_MenuCollection::CollectionNameColumnC] ." ]");
                  $theTable->setCollectionName($row[TB_MenuCollection::CollectionNameColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_ImagesAndCollection::TB_ImagesAndCollectionTableC) == 0){
               if (isset($row[TB_ImagesAndCollection::CollectionIdColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_ImagesAndCollection::CollectionIdColumnC ." ] -> [ ".
                             $row[TB_ImagesAndCollection::CollectionIdColumnC] ." ]");
                  $theTable->setCollectionId($row[TB_ImagesAndCollection::CollectionIdColumnC ]);
                }
               if (isset($row[TB_ImagesAndCollection::CollectionNameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_ImagesAndCollection::CollectionNameColumnC ." ] -> [ ".
                             $row[TB_ImagesAndCollection::CollectionNameColumnC] ." ]");
                  $theTable->setCollectionName($row[TB_ImagesAndCollection::CollectionNameColumnC ]);
                }
               if (isset($row[TB_ImagesAndCollection::CollectionMenuIdColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_ImagesAndCollection::CollectionMenuIdColumnC ." ] -> [ ".
                             $row[TB_ImagesAndCollection::CollectionMenuIdColumnC] ." ]");
                  $theTable->setCollectionMenuId($row[TB_ImagesAndCollection::CollectionMenuIdColumnC ]);
                }
               if (isset($row[TB_ImagesAndCollection::ImagePathColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_ImagesAndCollection::ImagePathColumnC ." ] -> [ ".
                             $row[TB_ImagesAndCollection::ImagePathColumnC] ." ]");
                  $theTable->setImagePath($row[TB_ImagesAndCollection::ImagePathColumnC ]);
                }
               if (isset($row[TB_ImagesAndCollection::ImageDescriptionColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_ImagesAndCollection::ImageDescriptionColumnC ." ] -> [ ".
                             $row[TB_ImagesAndCollection::ImageDescriptionColumnC] ." ]");
                  $theTable->setImageDescription($row[TB_ImagesAndCollection::ImageDescriptionColumnC ]);
                }
               if (isset($row[TB_ImagesAndCollection::ImageNameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_ImagesAndCollection::ImageNameColumnC ." ] -> [ ".
                             $row[TB_ImagesAndCollection::ImageNameColumnC] ." ]");
                  $theTable->setImageName($row[TB_ImagesAndCollection::ImageNameColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_TypeCollectionImage::TB_TypeCollectionImageTableC) == 0){
               if (isset($row[TB_TypeCollectionImage::TypeIdColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_TypeCollectionImage::TypeIdColumnC ." ] -> [ ".
                             $row[TB_TypeCollectionImage::TypeIdColumnC] ." ]");
                  $theTable->setTypeId($row[TB_TypeCollectionImage::TypeIdColumnC ]);
                }
               if (isset($row[TB_TypeCollectionImage::TypeNameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_TypeCollectionImage::TypeNameColumnC ." ] -> [ ".
                             $row[TB_TypeCollectionImage::TypeNameColumnC] ." ]");
                  $theTable->setTypeName($row[TB_TypeCollectionImage::TypeNameColumnC ]);
                }
               if (isset($row[TB_TypeCollectionImage::CollectionIdColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_TypeCollectionImage::CollectionIdColumnC ." ] -> [ ".
                             $row[TB_TypeCollectionImage::CollectionIdColumnC] ." ]");
                  $theTable->setCollectionId($row[TB_TypeCollectionImage::CollectionIdColumnC ]);
                }
               if (isset($row[TB_TypeCollectionImage::CollectionNameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_TypeCollectionImage::CollectionNameColumnC ." ] -> [ ".
                             $row[TB_TypeCollectionImage::CollectionNameColumnC] ." ]");
                  $theTable->setCollectionName($row[TB_TypeCollectionImage::CollectionNameColumnC ]);
                }
               if (isset($row[TB_TypeCollectionImage::CollectionMenuIdColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_TypeCollectionImage::CollectionMenuIdColumnC ." ] -> [ ".
                             $row[TB_TypeCollectionImage::CollectionMenuIdColumnC] ." ]");
                  $theTable->setCollectionMenuId($row[TB_TypeCollectionImage::CollectionMenuIdColumnC ]);
                }
               if (isset($row[TB_TypeCollectionImage::ImagePathColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_TypeCollectionImage::ImagePathColumnC ." ] -> [ ".
                             $row[TB_TypeCollectionImage::ImagePathColumnC] ." ]");
                  $theTable->setImagePath($row[TB_TypeCollectionImage::ImagePathColumnC ]);
                }
               if (isset($row[TB_TypeCollectionImage::ImageDescriptionColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_TypeCollectionImage::ImageDescriptionColumnC ." ] -> [ ".
                             $row[TB_TypeCollectionImage::ImageDescriptionColumnC] ." ]");
                  $theTable->setImageDescription($row[TB_TypeCollectionImage::ImageDescriptionColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_News::TB_NewsTableC) == 0){
               if (isset($row[TB_News::TitleColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_News::TitleColumnC ." ] -> [ ".
                             $row[TB_News::TitleColumnC] ." ]");
                  $theTable->setTitle($row[TB_News::TitleColumnC ]);
                }
               if (isset($row[TB_News::NewColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_News::NewColumnC ." ] -> [ ".
                             $row[TB_News::NewColumnC] ." ]");
                  $theTable->setNew($row[TB_News::NewColumnC ]);
                }
            }

            }else{
               $theResult[RESULT_CODE] = RESULT_CODE_INTERNAL_ERROR;
               $theResult[MSG_ERROR] = "The Key has not been found.";
               $logger->warn($theResult[MSG_ERROR]);
               break;
            }
         }
         $logger->trace("Update the data in the database");
         if ( ! $theTable->update()){
            $theResult[RESULT_CODE] = RESULT_CODE_INTERNAL_ERROR;
            $theResult[MSG_ERROR] = $theTable->getStrError();
            $logger->error("The update failed. Error [ " . $theResult[MSG_ERROR] . " ]");
         }
      $logger->trace("Exit");
   }

   function insertData($theTable, $theData, &$theResult){
      global $logger;
      $logger->trace("Enter");
      $logger->trace("Insert data: [ ".json_encode($theData)." ]");
      $logger->trace("Into [ " . $theTable->getTableName() ." ]");

      if (strcmp($theTable->getTableName(),TB_Configuration::TB_ConfigurationTableC) == 0){

         //Declare variables
         $varValue = $theData["Value"];
         $varDescription = $theData["Description"];
         $varLabel = $theData["Label"];
         $varDataType = $theData["DataType"];

         $newId = $theTable->insert($varValue
                                ,$varDescription
                                ,$varLabel
                                ,$varDataType
                                );
      }

      if (strcmp($theTable->getTableName(),TB_Menu::TB_MenuTableC) == 0){

         //Declare variables
         $varOption = $theData["Option"];

         $newId = $theTable->insert($varOption
                                );
      }

      if (strcmp($theTable->getTableName(),TB_SlideImagesHome::TB_SlideImagesHomeTableC) == 0){

         //Declare variables
         $varPath = $theData["Path"];

         $newId = $theTable->insert($varPath
                                );
      }

      if (strcmp($theTable->getTableName(),TB_ImageType::TB_ImageTypeTableC) == 0){

         //Declare variables
         $varType = $theData["Type"];

         $newId = $theTable->insert($varType
                                );
      }

      if (strcmp($theTable->getTableName(),TB_Users::TB_UsersTableC) == 0){

         //Declare variables
         $varName = $theData["Name"];
         $varEmail = $theData["Email"];
         $varPassword = $theData["Password"];

         $newId = $theTable->insert($varName
                                ,$varEmail
                                ,$varPassword
                                );
      }

      if (strcmp($theTable->getTableName(),TB_CookiesByCollection::TB_CookiesByCollectionTableC) == 0){

         //Declare variables
         $varCollectionId = $theData["CollectionId"];
         $varCollectionName = $theData["CollectionName"];
         $varImagePath = $theData["ImagePath"];
         $varImageDescription = $theData["ImageDescription"];
         $varImageName = $theData["ImageName"];

         $newId = $theTable->insert($varCollectionId
                                ,$varCollectionName
                                ,$varImagePath
                                ,$varImageDescription
                                ,$varImageName
                                );
      }

      if (strcmp($theTable->getTableName(),TB_CakesByCollection::TB_CakesByCollectionTableC) == 0){

         //Declare variables
         $varCollectionId = $theData["CollectionId"];
         $varCollectionName = $theData["CollectionName"];
         $varImagePath = $theData["ImagePath"];
         $varImageDescription = $theData["ImageDescription"];
         $varImageName = $theData["ImageName"];

         $newId = $theTable->insert($varCollectionId
                                ,$varCollectionName
                                ,$varImagePath
                                ,$varImageDescription
                                ,$varImageName
                                );
      }

      if (strcmp($theTable->getTableName(),TB_ModelsByCollection::TB_ModelsByCollectionTableC) == 0){

         //Declare variables
         $varCollectionId = $theData["CollectionId"];
         $varCollectionName = $theData["CollectionName"];
         $varImagePath = $theData["ImagePath"];
         $varImageDescription = $theData["ImageDescription"];
         $varImageName = $theData["ImageName"];

         $newId = $theTable->insert($varCollectionId
                                ,$varCollectionName
                                ,$varImagePath
                                ,$varImageDescription
                                ,$varImageName
                                );
      }

      if (strcmp($theTable->getTableName(),TB_MenuCollection::TB_MenuCollectionTableC) == 0){

         //Declare variables
         $varMenuId = $theData["MenuId"];
         $varMenuOption = $theData["MenuOption"];
         $varCollectionName = $theData["CollectionName"];

         $newId = $theTable->insert($varMenuId
                                ,$varMenuOption
                                ,$varCollectionName
                                );
      }

      if (strcmp($theTable->getTableName(),TB_ImagesAndCollection::TB_ImagesAndCollectionTableC) == 0){

         //Declare variables
         $varCollectionId = $theData["CollectionId"];
         $varCollectionName = $theData["CollectionName"];
         $varCollectionMenuId = $theData["CollectionMenuId"];
         $varImagePath = $theData["ImagePath"];
         $varImageDescription = $theData["ImageDescription"];
         $varImageName = $theData["ImageName"];

         $newId = $theTable->insert($varCollectionId
                                ,$varCollectionName
                                ,$varCollectionMenuId
                                ,$varImagePath
                                ,$varImageDescription
                                ,$varImageName
                                );
      }

      if (strcmp($theTable->getTableName(),TB_TypeCollectionImage::TB_TypeCollectionImageTableC) == 0){

         //Declare variables
         $varTypeId = $theData["TypeId"];
         $varTypeName = $theData["TypeName"];
         $varCollectionId = $theData["CollectionId"];
         $varCollectionName = $theData["CollectionName"];
         $varCollectionMenuId = $theData["CollectionMenuId"];
         $varImagePath = $theData["ImagePath"];
         $varImageDescription = $theData["ImageDescription"];

         $newId = $theTable->insert($varTypeId
                                ,$varTypeName
                                ,$varCollectionId
                                ,$varCollectionName
                                ,$varCollectionMenuId
                                ,$varImagePath
                                ,$varImageDescription
                                );
      }

      if (strcmp($theTable->getTableName(),TB_News::TB_NewsTableC) == 0){

         //Declare variables
         $varTitle = $theData["Title"];
         $varNew = $theData["New"];

         $newId = $theTable->insert($varTitle
                                ,$varNew
                                );
      }

      if( $newId != -1){
           $logger->trace("The insertion was exectuted successfully. ".
                           "The new Id is [ $newId ]");
           $theResult[RETURN_LAST_ID]=$newId;
        }else{
           $theResult[RESULT_CODE] = RESULT_CODE_INTERNAL_ERROR;
           $theResult[MSG_ERROR] = $theTable->getStrError();
           $logger->error("The insert failed. Error [ " . $theResult[MSG_ERROR] . " ]");
        }
      $logger->trace("Exit");
   }

   function delete($theTable, $theData, &$theResult){
      global $logger;
      $logger->trace("Enter");
      $jsonKey = $theData[PARAM_KEY];
      $logger->trace("Delete from table ".$theTable->getTableName().
                    " with key [ ".json_encode($jsonKey)." ]");

      if (strcmp($theTable->getTableName(),TB_Configuration::TB_ConfigurationTableC) == 0){
         $composedKey = array();
         $composedKey["Property"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_Menu::TB_MenuTableC) == 0){
         $composedKey = array();
         $composedKey["Id"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_SlideImagesHome::TB_SlideImagesHomeTableC) == 0){
         $composedKey = array();
         $composedKey["Id"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_ImageType::TB_ImageTypeTableC) == 0){
         $composedKey = array();
         $composedKey["Id"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_Users::TB_UsersTableC) == 0){
         $composedKey = array();
         $composedKey["Id"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_CookiesByCollection::TB_CookiesByCollectionTableC) == 0){
         $composedKey = array();
         $composedKey["ImageId"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_CakesByCollection::TB_CakesByCollectionTableC) == 0){
         $composedKey = array();
         $composedKey["ImageId"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_ModelsByCollection::TB_ModelsByCollectionTableC) == 0){
         $composedKey = array();
         $composedKey["ImageId"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_MenuCollection::TB_MenuCollectionTableC) == 0){
         $composedKey = array();
         $composedKey["CollectionId"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_ImagesAndCollection::TB_ImagesAndCollectionTableC) == 0){
         $composedKey = array();
         $composedKey["ImageId"] = json_encode($jsonKey);
         $composedKey["CollectionId"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_TypeCollectionImage::TB_TypeCollectionImageTableC) == 0){
         $composedKey = array();
         $composedKey["TypeCollectionImageId"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_News::TB_NewsTableC) == 0){
         $composedKey = array();
         $composedKey["DateTime"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }
      $logger->trace("Delete data in the database");
      if (! $theTable->delete()){
         $theResult[RESULT_CODE] = RESULT_CODE_INTERNAL_ERROR;
         $theResult[MSG_ERROR] = $theTable->getStrError();
         $logger->error("The delete failed. Error [ " . $theResult[MSG_ERROR] . " ]");
      }
      $logger->trace("Exit");
   }

   
   /******************* MAIN *********************************/

  
   if (count($_POST) > 0){
      $logger = LoggerMgr::Instance()->getLogger("RequestFromWeb.php");
   

      $logger->info("A request has been received from web");
      $resultArray = array();
      if (!isset ($_POST[COMMAND]) || ! isset ($_POST[PARAMS])){
         $resultArray[RESULT_CODE] = RESULT_CODE_INTERNAL_ERROR;
         $resultArray[MSG_ERROR] = "Unmatched format request. Absence of param COMMAND or PARAMS";
         $logger->error(json_encode($resultArray));
         //$logger->error("Unmatched format request. Absence of param $COMMAND or $PARAMS");
            //print("ERROR 500. Unmatched format request. Absence of param $COMMAND or $PARAMS");
         
      }else{
         $resultArray[RESULT_CODE] = RESULT_CODE_SUCCESS;
         $strCommand = $_POST[COMMAND];
         $strParams = $_POST[PARAMS];
         $logger->trace("The command is [ $strCommand ] and the params are [ $strParams ]");
         $params = json_decode($strParams, true);
         $table = getTable($params[PARAM_TABLE]);
         $logger->trace("The command parameter is [ $strCommand ]");
         $logger->trace("Open the table [ $params[PARAM_TABLE] ]");
         $table->open();
      
         if (strcmp(strtoupper($strCommand), COMMAND_UPDATE) == 0){
            $logger->debug("It is a update command in table [ ". $table->getTableName() . " ]");
            updateData($table, $params[PARAM_ROWS],$resultArray);
         }
         if (strcmp(strtoupper($strCommand), COMMAND_INSERT) == 0){
            $logger->debug("It is a insert command in table [ ". $table->getTableName() . " ]");
            insertData($table, $params[PARAM_DATA], $resultArray);
         }
         if (strcmp(strtoupper($strCommand), COMMAND_DELETE) == 0){
            $logger->debug("It is a delete command in table [ ". $table->getTableName() . " ]");
            delete($table, $params[PARAM_DATA], $resultArray);
         }
         $logger->trace("The request has been processed. Result [ " . json_encode($resultArray) ." ]");
        
      }
      print(json_encode($resultArray));
   } 
   
?>