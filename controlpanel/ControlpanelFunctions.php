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
               <input type="text" 
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
               <input type="text" 
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
               <input type="text" 
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
      <script type="text/javascript">
      DataGrid.format($('#DataConfiguration'),{width:"575px",
                                               columnsWidth: {0:"175px",1:"300px",2:"100px"}});
      </script>


<?php 
      $loggerCpF->trace("Exit");
   }
?>