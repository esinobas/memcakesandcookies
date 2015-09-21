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

/********* Global Variables *****/
   $loggerCpF = LoggerMgr::Instance()->getLogger(basename(__FILE__));
/**
 * Gets the configuration from the database and it showed
 */
   function getConfiguration(){
      //require_once 'Database/RequestFromWeb.php';
      global $loggerCpF;
      $loggerCpF->trace("Enter");
      
      $tbConfiguration = new TB_Configuration();
      $tbConfiguration->open();
     
?>
      <div id="DataConfiguration" class="Data-Grid">
        
<?php 
      $tbConfiguration->searchByKey(URL_C);
?>
         <div id="DataConfiguration-<?php print ($tbConfiguration->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", $tbConfiguration->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?>
                id="<?php print($tbConfiguration->getProperty());?>">
               <?php 
                     $loggerCpF->trace("The [ ".$tbConfiguration->getProperty().
                            " ] type data is [ " . $tbConfiguration->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" id="Input-Url"
                      value="<?php print ($tbConfiguration->getValue());?>">
               
            </div>
            <div class="Data-Grid-Column">
            </div>
         </div>
<?php
      $tbConfiguration->rewind();
      $tbConfiguration->searchByKey(IMAGES_CAKES_DIRECTORY_C);
?>
         <div id="DataConfiguration-<?php print ($tbConfiguration->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", $tbConfiguration->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?> 
               id="<?php print($tbConfiguration->getProperty());?>">
               <?php 
                     $loggerCpF->trace("The [ ".$tbConfiguration->getProperty().
                            " ] type data is [ " . $tbConfiguration->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" id="Input-Cakes-Directory"
                      value="<?php print ($tbConfiguration->getValue());?>" readonly>
               
            </div>
            <div class="Data-Grid-Column">
               <div class="Round-Corners-Button" id="Button-Image-Cakes-Directory">
                  Seleccionar
               </div>
            </div>
         </div>
<?php
      $tbConfiguration->rewind();
      $tbConfiguration->searchByKey(IMAGES_COOKIES_DIRECTORY_C);
?>
         <div id="DataConfiguration-<?php print ($tbConfiguration->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", $tbConfiguration->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?> 
               id="<?php print($tbConfiguration->getProperty());?>">
               <?php 
                     $loggerCpF->trace("The [ ".$tbConfiguration->getProperty().
                            " ] type data is [ " . $tbConfiguration->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" id="Input-Cookies-Directory"
                      value="<?php print ($tbConfiguration->getValue());?>" readonly>
               
            </div>
            <div class="Data-Grid-Column">
               <div class="Round-Corners-Button" id="Button-Image-Cookies-Directory">
                  Seleccionar
               </div>
            </div>
         </div>
<?php
      $tbConfiguration->rewind();
      $tbConfiguration->searchByKey(IMAGES_MODELS_DIRECTORY_C);
?>
         <div id="DataConfiguration-<?php print ($tbConfiguration->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", $tbConfiguration->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?>
               id="<?php print($tbConfiguration->getProperty());?>">
               <?php 
                     $loggerCpF->trace("The [ ".$tbConfiguration->getProperty().
                            " ] type data is [ " . $tbConfiguration->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" id="Input-Models-Directory"
                      value="<?php print ($tbConfiguration->getValue());?>" readonly>
               
            </div>
            <div class="Data-Grid-Column">
               <div class="Round-Corners-Button" id="Button-Image-Models-Directory">
                  Seleccionar
               </div>
            </div>
         </div>
<?php
      $tbConfiguration->rewind();
      $tbConfiguration->searchByKey(SLIDE_IMAGE_DIRECTORY_C);
?>
         <div id="DataConfiguration-<?php print ($tbConfiguration->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", $tbConfiguration->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?>
               id="<?php print($tbConfiguration->getProperty());?>">
               <?php 
                     $loggerCpF->trace("The [ ".$tbConfiguration->getProperty().
                            " ] type data is [ " . $tbConfiguration->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" id="Input-SlideImages-Directory"
                      value="<?php print ($tbConfiguration->getValue());?>" readonly>
               
            </div>
            <div class="Data-Grid-Column">
               <div class="Round-Corners-Button" id="Button-SlideImages-Directory">
                  Seleccionar
               </div>
            </div>
         </div>
<?php
      $tbConfiguration->rewind();
      $tbConfiguration->searchByKey(THUMBNAILS_DIRECTORY_C);
?>
         <div id="DataConfiguration-<?php print ($tbConfiguration->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", $tbConfiguration->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?>
                 id="<?php print($tbConfiguration->getProperty());?>">
               <?php 
                     $loggerCpF->trace("The [ ".$tbConfiguration->getProperty().
                            " ] type data is [ " . $tbConfiguration->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" 
                      value="<?php print ($tbConfiguration->getValue());?>">
               
            </div>

         </div>
         
<?php
      $tbConfiguration->rewind();
      $tbConfiguration->searchByKey(NUM_THUMBNAILS_C);
?>
         <div id="DataConfiguration-<?php print ($tbConfiguration->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", $tbConfiguration->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?> 
                     id="<?php print($tbConfiguration->getProperty());?>">
               <?php 
                     $loggerCpF->trace("The [ ".$tbConfiguration->getProperty().
                            " ] type data is [ " . $tbConfiguration->getDataType() .
                           " ]");
                     
               ?>
               <input type="number" 
                      value="<?php print ($tbConfiguration->getValue());?>" style="width: 50px">
               
            </div>
           
         </div>
      </div>
      <?php 
         $loggerCpF->trace("Format the DataGrid");
      ?>
      <script type="text/javascript">
         DataGrid.format($('#DataConfiguration'),{width:"600px",
                                               columnsWidth: {0:"200px",1:"300px",2:"100px"}});
      </script>
      <?php 
         $loggerCpF->trace("Define the callback for cakes directory");
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
         $loggerCpF->trace("Define the callback for cookies directory");
      ?>
      <script type="text/javascript">
         JSLogger.getInstance().trace("Define function callback showDirectoryCookies");
         functionShowDirectoryCookies = function (theData){

            var message = "Data: " + theData.path + ". Type: "+ (theData.file?"File":"Directory");;
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
         $loggerCpF->trace("Define the callback for models directory");
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
         $loggerCpF->trace("Define the callback for slide images directory");
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
      $loggerCpF->trace("Add button save configuration");
      
?>
   <div style="clear: left"></div>
   <div id="Button-Save-Configuration" class="Round-Corners-Button">
      Guardar
   </div>
<?php 
      $loggerCpF->trace("Declare function to save the configuration when its corresponding button is pressed");
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
      $loggerCpF->trace("Exit");
   }

   /**
    * Show the home page
    */   
   function getHome(){

      //require_once 'Database/RequestFromWeb.php';
      global $loggerCpF;

      $loggerCpF->trace("Enter");
?>
   <div id="Header-Home">
      <div id="Tittle-Header-Home">Imagenes que se muestran en la pagina principal</div>
      <div id="Button-AddImageInHome" class="Round-Corners-Button">Añadir Imagen</div>
   </div>
      
   
<?php
      $tbSlidesImageHome = new TB_SlideImagesHome();
      $tbSlidesImageHome->open();
      $tbConfiguration = new TB_Configuration();
      $tbConfiguration->open();
      $tbConfiguration->searchByKey(URL_C);
?>
      <div id="Images-Home-Container">
      <div id="DataGrid-Images-Home" class="Data-Grid">
<?php 
      while ($tbSlidesImageHome->next()){
?>
         <div id="<?php print($tbSlidesImageHome->getId());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
               <img alt="<?php print($tbConfiguration->getValue().$tbSlidesImageHome->getPath())?>" 
                     src="<?php print($tbConfiguration->getValue().$tbSlidesImageHome->getPath())?>"
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
      $loggerCpF->trace("Add functionality to the Add Image slide button.");
      $tbConfiguration->rewind();
      $tbConfiguration->searchByKey(SLIDE_IMAGE_DIRECTORY_C);
?>
       <script type="text/javascript">
         JSLogger.getInstance().trace("Define function callback to add image in slide home");
         functionAddImageSlideHome = function (theData){

            
            var message = "Data: " + theData.path + ". Type: "+ (theData.file?"File":"Directory");;
            JSLogger.getInstance().debug("Callback : " + message);
<?php 
                  $tbConfiguration->rewind();
                  $tbConfiguration->searchByKey(URL_C);
?>
            JSLogger.getInstance().trace("Trying save the image in slide images home");
            //Create the ajax object to send the step data to the server with the data base
            var ajaxObject = new Ajax()
            ajaxObject.setSyn();
            ajaxObject.setPostMethod();
            JSLogger.getInstance().trace("The url where the request is send is [ " 
                     + <?php print("\"".$tbConfiguration->getValue()."\"");?> 
                     +"/php/Database/RequestFromWeb.php ]");
            ajaxObject.setUrl(<?php print("\"".$tbConfiguration->getValue()."\"");?> 
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
               JSLogger.getInstance().error("The script [ " + <?php print("\"".$tbConfiguration->getValue()."\"");?> +
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
                 
                  JSLogger.getInstance().trace("La imagen se añadio correctamente");
               }
            }
           
            //$('#Input-SlideImages-Directory').val(theData.path);
            //JSLogger.getInstance().debug("VALOR:" +$('#Data_Path_Cursos').val());
        }
<?php   
         $tbConfiguration->rewind();
         $tbConfiguration->searchByKey(SLIDE_IMAGE_DIRECTORY_C);
?>
        JSLogger.getInstance().trace("Add click event to the button #Button-Image-Models-Directory");
        $('#Button-AddImageInHome').click(function(){
            fileBrowser = new FileBrowser(
                  {path:{
                           root_path:<?php printf("\"%s\"",$_SERVER['DOCUMENT_ROOT']);?>,
                           current_path: <?php print("\"".$tbConfiguration->getValue()."\"");?>
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
      $loggerCpF->trace("Exit");
      
   }
?>