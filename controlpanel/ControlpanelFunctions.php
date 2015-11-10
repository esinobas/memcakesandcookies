<?php
/**
 * File with functions used by the control panel
 */
   
/********* includes *****/

/******** requires *****/

//Define the constanst that allows access to the data configuration
define(IMAGES_CAKES_DIRECTORY_C, 'cakesImagesPath');
define(IMAGES_COOKIES_DIRECTORY_C, 'cookiesImagesPath');
define(IMAGES_MODELS_DIRECTORY_C, 'modelsImagesPath');
define(SLIDE_IMAGE_DIRECTORY_C, 'SlideImagesPath');
define(NUM_THUMBNAILS_C, 'numberThumbnails');
define(THUMBNAILS_DIRECTORY_C, 'thumbnailsPath');
define(URL_C, 'URL');

class ControlpanelFunctions{
   
   /** Private properties or variabels */
   /**
    * Object that saves the configuration
    * @var TB_Configuration
    */
   static private $tbConfigurationM = null;
   
   /**
    * Object that allows write the log in a file
    * @var Logger
    */
   static private $loggerM = null;
   
   /****** private functions *****/
   
   /**
    * Function that creates the logger
    */
   static private function createLogger(){
      if (self::$loggerM == null){
         self::$loggerM = LoggerMgr::Instance()->getLogger(basename(__FILE__));
      }
   }
/********* Private functions ******/
   
   /**
    * Writes the java script function that add a new image in the grid
    * 
    */
   static public function writeJSFunctionAddNewImage(){
   
      self::createLogger();
      self::$loggerM->trace("Enter");
?>
      <script type="text/javascript">
         /**
          * Function that shows the new image added in a collection
          *
          * @param theHtmlObj: The object where the new image is add
          * @param theId: The image identifier in the ddbb
          * @param thePath: The image path in the server
          * @param theDesc: The image description
          */
         var addNewImage = function(theHtmlObj,theID, thePath, theDesc){
            JSLogger.getInstance().traceEnter();
            JSLogger.getInstance().debug("Add a image with following parameters:\n"+
               "HtmlObject [ " + theHtmlObj.attr('id') + " ]\n"+
               "Image Id [ " + theID +" ]\n"+
               "Image Path [ " + thePath + " ]\n"+
               "Image Desc [ " + theDesc + " ]");
            /**Add new element with this format**/
            /******
               <div class="Grid-Element">
                  <div class="Grid-Image" id="image_[image id]">
                     <img src="[image path]" title="[image description]"/>
                  </div>
                  <div class="ImageToolbar" id="ImageToolBar_[image id]">
                     <div class="UpdateImage Round-Corners-Button" id="UpdateImg_[image id]">
                        Modificar
                     </div>
                     <div class="RemoveImage Round-Corners-Button" id="RemoveImg_[image id]">
                        Eliminar
                     </div>
                  </div>
               </div>
            ********/
            var text = '<div class="Grid-Element">';
            text += '<div class="Grid-Image" id="image_' + theID+ '">';
            text += '<img src="'+thePath+'" title="'+theDesc+'"/>';
            text += '</div>';
            text += '<div class="ImageToolbar" id="ImageToolBar_'+theID+'">';
            text += '<div class="UpdateImage Round-Corners-Button" id="UpdateImg_'+theID+'">';
            text += 'Modificar';
            text += '</div>';
            text += '<div class="RemoveImage Round-Corners-Button" id="RemoveImg_'+theID+'">';
            text += 'Eliminar';
            text += '</div>';
            text += '</div>';
            text += '</div>';
            JSLogger.getInstance().trace("Object to insert [ " + text +" ]");
            //$('#'+theHtmlObj.attr('id')).append(text);
            $(text).insertAfter($('#'+theHtmlObj.attr('id')).find('.Add-Picture-Collection').parent());
            JSLogger.getInstance().traceExit();
         }
      </script>
      
<?php 
      self::$loggerM->trace("Exit");
   }
   
   /**
    * Writes the javascript function to open a filebrowser that allows select a image
    */
   static public function writeJSFunctionOpenFileBrowser(){
      self::createLogger();
      self::$loggerM->trace("Enter");
?>
      <script type="text/javascript">
         /**
          * Open a filebrowser where the user can select a image for be added
          * to one collection
          *
          * @param theRootPath: The filebrowser root path
          * @param theCollectionName: The collection name showed in the filebrowser
          */
         var openFilebrowserSelectImage = function(theRootPath, 
                                          theCollectionName){
            JSLogger.getInstance().traceEnter();
            JSLogger.getInstance().trace("Open filebrowser with root path [ " +
                  theRootPath +" ] and the collection name [ " +
                  theCollectionName +" ]");
            fileBrowser = new FileBrowser(
               {path:{
                  root_path:theRootPath
                  },
               type: "a", filter: "*.*", 
               callback: addImageCallback,
               Title_Params:{
                   Caption:"Selecciona la foto que quieras añadir a \""+theCollectionName +"\"",
                   Background_Color:"orange"
                            },
               toolbar:"upload_file|create_folder|delete"
            });
            JSLogger.getInstance().traceExit();
         }
      </script>
<?php 
      self::$loggerM->trace("Exit");
   }
   
   /***
    * Writes the javascript function to add a new image in a collection
    */
   static public function writeJSFunctionAddImageToCollection(){
      self::createLogger();
      self::$loggerM->trace("Enter");
?>
      <script type="text/javascript">
      
      //Funcion definition to add a new image in a collection
         const IMAGES_CAKES_PATH_C = "Cakes";
         const IMAGES_COOKIES_PATH_C = "Cookies";
         const IMAGES_MODELS_PATH_C = "Models";
         const URL_C = "url";
         
         var imagesPaths = new Object();
         

         JSLogger.getInstance().trace("Saving the images path in an object from php");
         <?php
               self::$tbConfigurationM->rewind(); 
               self::$tbConfigurationM->searchByKey(URL_C);
         ?>
         imagesPaths[URL_C] = "<?php print(self::$tbConfigurationM->getValue());?>";
         <?php
               self::$tbConfigurationM->rewind(); 
               self::$tbConfigurationM->searchByKey(IMAGES_CAKES_DIRECTORY_C);
         ?>
         imagesPaths[IMAGES_CAKES_PATH_C] = "<?php print(self::$tbConfigurationM->getValue());?>";
         <?php 
            self::$tbConfigurationM->rewind();
            self::$tbConfigurationM->searchByKey(IMAGES_COOKIES_DIRECTORY_C);
         ?>
         imagesPaths[IMAGES_COOKIES_PATH_C] = "<?php print(self::$tbConfigurationM->getValue());?>";
         <?php 
            self::$tbConfigurationM->rewind();
            self::$tbConfigurationM->searchByKey(IMAGES_MODELS_DIRECTORY_C);
         ?>
         imagesPaths[IMAGES_MODELS_PATH_C] = "<?php print(self::$tbConfigurationM->getValue());?>";

         /** the Values is JSON string where the image information is saved **/
         var addImageToCollection = function(theValues){
            JSLogger.getInstance().traceEnter();
            var imagesType = new Object();

<?php
            $tbImageType = new TB_ImageType();
            $tbImageType->open();
            $tbImageType->searchByColumn(TB_ImageType::TypeColumnC, 'Cakes');
?>
            imagesType['Cakes'] = <?php print($tbImageType->getId());?>;
<?php

            $tbImageType->open();
            $tbImageType->searchByColumn(TB_ImageType::TypeColumnC, 'Modelados');
?>
            imagesType['Modelados'] = <?php print($tbImageType->getId());?>;
<?php

            $tbImageType->open();
            $tbImageType->searchByColumn(TB_ImageType::TypeColumnC, 'Cookies');
?>
            imagesType['Cookies'] = <?php print($tbImageType->getId());?>;
            
            JSLogger.getInstance().debug("The values are [ " + theValues +
                                        " ]");
            var jsonValues = JSON.parse(theValues);
            JSLogger.getInstance().trace("Getting collection id");
            var collectionId = $('.Vertical-Tab:visible .ListBox .ListBoxItemSelected').attr('id');
            collectionId = collectionId.substring(11);
            JSLogger.getInstance().trace("Collection Id [ " + collectionId + " ]");
            JSLogger.getInstance().trace("Getting the type selected");
            var strTypeSelected = $('.Vertical-Tab:visible').attr('id');
            strTypeSelected = strTypeSelected.substring(4);
            var typeSelected = imagesType[strTypeSelected];
            JSLogger.getInstance().trace("[ " + strTypeSelected + " ]-> [ " + typeSelected +" ]");
            insertImageIntoCollection(collectionId,
                                       typeSelected, //imagetype
                                             jsonValues['imagePath'],
                                             jsonValues['Image']);
            
            JSLogger.getInstance().traceExit();
         };
      </script>
<?php 
      self::$loggerM->trace("Exit");
   }
   
   /**
    * Writes the java script function that inserts a new collection
    */
   static public function writeJSFunctionInsertNewCollection(){
      self::createLogger();
      self::$loggerM->trace("Enter");
      ?>
         <script type="text/javascript">
         
            JSLogger.getInstance().trace("Declare function to add a new collection");
            /**
            * Funtion that inserts a new collection
            * @param theData: String in JSON format with the data
            */
            var insertNewCollection = function(theValues){
               JSLogger.getInstance().traceEnter();
               JSLogger.getInstance().trace(theValues);
               var collectionName = JSON.parse(theValues)['NewCollectionLabel'];
               JSLogger.getInstance().trace("Collection Name [ " + collectionName +" ]");
               JSLogger.getInstance().trace("Get menu ids");
               var menuIds = new Object();

<?php
               $tbMenu = new TB_Menu();
               $tbMenu->open();
               while($tbMenu->next()){
?>
                  menuIds['<?php print($tbMenu->getOption());?>'] = <?php print($tbMenu->getId());?>;
<?php 
               } 
?>

               JSLogger.getInstance().trace("Get the active tab");
               var selectedTab = $('.Vertical-Tab:visible').attr('id').substr(4);
               JSLogger.getInstance().trace("Active tab [ " + selectedTab +" ]");
               JSLogger.getInstance().trace("Create Ajax object");
               var ajaxObject = new Ajax();
               ajaxObject.setSyn();
               ajaxObject.setPostMethod();
               
               JSLogger.getInstance().debug("Url whete the data will be send [ " + imagesPaths[URL_C] 
                   +"php/Database/RequestFromWeb.php ]");
               ajaxObject.setUrl(imagesPaths[URL_C]+"php/Database/RequestFromWeb.php");
               var requestParams = {};
               requestParams.<?php print(COMMAND);?> = <?php print("\"".COMMAND_INSERT."\"");?>;
               requestParams.<?php print(PARAMS);?> = {};
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = <?php print("\""
                        .TB_MenuCollection::TB_MenuCollectionTableC."\"");?>;
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_MenuCollection::MenuIdColumnC);?> = menuIds[selectedTab];
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_MenuCollection::MenuOptionColumnC);?> = selectedTab;
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_MenuCollection::CollectionNameColumnC);?> = collectionName;

               JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

               ajaxObject.setParameters(JSON.stringify(requestParams));

               ajaxObject.send();
               JSLogger.getInstance().trace("Response [ " + ajaxObject.getResponse() + " ]");

               if (ajaxObject.getResponse().indexOf("404 Not Found") != -1){
                  JSLogger.getInstance().error("The script [ " +imagesPaths[URL_C] +
                     "/php/Database/RequestFromWeb.php ] has been found");
                  MessageBox("Error", 
                     "La coleccción no se ha creado.",
                     {Icon: MessageBox.IconsE.ERROR});
               }else{
                  var objResponse = JSON.parse(ajaxObject.getResponse());
                  if (parseInt(objResponse['ResultCode']) != 200){
                        MessageBox("Error", 
                           "La colección no se ha creado. Error [ " +
                           objResponse['ErrorMsg'] + " ]",
                           {Icon: MessageBox.IconsE.ERROR});
                        JSLogger.getInstance().error("The collection has not been created. [ " +
                            objResponse['ErrorMsg'] + " ]");
                  }else{
                     var newId = objResponse['lastID'];
                     JSLogger.getInstance().trace("The collecction has been created with Id [ "+
                                                newId + " ]");

                     addNewCollection(newId, collectionName);
                  }
               }
               
               
               JSLogger.getInstance().traceExit();
            }
         </script>
   <?php 
         self::$loggerM->trace("Exit");
      }
   
   /**
    * Writes the java script function to send the image data to the server
    */
   static public function writeJSFuncionInsertImageIntoCollection(){
      self::createLogger();
      self::$loggerM->trace("Enter");
?>
   <script type="text/javascript">
      JSLogger.getInstance().trace("Declare function to send the image data to the server");
      /**
       * Function that sends the request to the server for add a image in a collection
       * @param theCollectionId: The collection id the image belongs to.
       * @param theType: The image type
       * @param theImagePath: The Image path
       * @param theImageDesc: The image description
       */
      var insertImageIntoCollection = function (theCollectionId, theImageType, 
                                 theImagePath, theImageDesc){
         JSLogger.getInstance().traceEnter();
         JSLogger.getInstance().debug("Inserting the image [ " + 
                              theImagePath +
                              " ] with Description [ " +
                              theImageDesc + " ] into collection id [ " +
                              theCollectionId +" ] and type [ "+ 
                              theImageType +" ]");

         JSLogger.getInstance().trace("Create Ajax object");
         var ajaxObject = new Ajax();
         ajaxObject.setSyn();
         ajaxObject.setPostMethod();
         
         JSLogger.getInstance().debug("Url whete the data will be send [ " + imagesPaths[URL_C] 
             +"php/Database/RequestFromWeb.php ]");
         ajaxObject.setUrl(imagesPaths[URL_C]+"php/Database/RequestFromWeb.php");
         var requestParams = {};
         requestParams.<?php print(COMMAND);?> = <?php print("\"".COMMAND_INSERT."\"");?>;
         requestParams.<?php print(PARAMS);?> = {};
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = <?php print("\""
                  .TB_TypeCollectionImage::TB_TypeCollectionImageTableC ."\"");?>;

         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_TypeCollectionImage::ImagePathColumnC);?> = theImagePath;
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_TypeCollectionImage::ImageDescriptionColumnC);?> = theImageDesc;
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_TypeCollectionImage::CollectionIdColumnC);?> = theCollectionId;
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_TypeCollectionImage::TypeIdColumnC);?> = theImageType;
         JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

         ajaxObject.setParameters(JSON.stringify(requestParams));
         ajaxObject.send();
         JSLogger.getInstance().trace("Response [ " + ajaxObject.getResponse() + " ]");

         if (ajaxObject.getResponse().indexOf("404 Not Found") != -1){
            JSLogger.getInstance().error("The script [ " +imagesPaths[URL_C] +
               "/php/Database/RequestFromWeb.php ] has been found");
            MessageBox("Error", 
               "La imagen no ha podido ser añadida.",
               {Icon: MessageBox.IconsE.ERROR});
         }else{
            var objResponse = JSON.parse(ajaxObject.getResponse());
            if (parseInt(objResponse['ResultCode']) != 200){
                  MessageBox("Error", 
                     "La imagen no ha podido ser añadida. Error [ " +
                     objResponse['ErrorMsg'] + " ]",
                     {Icon: MessageBox.IconsE.ERROR});
                  JSLogger.getInstance().error("The image has not been added. [ " +
                      objResponse['ErrorMsg'] + " ]");
            }else{
               var newId = objResponse['lastID'];
               JSLogger.getInstance().trace("The image has been added successfull with Id [ "+
                                          newId + " ]");
               addNewImage($('.Vertical-Tab:visible .Grid:visible'),newId,
                                      imagesPaths[URL_C]+theImagePath,
                        theImageDesc);
            }
         }

         JSLogger.getInstance().traceExit();
      }

   </script>
<?php
      self::$loggerM->trace("Exit");
   }
   
   /**
    * Writes the java script function used like callback when an image
    * is added to collection
    *  
    */
   
   static public function writeJSFunctionAddImageCallback(){
      self::createLogger();
      self::$loggerM->trace("Enter");
?>
      <script type="text/javascript">
         var addImageCallback = function (theData){
            JSLogger.getInstance().traceEnter();
            JSLogger.getInstance().debug("The selected image is [ " + theData.path + " ]");
            JSLogger.getInstance().trace("Show the window where the image description is written");
            JSLogger.getInstance().trace("Getting the type selected");

            var strTypeSelected = $('.Vertical-Tab:visible').attr('id');
            strTypeSelected = strTypeSelected.substring(4);
            JSLogger.getInstance().trace("[ " + strTypeSelected + " ]");
            var imageSrc = imagesPaths[URL_C] + imagesPaths[strTypeSelected] +"/";
            JSLogger.getInstance().trace("src[ "+ imageSrc + theData.path + " ]");
            $('#WindowAddImageDesc img').attr('src', imageSrc+
                  theData.path);
            DataEntryWindow.show('#WindowAddImageDesc', 
                        addImageToCollection, 
                        {size:{width:'500px',height:'300px'},
                         dataToAdd: {imagePath: imagesPaths[strTypeSelected] +"/"+theData.path}});
            JSLogger.getInstance().traceExit();
         }
      </script>
<?php 
      self::$loggerM->trace("Exit");
   }
   
   /**
    * Writes the javascript funcction to add a new collection in the page
    */
   static public function writeJSFuncionAddNewCollection(){
      self::createLogger();
      self::$loggerM->trace("Enter");
?>
      <script type="text/javascript">
      
      //   Funcion definition to add a new collection in the page, inserting its
      //   name in the listbox and creating the necessary controls for management it.

            var addNewCollection = function(theCollectionId, theCollectionName){
            JSLogger.getInstance().traceEnter();
            JSLogger.getInstance().debug("Add new collection with id [ " +
                                    theCollectionId + " ] and name [ " +
                                    theCollectionName +" ]"+$('.Vertical-Tab:visible .ListBox').size());
            $('.Vertical-Tab:visible .ListBox').append('<div id="Collection_'+
                  theCollectionId + '" class="ListBoxItem">'+theCollectionName+
                  '</div>');
            JSLogger.getInstance().trace("Dis-select all list box element of the listbox");
            $('.Vertical-Tab:visible .ListBox .ListBoxItem').removeClass('ListBoxItemSelected');

            JSLogger.getInstance().trace("Select the new item added in the listbox");
            $('#Collection_'+theCollectionId).addClass('ListBoxItemSelected');
            
            JSLogger.getInstance().trace("Add a new grid that belongs to the new collection added");
            $('.Vertical-Tab:visible .ImagesList').append('<div id="Grid_Collection_'+
                  theCollectionId + '" class="Grid"><div class="Grid-Element">'+
                  '<div id="Add-Picture-Collection_'+theCollectionId+'" class="'+
                  'Round-Corners-Button Add-Picture-Collection">Añadir Foto</div></div></div>');

            JSLogger.getInstance().trace("Add click event to the ListBoxItem added");
            $('#Collection_'+theCollectionId).click(function(){
               $(this).parent().find('.ListBoxItem').removeClass('ListBoxItemSelected');
               $(this).addClass('ListBoxItemSelected');

               JSLogger.getInstance().trace("Hide all [ " +
                     $('.Vertical-Tab:visible>.ImagesList>.Grid').size() + " ] grid in images list");
                   $('.Vertical-Tab:visible>.ImagesList>.Grid').addClass('Grid-Hidden');
                   JSLogger.getInstance().trace("Show the grid Id [ Grid_Collection_" + 
                         theCollectionId + " ]");
                   $('#Grid_Collection_' + theCollectionId).removeClass('Grid-Hidden');
            });

            JSLogger.getInstance().trace("Hide all the grids and show only the new grid");
            $('.Vertical-Tab:visible>.ImagesList>.Grid').addClass('Grid-Hidden');
            $('#Grid_Collection_' + theCollectionId).removeClass('Grid-Hidden');


            JSLogger.getInstance().trace("Add the functionality to the new add picture button");
            var selectedType = $('.Vertical-Tab:visible').attr('id').substring(4);
            JSLogger.getInstance().trace("Type [ " +selectedType+" ]");
            
            
            var imagesPath = "<?php print($_SERVER['DOCUMENT_ROOT']); ?>/" + imagesPaths[selectedType];
            JSLogger.getInstance().trace("The images directory is [ "+ 
                           imagesPath +" ]");
            $('#Add-Picture-Collection_'+theCollectionId).click(function(){
               openFilebrowserSelectImage(imagesPath, theCollectionName);
            });
            
            
            JSLogger.getInstance().traceExit();
         }
   </script>
<?php 
      self::$loggerM->trace("Exit");
   }
/********* Public functions ******/
/**
 * Gets the configuration from the database and it showed
 * 
 */
   static public function getConfiguration(){
      //require_once 'Database/RequestFromWeb.php';
      self::createLogger();
      self::$loggerM->trace("Enter");
      self::$tbConfigurationM = new TB_Configuration();
      self::$tbConfigurationM->open();
     
?>
      <div id="DataConfiguration" class="Data-Grid">
        
<?php 
      self::$tbConfigurationM->searchByKey(URL_C);
?>
         <div id="DataConfiguration-<?php print (self::$tbConfigurationM->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", self::$tbConfigurationM->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", self::$tbConfigurationM->getDescription());?>
                id="<?php print(self::$tbConfigurationM->getProperty());?>">
               <?php 
                     self::$loggerM->trace("The [ ".self::$tbConfigurationM->getProperty().
                            " ] type data is [ " . self::$tbConfigurationM->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" id="Input-Url"
                      value="<?php print (self::$tbConfigurationM->getValue());?>">
               
            </div>
            <div class="Data-Grid-Column">
            </div>
         </div>
<?php
      self::$tbConfigurationM->rewind();
      self::$tbConfigurationM->searchByKey(IMAGES_CAKES_DIRECTORY_C);
?>
         <div id="DataConfiguration-<?php print (self::$tbConfigurationM->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", self::$tbConfigurationM->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", self::$tbConfigurationM->getDescription());?> 
               id="<?php print(self::$tbConfigurationM->getProperty());?>">
               <?php 
                     self::$loggerM->trace("The [ ".self::$tbConfigurationM->getProperty().
                            " ] type data is [ " . self::$tbConfigurationM->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" id="Input-Cakes-Directory"
                      value="<?php print (self::$tbConfigurationM->getValue());?>" readonly>
               
            </div>
            <div class="Data-Grid-Column">
               <div class="Round-Corners-Button" id="Button-Image-Cakes-Directory">
                  Seleccionar
               </div>
            </div>
         </div>
<?php
      self::$tbConfigurationM->rewind();
      self::$tbConfigurationM->searchByKey(IMAGES_COOKIES_DIRECTORY_C);
?>
         <div id="DataConfiguration-<?php print (self::$tbConfigurationM->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", self::$tbConfigurationM->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", self::$tbConfigurationM->getDescription());?> 
               id="<?php print(self::$tbConfigurationM->getProperty());?>">
               <?php 
                     self::$loggerM->trace("The [ ".self::$tbConfigurationM->getProperty().
                            " ] type data is [ " . self::$tbConfigurationM->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" id="Input-Cookies-Directory"
                      value="<?php print (self::$tbConfigurationM->getValue());?>" readonly>
               
            </div>
            <div class="Data-Grid-Column">
               <div class="Round-Corners-Button" id="Button-Image-Cookies-Directory">
                  Seleccionar
               </div>
            </div>
         </div>
<?php
      self::$tbConfigurationM->rewind();
      self::$tbConfigurationM->searchByKey(IMAGES_MODELS_DIRECTORY_C);
?>
         <div id="DataConfiguration-<?php print (self::$tbConfigurationM->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", self::$tbConfigurationM->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", self::$tbConfigurationM->getDescription());?>
               id="<?php print(self::$tbConfigurationM->getProperty());?>">
               <?php 
                     self::$loggerM->trace("The [ ".self::$tbConfigurationM->getProperty().
                            " ] type data is [ " . self::$tbConfigurationM->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" id="Input-Models-Directory"
                      value="<?php print (self::$tbConfigurationM->getValue());?>" readonly>
               
            </div>
            <div class="Data-Grid-Column">
               <div class="Round-Corners-Button" id="Button-Image-Models-Directory">
                  Seleccionar
               </div>
            </div>
         </div>
<?php
      self::$tbConfigurationM->rewind();
      self::$tbConfigurationM->searchByKey(SLIDE_IMAGE_DIRECTORY_C);
?>
         <div id="DataConfiguration-<?php print (self::$tbConfigurationM->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", self::$tbConfigurationM->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", self::$tbConfigurationM->getDescription());?>
               id="<?php print(self::$tbConfigurationM->getProperty());?>">
               <?php 
                     self::$loggerM->trace("The [ ".self::$tbConfigurationM->getProperty().
                            " ] type data is [ " . self::$tbConfigurationM->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" id="Input-SlideImages-Directory"
                      value="<?php print (self::$tbConfigurationM->getValue());?>" readonly>
               
            </div>
            <div class="Data-Grid-Column">
               <div class="Round-Corners-Button" id="Button-SlideImages-Directory">
                  Seleccionar
               </div>
            </div>
         </div>
<?php
      self::$tbConfigurationM->rewind();
      self::$tbConfigurationM->searchByKey(THUMBNAILS_DIRECTORY_C);
?>
         <div id="DataConfiguration-<?php print (self::$tbConfigurationM->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", self::$tbConfigurationM->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", self::$tbConfigurationM->getDescription());?>
                 id="<?php print(self::$tbConfigurationM->getProperty());?>">
               <?php 
                     self::$loggerM->trace("The [ ".self::$tbConfigurationM->getProperty().
                            " ] type data is [ " . self::$tbConfigurationM->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" 
                      value="<?php print (self::$tbConfigurationM->getValue());?>">
               
            </div>

         </div>
         
<?php
      self::$tbConfigurationM->rewind();
      self::$tbConfigurationM->searchByKey(NUM_THUMBNAILS_C);
?>
         <div id="DataConfiguration-<?php print (self::$tbConfigurationM->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", self::$tbConfigurationM->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", self::$tbConfigurationM->getDescription());?> 
                     id="<?php print(self::$tbConfigurationM->getProperty());?>">
               <?php 
                     self::$loggerM->trace("The [ ".self::$tbConfigurationM->getProperty().
                            " ] type data is [ " . self::$tbConfigurationM->getDataType() .
                           " ]");
                     
               ?>
               <input type="number" 
                      value="<?php print (self::$tbConfigurationM->getValue());?>" style="width: 50px">
               
            </div>
           
         </div>
      </div>
      <?php 
         self::$loggerM->trace("Format the DataGrid");
      ?>
      <script type="text/javascript">
         DataGrid.format($('#DataConfiguration'),{width:"600px",
                                               columnsWidth: {0:"200px",1:"300px",2:"100px"}});
      </script>
      <?php 
         self::$loggerM->trace("Define the callback for cakes directory");
      ?>
      <script type="text/javascript">
         JSLogger.getInstance().trace("Define function callback showDirectoryCakes");
         functionShowDirectoryCakes = function (theData){

            var message = "Data: " + theData.path + ". Type: "+ (theData.file?"File":"Directory");;
            JSLogger.getInstance().debug("Callback : " + message);
            $('#Input-Cakes-Directory').val(theData.path);
            //JSLogger.getInstance().debug("VALOR:" +$('#Data_Path_Cursos').val());
        }
         JSLogger.getInstance().trace("Add click event to the button #Button-Image-Cakes-Directory");
         $('#Button-Image-Cakes-Directory').click(function(){
            fileBrowser = new FileBrowser(
                  {path:{
                        root_path:<?php printf("\"%s\"",$_SERVER['DOCUMENT_ROOT']);?>,
                        current_path: $('#Input-Cakes-Directory').val()},
                        type: "d", filter: "*.*", 
                        callback: functionShowDirectoryCakes,
                        Title_Params:{
                           Caption:"Selecciona el directorio donde se guardan las cakes",
                           Background_Color:"orange"},
                 toolbar:"create_folder|delete"});
         });
      </script>
      <?php 
         self::$loggerM->trace("Define the callback for cookies directory");
      ?>
      <script type="text/javascript">
         JSLogger.getInstance().trace("Define function callback showDirectoryCookies");
         functionShowDirectoryCookies = function (theData){

            var message = "Data: " + theData.path + ". Type: "+ (theData.file?"File":"Directory");
            JSLogger.getInstance().debug("Callback : " + message);
            $('#Input-Cookies-Directory').val(theData.path);
            //JSLogger.getInstance().debug("VALOR:" +$('#Data_Path_Cursos').val());
        }
         JSLogger.getInstance().trace("Add click event to the button #Button-Image-Cakes-Directory");
         $('#Button-Image-Cookies-Directory').click(function(){
            fileBrowser = new FileBrowser(
                  {path:{
                        root_path:<?php printf("\"%s\"",$_SERVER['DOCUMENT_ROOT']);?>,
                        current_path: $('#Input-Cookies-Directory').val()
                        },
                        type: "d", filter: "*.*", 
                        callback: functionShowDirectoryCookies,
                        Title_Params:{
                           Caption:"Selecciona el directorio donde se guardan las cookies",
                           Background_Color:"orange"},
                    toolbar:"create_folder|delete"
                    });
         });
      </script>
      <?php 
         self::$loggerM->trace("Define the callback for models directory");
      ?>
      <script type="text/javascript">
         JSLogger.getInstance().trace("Define function callback showDirectoryModels");
         functionShowDirectoryModels = function (theData){

            var message = "Data: " + theData.path + ". Type: "+ (theData.file?"File":"Directory");;
            JSLogger.getInstance().debug("Callback : " + message);
            $('#Input-Models-Directory').val(theData.path);
            //JSLogger.getInstance().debug("VALOR:" +$('#Data_Path_Cursos').val());
        }
         JSLogger.getInstance().trace("Add click event to the button #Button-Image-Models-Directory");
         $('#Button-Image-Models-Directory').click(function(){
            fileBrowser = new FileBrowser(
                  {path:{
                           root_path:<?php printf("\"%s\"",$_SERVER['DOCUMENT_ROOT']);?>,
                           current_path: $('#Input-Models-Directory').val()
                        },
                    type: "d", filter: "*.*", 
                    callback: functionShowDirectoryModels,
                    Title_Params:{
                         Caption:"Selecciona el directorio donde se guardan los modelados",
                         Background_Color:"orange"
                                  },
                    toolbar:"create_folder|delete"
                  });
         });
      </script>
      <?php 
         self::$loggerM->trace("Define the callback for slide images directory");
      ?>
      <script type="text/javascript">
         JSLogger.getInstance().trace("Define function callback showDirectorySlideImages");
         functionShowDirectoryModels = function (theData){

            var message = "Data: " + theData.path + ". Type: "+ (theData.file?"File":"Directory");;
            JSLogger.getInstance().debug("Callback : " + message);
            $('#Input-SlideImages-Directory').val(theData.path);
            //JSLogger.getInstance().debug("VALOR:" +$('#Data_Path_Cursos').val());
        }
         JSLogger.getInstance().trace("Add click event to the button #Button-Image-Models-Directory");
         $('#Button-SlideImages-Directory').click(function(){
            fileBrowser = new FileBrowser(
                  {path:{
                           root_path:<?php printf("\"%s\"",$_SERVER['DOCUMENT_ROOT']);?>,
                           current_path: $('#Input-SlideImages-Directory').val()
                        },
                    type: "d", filter: "*.*", 
                    callback: functionShowDirectoryModels,
                    Title_Params:{
                         Caption:"Selecciona el directorio desde donde buscaras las imagenes del inicio",
                         Background_Color:"orange"
                                  },
                    toolbar:"create_folder|delete"
                  });
         });
      </script>
<?php 
      self::$loggerM->trace("Add button save configuration");
      
?>
   <div style="clear: left"></div>
   <div id="Button-Save-Configuration" class="Round-Corners-Button">
      Guardar
   </div>
<?php 
      self::$loggerM->trace("Declare function to save the configuration when its corresponding button is pressed");
?>
   <script type="text/javascript">
      JSLogger.getInstance().trace("Define function save configuracion");
      saveConfiguration = function (){
         JSLogger.getInstance().traceEnter();
         JSLogger.getInstance().trace("Trying save the configuration in the DDBB");
         //Create the ajax object to send the step data to the server with the data base
         var ajaxObject = new Ajax()
         ajaxObject.setSyn();
         ajaxObject.setPostMethod();
         JSLogger.getInstance().trace("The url where the request is send is [ " 
               +    $('#Input-Url').val() +"/php/Database/RequestFromWeb.php ]");
         ajaxObject.setUrl($('#Input-Url').val() +"/php/Database/RequestFromWeb.php");
         var requestParams = {};
         requestParams.<?php print(COMMAND);?> = <?php print("\"".COMMAND_UPDATE."\"");?>;
         requestParams.<?php print(PARAMS);?> = {};
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = <?php print("\""
                                 .TB_Configuration::TB_ConfigurationTableC."\"");?>;
         JSLogger.getInstance().trace("Get all data configuration");
         var rows = {};
         $('#DataConfiguration .Data-Grid-Row .Data-Grid-Column input').each(function(theIndex){
            var property = $(this).parent().attr('id');
            var value = $(this).val();
            var row = {};
            row.<?php print(PARAM_KEY);?> = property;
            row.<?php print(TB_Configuration::ValueColumnC);?> = value;
            JSLogger.getInstance().trace("Property [ " + property +" ] -> [ " + value +" ]");
            rows[theIndex] = row;
         });
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?> = rows;
         JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

         ajaxObject.setParameters(JSON.stringify(requestParams));
         
         ajaxObject.send();
         JSLogger.getInstance().trace("Response [ " + ajaxObject.getResponse() + " ]");

         if (ajaxObject.getResponse().indexOf("404 Not Found") != -1){
            JSLogger.getInstance().error("The script [ " + $('#Input-Url').val() +
                  "/php/Database/RequestFromWeb.php ] has been found");
            MessageBox("Error", 
                  "La configuración no se ha guardado. No se ha podido acceder al script en el servidor",
                  {Icon: MessageBox.IconsE.ERROR});
         }else{
            var objResponse = JSON.parse(ajaxObject.getResponse());
            if (parseInt(objResponse['ResultCode']) != 200){
                     MessageBox("Error", 
                        "La configuración no se ha guardado. Error [ " +
                        objResponse['ErrorMsg'] + " ]",
                        {Icon: MessageBox.IconsE.ERROR});
                   JSLogger.getInstance().error("La configuracion no se ha guardado. [ " +
                         objResponse['ErrorMsg'] + " ]");
            }else{
              
               JSLogger.getInstance().trace("La configuración se ha guardado correctamente");
            }
         }
         JSLogger.getInstance().traceExit();
      }
      $('#Button-Save-Configuration').click(saveConfiguration);
   </script>
<?php 
      self::$loggerM->trace("Exit");
   }

   /**
    * Show the home page
    * 
    */   
   public static function getHome(){

      self::createLogger();
      self::$loggerM->trace("Enter");
?>
   <div id="Header-Home">
      <div id="Tittle-Header-Home">Imagenes que se muestran en la pagina principal</div>
      <div id="Button-AddImageInHome" class="Round-Corners-Button">Añadir Imagen</div>
   </div>
      
   
<?php
      $tbSlidesImageHome = new TB_SlideImagesHome();
      $tbSlidesImageHome->open();
      self::$tbConfigurationM->rewind();
      self::$tbConfigurationM->searchByKey(URL_C);
?>
      <div id="Images-Home-Container">
      <div id="DataGrid-Images-Home" class="Data-Grid">
<?php 
      while ($tbSlidesImageHome->next()){
?>
         <div id="<?php print($tbSlidesImageHome->getId());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
               <img alt="<?php print(self::$tbConfigurationM->getValue().$tbSlidesImageHome->getPath())?>" 
                     src="<?php print(self::$tbConfigurationM->getValue().$tbSlidesImageHome->getPath())?>"
                     style="width: 100px">
            </div>
            <div class="Data-Grid-Column">
               <div class="Round-Corners-Button">
                  Eliminar
               </div>
            </div>
         </div>
<?php 
      }
?>
      </div>
      </div>
      <script type="text/javascript">
         DataGrid.format($('#DataGrid-Images-Home'),{width:"250px",
                        columnsWidth: {0:"150px",1:"100px"}});
      </script>
<?php
      self::$loggerM->trace("Define function refrehs image slide");
?>
      <script type="text/javascript">
         /**
          * Refreshes the list of imanges that compose the image slide in home
          *
          * theParams: [in]. Array (json) with the paremeters
          *                      theId: The slide image id
          *                      thePath: The path of the image. When this 
          *                               When this paremeter is not present, then
          *                               the object must be removed.
          */
         var functionRefreshImageSlide = function(theParams){
            JSLogger.getInstance().trace("Enter");
            var id = theParams['theId'];
            var path = theParams['thePath'];
            JSLogger.getInstance().trace("The Id is [ " + id + " ]");
            if (typeof(path) == "string"){
               JSLogger.getInstance().trace("The path is [ " + path + " ]");
               var widthFirstCol = $('#DataGrid-Images-Home .Data-Grid-Row').first().find(".Data-Grid-Column").first().css("width");
               var widthLastCol = $('#DataGrid-Images-Home .Data-Grid-Row').first().find(".Data-Grid-Column").last().css("width");
               JSLogger.getInstance().trace("The witdh first column [ " + widthFirstCol +" ] and width last column [ " + widthLastCol +" ]");
               var newRow = $('<div id="' + id +'" class="Data-Grid-Row"></div>');
               newRow.append('<div class="Data-Grid-Column" style="width:'+widthFirstCol+'"><img style="width:100px" src="'+
                     path + '"></img></div>');
               newRow.append('<div class="Data-Grid-Column" style="width:'+widthLastCol+'"><div class="Round-Corners-Button">Eliminar</div></div>');
               newRow.find('.Round-Corners-Button').click(function(){
                  functionRemoveImageSlide(id);
               });
               $("#DataGrid-Images-Home").prepend(newRow);
            }else{
               JSLogger.getInstance().trace("The path is not present, removing the slide image with id [ " + id + " ]");
               $("#DataGrid-Images-Home #"+id).remove();
            }

            
            JSLogger.getInstance().trace("Exit");
         }
      </script>
<?php 
      self::$loggerM->trace("Define function to remove image from image slide in home");
?>
   <script type="text/javascript">
      var idToRemove = 0;
      var functionRemoveImageSlideInServer = function(){
         JSLogger.getInstance().trace("Enter");
         JSLogger.getInstance().debug("Trying remove image slide with id [ " + idToRemove + " ]");
         var ajaxObject = new Ajax();
         ajaxObject.setSyn();
         ajaxObject.setPostMethod();
         <?php 
            self::$tbConfigurationM->rewind();
            self::$tbConfigurationM->searchByKey(URL);
         ?>
         JSLogger.getInstance().debug("Url where the request for remove a slide image will be sent [ <?php print(self::$tbConfigurationM->getValue())?>" 
                +"php/Database/RequestFromWeb.php ]");
         ajaxObject.setUrl("<?php print(self::$tbConfigurationM->getValue())?>php/Database/RequestFromWeb.php");
         var requestParams = {};
         requestParams.<?php print(COMMAND);?> = "<?php print(COMMAND_DELETE);?>";
         requestParams.<?php print(PARAMS);?> = {};
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?>="<?php print(TB_SlideImagesHome::TB_SlideImagesHomeTableC);?>";
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_KEY);?>=idToRemove;

         JSLogger.getInstance().debug("Request Parameters [ " + JSON.stringify(requestParams) + " ]");

         ajaxObject.setParameters(JSON.stringify(requestParams));

         ajaxObject.send();
         JSLogger.getInstance().trace("Response [ " + ajaxObject.getResponse() + " ]");

         if (ajaxObject.getResponse().indexOf("404 Not Found") != -1){
            JSLogger.getInstance().error("The script [ <?php print(self::$tbConfigurationM->getValue())?>php/Database/RequestFromWeb.phpRequestFromWeb.php ] has been found");
            MessageBox("Error", 
                  "La imagen no se ha borrado del slide image."+
                    ". No se ha podido acceder al script [ <?php print(self::$tbConfigurationM->getValue())?>php/Database/RequestFromWeb.php ]",
                  {Icon: MessageBox.IconsE.ERROR});
         }else{
            var objResponse = JSON.parse(ajaxObject.getResponse());
            if (parseInt(objResponse['ResultCode']) != 200){
                     MessageBox("Error", 
                        "La imagen no se ha borrado del slide image."+ 
                        " Error [ " +
                        objResponse['ErrorMsg'] + " ]",
                        {Icon: MessageBox.IconsE.ERROR});
                   JSLogger.getInstance().error("The slide image has been not removed. [ " +
                         objResponse['ErrorMsg'] + " ]");
            }else{
              
               JSLogger.getInstance().debug("The slide image was removed successfully");
               var parameters = {};
               parameters.theId = idToRemove;
               JSLogger.getInstance().debug("Refreshing list home slide images with paremeters [ " + JSON.stringify(parameters) +" ]");
               functionRefreshImageSlide(parameters);
            }
         }
        
         JSLogger.getInstance().trace("Exit");
      }
      /**************************************************************************/
      var functionRemoveImageSlide = function(theId){
         JSLogger.getInstance().trace("Enter");
         JSLogger.getInstance().trace("Removing the slide image with Id [ " + theId +" ]");
         var pathFile = $('#DataGrid-Images-Home #'+theId+ ' .Data-Grid-Column img').attr('src');
         idToRemove = theId;
<?php 
         self::$tbConfigurationM->rewind();
         self::$tbConfigurationM->searchByKey(URL_C);
?>
         pathFile = pathFile.substr(<?php print(strlen(self::$tbConfigurationM->getValue()));?>);
         JSLogger.getInstance().trace("src [ " + pathFile +  " ]");
          
         MessageBox("Eliminar imagen",
                    "¿Quieres eliminar la image \""+pathFile+"\" de las imagenes del inicio?",
                    {Icon: MessageBox.IconsE.QUESTION,
                     Buttons: {Buttons: MessageBox.ButtonsE.YES_NO, 
                        Callback_Yes: functionRemoveImageSlideInServer}
                    }
         );
         JSLogger.getInstance().trace("Exit");
      }
   </script>

<?php 
      self::$loggerM->trace("Add remove function to all remove image");
?>
   <script type="text/javascript">
      $('#DataGrid-Images-Home .Data-Grid-Row').each(function(theIndex){

            var id = $(this).attr('id');
            
            $(this).find('.Round-Corners-Button').click(function(){
               functionRemoveImageSlide(id);
            });
      });
   </script>


<?php
      self::$loggerM->trace("Add functionality to the Add Image slide button.");
      self::$tbConfigurationM->rewind();
      self::$tbConfigurationM->searchByKey(SLIDE_IMAGE_DIRECTORY_C);
?>
       <script type="text/javascript">
         JSLogger.getInstance().trace("Define function callback to add image in slide home");
         functionAddImageSlideHome = function (theData){

            
            var message = "Data: " + theData.path + ". Type: "+ (theData.file?"File":"Directory");;
            JSLogger.getInstance().debug("Callback : " + message);
<?php 
                  self::$tbConfigurationM->rewind();
                  self::$tbConfigurationM->searchByKey(URL_C);
?>
            JSLogger.getInstance().trace("Trying save the image in slide images home");
            //Create the ajax object to send the step data to the server with the data base
            var ajaxObject = new Ajax()
            ajaxObject.setSyn();
            ajaxObject.setPostMethod();
            JSLogger.getInstance().trace("The url where the request is send is [ " 
                     + <?php print("\"".self::$tbConfigurationM->getValue()."\"");?> 
                     +"/php/Database/RequestFromWeb.php ]");
            ajaxObject.setUrl(<?php print("\"".self::$tbConfigurationM->getValue()."\"");?> 
                        +"/php/Database/RequestFromWeb.php");
            
            var requestParams = {};
            requestParams.<?php print(COMMAND);?> = <?php print("\"".COMMAND_INSERT."\"");?>;
            requestParams.<?php print(PARAMS);?> = {};
            requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = <?php print("\""
                        .TB_SlideImagesHome::TB_SlideImagesHomeTableC."\"");?>;

            requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
            requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_SlideImagesHome::PathColumnC);?> = theData.path;

            
            JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

            ajaxObject.setParameters(JSON.stringify(requestParams));

            ajaxObject.send();
            JSLogger.getInstance().trace("Response [ " + ajaxObject.getResponse() + " ]");

            if (ajaxObject.getResponse().indexOf("404 Not Found") != -1){
               JSLogger.getInstance().error("The script [ " + <?php print("\"".self::$tbConfigurationM->getValue()."\"");?> +
                     "/php/Database/RequestFromWeb.php ] has been found");
               MessageBox("Error", 
                     "La imagen no ha podido ser añadida.",
                     {Icon: MessageBox.IconsE.ERROR});
            }else{
               var objResponse = JSON.parse(ajaxObject.getResponse());
               if (parseInt(objResponse['ResultCode']) != 200){
                        MessageBox("Error", 
                           "La imagen no ha podido ser añadida. Error [ " +
                           objResponse['ErrorMsg'] + " ]",
                           {Icon: MessageBox.IconsE.ERROR});
                      JSLogger.getInstance().error("La imagen no ha podido ser añadida. [ " +
                            objResponse['ErrorMsg'] + " ]");
               }else{
                  var refreshParams = {};
                  refreshParams.theId = objResponse['lastID'];
                  refreshParams.thePath = <?php print("\"".self::$tbConfigurationM->getValue()."\"");?> + "/" + theData.path;
                  JSLogger.getInstance().trace("Calling refresh function with parameters [ " +
                        JSON.stringify(refreshParams));
                  functionRefreshImageSlide(refreshParams);
                  JSLogger.getInstance().trace("La imagen se añadio correctamente");
               }
            }
           
            //$('#Input-SlideImages-Directory').val(theData.path);
            //JSLogger.getInstance().debug("VALOR:" +$('#Data_Path_Cursos').val());
        }
<?php   
         self::$tbConfigurationM->rewind();
         self::$tbConfigurationM->searchByKey(SLIDE_IMAGE_DIRECTORY_C);
?>
        JSLogger.getInstance().trace("Add click event to the button #Button-Image-Models-Directory");
        $('#Button-AddImageInHome').click(function(){
            fileBrowser = new FileBrowser(
                  {path:{
                           root_path:<?php printf("\"%s\"",$_SERVER['DOCUMENT_ROOT']);?>,
                           current_path: <?php print("\"".self::$tbConfigurationM->getValue()."\"");?>
                        },
                    type: "a", filter: "*.*", 
                    callback: functionAddImageSlideHome,
                    Title_Params:{
                         Caption:"Selecciona una imagen...",
                         Background_Color:"orange"
                         },
                    toolbar: "upload_file|create_folder|delete"
                  });
         });
      </script>
<?php 
      self::$loggerM->trace("Exit");
      
   }

/**
 * Gets the kind imges by collection and shows the magement page
 * 
 * @param theType: [in] The menu Id that it is corresponding with a collection
 * @param theCollectionTable [in]: The table with the collections
 * @param theTypeCollectionImage [in]: The table with the images
 * 
 */
   static public function getImagesByType($theMenuId, 
         TB_MenuCollection $theCollectionTable,
         TB_TypeCollectionImage $theTypeCollectionImageTable){
      
      self::createLogger();
      self::$loggerM->trace("Enter");
      self::$loggerM->trace("The images type is [ ". 
            (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")) ." ]");
      
      $theCollectionTable->rewind();
      $theCollectionTable->searchByColumn(TB_MenuCollection::MenuIdColumnC, $theMenuId);
?>
      <div class="CollectionList">
         <div class="Header-Middle">
            Colecciones
         </div>
         <div class="Header-Middle">
               <div id="btnAdd<?php printf("%s", (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")));?>" class="Round-Corners-Button">
                  Añadir
               </div>
         </div>
         <div id="<?php printf("%s", (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")));?>CollectionsList" class="ListBox">
         </div>
      </div>
      
<?php
      self::$loggerM->trace("Add the functionalty to open the new collection window in the button");
      
?>
   <script type="text/javascript">
      JSLogger.getInstance().trace("Add click event to open new collection window to [ " + 
          "<?php printf("%s", (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")));?> ]");
      $('#btnAdd<?php printf("%s", (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")));?>').click(
            function(){
                  DataEntryWindow.show('#WindowAddCollection', insertNewCollection, 
                  {size:{width:'500px',height:'130px'}, dataToAdd:{typeId: <?php print(($theMenuId - 1 ));?>}});
            });
   </script>
   
   <div id="<?php printf("%s", (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")));?>Images" class="ImagesList">
   
<?php 
      $collectionName = "";
      $isFirtsGrid = true;
      $elementsInRow = 0;
      $elementsPerRow = self::$tbConfigurationM->searchByColumn(TB_Configuration::PropertyColumnC, 'numberThumbnails');
      while ($theCollectionTable->next()){
         
?>
      
      <script type="text/javascript">
         var text = '<div class="ListBoxItem" id="Collection_<?php print($theCollectionTable->getCollectionId());?>"><?php print($theCollectionTable->getCollectionName());?></div>';
         JSLogger.getInstance().trace('Add collection [ ' + text + ' ] in [ # <?php printf("%s", (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")));?>CollectionList ]');
         $('#<?php printf("%s", (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")));?>CollectionsList').append(text);
<?php    
         self::$loggerM->trace("Add option [ <div id=\"".
               $theCollectionTable->getCollectionId()."\">".$theCollectionTable->getCollectionName()."</div> ] in ".
               " div with id [ #". (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")).
                     "CollectionList ]");
?>
      </script>
<?php 
         self::$tbConfigurationM->rewind();
         self::$tbConfigurationM->searchByKey(URL_C);
         $theTypeCollectionImageTable->rewind();
         self::$loggerM->trace("Searching images for collection [ " . $theCollectionTable->getCollectionId() ." ]");
         $thereAreImages = $theTypeCollectionImageTable->searchByColumn(
                         TB_TypeCollectionImage::CollectionIdColumnC,
                         $theCollectionTable->getCollectionId());
         if ($thereAreImages){
            self::$loggerM->trace("Get the images from the collection [ " . 
                  $theTypeCollectionImageTable->getCollectionId() . " ].[ ". 
                  $theTypeCollectionImageTable->getCollectionName() ." ] has [ " .
                  $theTypeCollectionImageTable->getCardinality() ." ] images");
         }else{
            self::$loggerM->trace("The collection has not images");
         }
         //Hay que añadir en el grid, en la primera posicion, el añadir foto
         if($isFirtsGrid){
            $isFirtsGrid = false;
?>
            <div class="Grid" id="Grid_Collection_<?print($theCollectionTable->getCollectionId());?>">
<?php 
         }else{
?>
            <div class="Grid Grid-Hidden" id="Grid_Collection_<?print($theCollectionTable->getCollectionId());?>">
<?php 
         }
?>
         
         <div class="Grid-Element">
            <div class="Round-Corners-Button Add-Picture-Collection" id="Add-Picture-Collection_<?php print($theCollectionTable->getCollectionId());?>">Añadir Foto</div>
         </div>
            
<?php 
            self::$tbConfigurationM->rewind();
            if (($theMenuId -1) == 1){
               (self::$tbConfigurationM->searchByColumn(TB_Configuration::PropertyColumnC, IMAGES_CAKES_DIRECTORY_C));
               
            }else{
               if (($theMenuId -1) == 2){
                  
                  (self::$tbConfigurationM->searchByColumn(TB_Configuration::PropertyColumnC, IMAGES_COOKIES_DIRECTORY_C));
                
               }else{
                  (self::$tbConfigurationM->searchByColumn(TB_Configuration::PropertyColumnC, IMAGES_MODELS_DIRECTORY_C));
               }
            }
?>
        <script type="text/javascript">
            $('#Add-Picture-Collection_<?php print($theCollectionTable->getCollectionId());?>').click(function(){
               openFilebrowserSelectImage(<?php printf("\"%s/%s\"",$_SERVER['DOCUMENT_ROOT'],
                     self::$tbConfigurationM->getValue());?>,
                     "<?print($theCollectionTable->getCollectionName());?>");
              
            });
         </script>
<?php 
         if ($thereAreImages){
            self::$tbConfigurationM->rewind();
            self::$tbConfigurationM->searchByKey(URL_C);
            while ($theTypeCollectionImageTable->next()){
               self::$loggerM->trace("Add the image [ ".
                  $theTypeCollectionImageTable->getImagePath() ." ]");
         
?>
            
            <div class="Grid-Element">
               <div class="Grid-Image" id="image_<?php print($theTypeCollectionImageTable->getTypeCollectionImageId());?>">
                  <img src="<?php print(self::$tbConfigurationM->getValue().$theTypeCollectionImageTable->getImagePath());?>" title="<?php print($theTypeCollectionImageTable->getImageDescription());?>"/>
               </div>
               <div class="ImageToolbar" id="ImageToolBar_<?php print($theTypeCollectionImageTable->getTypeCollectionImageId());?>">
                  <div class="UpdateImage Round-Corners-Button" id="UpdateImg_<?php print($theTypeCollectionImageTable->getTypeCollectionImageId());?>">
                     Modificar
                  </div>
                  <div class="RemoveImage Round-Corners-Button" id="RemoveImg_<?php print($theTypeCollectionImageTable->getTypeCollectionImageId());?>">
                     Eliminar
                  </div>
               </div>
               
            </div>
<?php 
            
           }
         }         
?>
         
      </div> <!-- Grid -->
<?php 
      }
?>
   </div>
<?php 
     
      self::$loggerM->trace("Exit");
   }
   
/**
 * Funtion that add funcionality to the buttons for open a filebrowser allows select a image
 */
public static function addAddPictureClickEvent(){
   self::createLogger();
   self::$loggerM->trace("Enter");
?>
      <script type="text/javascript">
         JSLogger.getInstance().trace("AddAddPictureClickEvent Enter");
         JSLogger.getInstance().trace("Numero: " +$('.CollectionList>.ListBox>.ListBoxItem').size());
         $('.CollectionList>.ListBox>.ListBoxItem').each(function (theIndex){
               
               var id = $(this).attr('id');
               var collectionName = $(this).html();
               JSLogger.getInstance().trace("#"+theIndex+". Add commands in click event to ListBoxElement with id [ " + 
                         id + " ] and collectionName [ "+
                     collectionName +" ]");
               
               $('#'+id).click(function(){
                  JSLogger.getInstance().trace("Click event added to ListBoxItem id [ " +
                        $(this).attr('id')+" ] Enter");

                 
                  JSLogger.getInstance().trace("Hide all [ " + 
                        $('.Vertical-Tab:visible>.ImagesList>.Grid').size() +" ] grid in images list");
                  $('.Vertical-Tab:visible>.ImagesList>.Grid').addClass('Grid-Hidden');
                  JSLogger.getInstance().trace("Show the grid Id [ Grid_" + id +" ]");
                  $('#Grid_'+id).removeClass('Grid-Hidden');
                  
                  JSLogger.getInstance().trace("Click event added to ListBoxItem Exit");
               });
            }
         );
         JSLogger.getInstance().trace("AddAddPictureClickEvent Exit");
      
      </script>
<?php 
   self::$loggerM->trace("Exit");
}
} //class
   ?>
   
 