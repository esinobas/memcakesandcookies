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
      $tbConfiguration = new TB_Configuration();
      $tbConfiguration->open();
?>
      <div id="DataConfiguration" class="Data-Grid">
         <div id="DataConfiguration-Title" class="Data-Grid-Row Data-Grid-Title">
            <div id="DataConfiguration-Title-Column-Property" class="Data-Grid-Column">
               Propiedad
            </div>
            <div id="DataConfiguration-Title-Column-Value" class="Data-Grid-Column">
               Valor
            </div>
            <div id="DataConfiguration-Title-Column-Description" class="Data-Grid-Column">
               Descripción
            </div>
         </div>
<?php 
      while ($tbConfiguration->next()){

?>
         <div id="DataConfiguration-<?php print ($tbConfiguration->getProperty());?>" class="Data-Grid-Row">
            <div class="Data-Grid-Column">
                  <?php print ($tbConfiguration->getLabel());?>
            </div>
            <div class="Data-Grid-Column">
                  <?php print ($tbConfiguration->getValue());?>
            </div>
            <div class="Data-Grid-Column">
                  <?php print ($tbConfiguration->getDescription());?>
            </div>
         </div>
<?php 
      }
?>
   </div>
<?php 
      $loggerCpF->trace("Exit");
   }
?>