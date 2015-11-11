<?php
/**
 * Abstract class with the static functions to management the page web news
 */

/** Includes **/

class ControlPanelNews{
   
   /** Private static properties **/
   
   /**
    * Object that allows write the log in a file
    * @var Logger
    */
   static private $loggerM = null;
   
   
   /** Private static funcions **/
   
   /**
    * Returns the logger that allows write the log in a file
    * @return Logger
    */
   static private function getLogger(){
      
      if (self::$loggerM == null){
         self::$loggerM = LoggerMgr::Instance()->getLogger(basename(__CLASS__));
      }
      return self::$loggerM;
   }
   
   /** Public functions **/
   
   /**
    * Writes the code html to show the News control
    */
   static public function showControlPanelNews(){
      self::getLogger()->trace("Enter");
?>
      <div id="News-Toolbar">
         <div id="New-News" class="Round-Corners-Button">
            Nueva
         </div>
         <div id="Delete-News" class="Round-Corners-Button">
            Eliminar
         </div>
         <div id="Save-News" class="Round-Corners-Button">
            Guardar
         </div>
         </div>
      
      <div id="Container-Listbox-News">
         <div id="Listbox-News" class="Listbox">
         
         </div>
      </div>
      
      <div id="Container-News">
      </div>
<?php 
      self::getLogger()->trace("Exit");
   }
}
?>