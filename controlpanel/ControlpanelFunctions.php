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
        
<?php 
      while ($tbConfiguration->next()){

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
               <input type="<?php if(strcmp($tbConfiguration->getDataType(), "Numeric") == 0){print("number");}else{print("text");}?>"
                      value="<?php print ($tbConfiguration->getValue());?>">
               
            </div>
            
         </div>
         
<?php 
      }
?>
      </div>
      <script type="text/javascript">
      DataGrid.format($('#DataConfiguration'),{width:"500px",
                                               columnsWidth: {0:"200px",1:"300px"}});
      </script>


<?php 
      $loggerCpF->trace("Exit");
   }
?>