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
   $tbConfiguration = null;
/**
 * Gets the configuration from the database and it showed
 */
   function getConfiguration(){
      //require_once 'Database/RequestFromWeb.php';
      global $loggerCpF;
      global $tbConfiguration;
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
      global $tbConfiguration;

      $loggerCpF->trace("Enter");
?>
   <div id="Header-Home">
      <div id="Tittle-Header-Home">Imagenes que se muestran en la pagina principal</div>
      <div id="Button-AddImageInHome" class="Round-Corners-Button">Añadir Imagen</div>
   </div>
      
   
<?php
      $tbSlidesImageHome = new TB_SlideImagesHome();
      $tbSlidesImageHome->open();
      $tbConfiguration->rewind();
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
      $loggerCpF->trace("Define function refrehs image slide");
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
      $loggerCpF->trace("Define function to remove image from image slide in home");
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
            $tbConfiguration->rewind();
            $tbConfiguration->searchByKey(URL);
         ?>
         JSLogger.getInstance().debug("Url where the request for remove a slide image will be sent [ <?php print($tbConfiguration->getValue())?>" 
                +"php/Database/RequestFromWeb.php ]");
         ajaxObject.setUrl("<?php print($tbConfiguration->getValue())?>php/Database/RequestFromWeb.php");
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
            JSLogger.getInstance().error("The script [ <?php print($tbConfiguration->getValue())?>php/Database/RequestFromWeb.phpRequestFromWeb.php ] has been found");
            MessageBox("Error", 
                  "La imagen no se ha borrado del slide image."+
                    ". No se ha podido acceder al script [ <?php print($tbConfiguration->getValue())?>php/Database/RequestFromWeb.php ]",
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
         $tbConfiguration->rewind();
         $tbConfiguration->searchByKey(URL_C);
?>
         pathFile = pathFile.substr(<?php print(strlen($tbConfiguration->getValue()));?>);
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
      $loggerCpF->trace("Add remove function to all remove image");
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
                  var refreshParams = {};
                  refreshParams.theId = objResponse['lastID'];
                  refreshParams.thePath = <?php print("\"".$tbConfiguration->getValue()."\"");?> + "/" + theData.path;
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

/**
 * Gets the kind imges by collection and shows the magement page
 * 
 * @param theType: [in] The menu Id that it is corresponding with a collection
 * @param theCollectionTable [in]: The table with the collections
 * @param theTypeCollectionImage [in]: The table with the images
 * 
 */
   function getImagesByType($theMenuId, 
         TB_MenuCollection $theCollectionTable,
         TB_TypeCollectionImage $theTypeCollectionImageTable){
      
      global $loggerCpF;
      global $tbConfiguration;
      $loggerCpF->trace("Enter");
      $loggerCpF->trace("The images type is [ ". 
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
      $loggerCpF->trace("Add the functionalty to open the new collection window in the button");
      
?>
   <script type="text/javascript">
      JSLogger.getInstance().trace("Add click event to open new collection window to [ " + 
          "<?php printf("%s", (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")));?> ]");
      $('#btnAdd<?php printf("%s", (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")));?>').click(
            function(){
                  DataEntryWindow.show('.DataEntryWindow', null, {size:{width:'500px',height:'150px'}});
            });
   </script>
   
   <div id="<?php printf("%s", (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")));?>Images" class="ImagesList">
   
<?php 
      $collectionName = "";
      $isFirtsGrid = true;
      $elementsInRow = 0;
      $elementsPerRow = $tbConfiguration->searchByColumn(TB_Configuration::PropertyColumnC, 'numberThumbnails');
      while ($theCollectionTable->next()){
         
?>
      
      <script type="text/javascript">
         var text = '<div class="ListBoxItem" id="Collection_<?php print($theCollectionTable->getCollectionId());?>"><?php print($theCollectionTable->getCollectionName());?></div>';
         JSLogger.getInstance().trace('Add collection [ ' + text + ' ] in [ # <?php printf("%s", (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")));?>CollectionList ]');
         $('#<?php printf("%s", (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")));?>CollectionsList').append(text);
<?php    
         $loggerCpF->trace("Add option [ <div id=\"".
               $theCollectionTable->getCollectionId()."\">".$theCollectionTable->getCollectionName()."</div> ] in ".
               " div with id [ #". (($theMenuId - 1 ) == 1 ? "Cakes": (($theMenuId - 1 ) == 2 ? "Cookies" : "Models")).
                     "CollectionList ]");
?>
      </script>
<?php 
         $theTypeCollectionImageTable->rewind();
         $theTypeCollectionImageTable->searchByColumn(
                         TB_TypeCollectionImage::CollectionIdColumnC,
                         $theCollectionTable->getCollectionId());
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
         <div class="Grid-Row">
            <div class="Grid-Element">
               <div class="Round-Corners-Button" id="Add-Picture-Collection_<?php print($theCollectionTable->getCollectionId());?>">Añadir Foto</div>
            </div>
            
         <script type="text/javascript">
            JSLogger.getInstance().trace("Add funcionality to the add collection picture button");
<?php 
            $tbConfiguration->rewind();
            if (($theMenuId -1) == 1){
               ($tbConfiguration->searchByColumn(TB_Configuration::PropertyColumnC, IMAGE_CAKES_DIRECTORY_C));
               
            }else{
               if (($theMenuId -1) == 2){
                  ($tbConfiguration->searchByColumn(TB_Configuration::PropertyColumnC, IMAGES_COOKIES_DIRECTORY_C));
                
               }else{
                  ($tbConfiguration->searchByColumn(TB_Configuration::PropertyColumnC, IMAGES_MODELS_DIRECTORY_C));
               }
            }
?>
            $('#Add-Picture-Collection_<?php print($theCollectionTable->getCollectionId());?>').click(function(){
               fileBrowser = new FileBrowser(
                     {path:{
                           root_path:<?php printf("\"%s\"",$_SERVER['DOCUMENT_ROOT']);?>,
                           current_path: "<?php print($tbConfiguration->getValue());?>"
                           },
                       type: "a", filter: "*.*", 
                       callback: function(){alert('Siii')},
                       Title_Params:{
                            Caption:"Selecciona la foto que quieras añadir a \"<?print($theCollectionTable->getCollectionName());?>\"",
                            Background_Color:"orange"
                                     },
                       toolbar:"upload_file|create_folder|delete"
                     });
            });
         </script>
<?php 
         $elementsInRow ++;
         while ($theTypeCollectionImageTable->next()){
            $loggerCpF->trace("Add the image [ $theTypeCollectionImageTable->getImagePath()/$theTypeCollectionImageTable->getImageName() ]");
            if  ($elementsInRow == $elementsPerRow) {
               $elementsInRow = 0;
?> 
        </div><!-- Grid-Row -->
        <div class="Grid-Row">
<?php
            } 
?>
            <div class="Grid-Element">
            </div>
<?php 
              $elementsPerRow ++;
           }
                     
?>
         </div><!-- Grid-Row -->
      </div> <!-- Grid -->
<?php 
      }
?>
   </div>
<?php 
      $loggerCpF->trace("Exit");
   }
   
/**
 * Funtion that add funcionality to the buttons for open a filebrowser allows select a image
 */
function addAddPictureClickEvent(){
   global $loggerCpF;
   $loggerCpF->trace("Enter");
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
   $loggerCpF->trace("Exit");
}
   ?>
   
 