<?php
/**
 * File with functions used by the control panel
 */
   
/********* includes *****/

/******** requires *****/
  

/********* Global Variables *****/
   $loggerCpF = LoggerMgr::Instance()->getLogger(basename(__FILE__));
/**
 * Gets the configuration from the database and it showed
 */
   function getConfiguration(){
      global $loggerCpF;
      $loggerCpF->trace("Enter");
      require_once 'database/TB_Configuration.php';
      //Define the constanst that allows access to the data configuration
      define(IMAGES_CAKES_DIRECTORY_C, 'cakesImagesPath');
      define(IMAGES_COOKIES_DIRECTORY_C, 'cookiesImagesPath');
      define(IMAGES_MODELS_DIRECTORY_C, 'modelsImagesPath');
      define(NUM_THUMBNAILS_C, 'numberThumbnails');
      define(THUMBNAILS_DIRECTORY_C, 'thumbnailsPath');
      define(URL_C, 'URL');
      
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
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?>>
               <?php 
                     $loggerCpF->trace("The [ ".$tbConfiguration->getProperty().
                            " ] type data is [ " . $tbConfiguration->getDataType() .
                           " ]");
                     
               ?>
               <input type="text" 
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
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?> >
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
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?> >
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
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?>>
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
      $tbConfiguration->searchByKey(THUMBNAILS_DIRECTORY_C);
?>
         <div id="DataConfiguration-<?php print ($tbConfiguration->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                 <?php printf ("%s: ", $tbConfiguration->getLabel());?>
            </div>
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?>>
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
            <div class="Data-Grid-Column" title=<?php printf("\"%s\"", $tbConfiguration->getDescription());?> >
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
         DataGrid.format($('#DataConfiguration'),{width:"575px",
                                               columnsWidth: {0:"175px",1:"300px",2:"100px"}});
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
      $loggerCpF->trace("Exit");
   }
?>