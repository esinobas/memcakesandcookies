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
   
   /**
    * Writes the javascript function apply the tinymce to the news title and 
    * news text
    */
   static private function writeJSFunctionApplyTinyMce(){
      self::getLogger()->trace("Enter");
?>
   <script type="text/javascript">
      /**
       * Add the Tinymce to the title and the html step
       *
       * @param theTitleSelector: The title selector
       * @param theTextSelector: The text selector
       */
      function applyTinymce (theTitleSelector, theTextSelector){
         JSLogger.getInstance().traceEnter();
         tinymce.init({
            selector: theTitleSelector,
            theme: "modern",
            inline: true,
            statusbar: false,
            //add_unload_trigger: false,
            schema: "html5",
            language: "es",
            //plugins: "textcolor",
            menubar: false,
            toolbar: false
            //toolbar: "bold italic underline | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify "
         });
         tinymce.init({
            selector: theTextSelector,
            theme: "modern",
            inline: true,
            statusbar: false,
            add_unload_trigger: false,
            schema: "html5",
            language: "es",
            plugins: "textcolor advlist image link lists",
            menubar: false,
            //toolbar1: "formatselect | undo redo | bold italic underline | fontselect fontsizeselect | forecolor backcolor",
            toolbar1: "undo redo | bold italic underline | fontsizeselect | forecolor backcolor",
            toolbar2: "alignleft aligncenter alignright alignjustify | outdent indent | bullist numlist | cut copy paste | image link"
         });
         JSLogger.getInstance().traceExit();
      }
   </script>
<?php 
      self::getLogger()->trace("Exit");
   }
   
   /**
    * Writes the javascript function to add a click event to the new news button
    */
   static private function writeJSFunctionNewNewsButtonClickEvent(){
      self::getLogger()->trace("Enter");
?>
      <script type="text/javascript">
         /** 
          * Function that add in the window the controls to create a new news
          */
         function addNewNewsControl(){
            JSLogger.getInstance().traceEnter();
            //Ocultar el resto de los container news
            var newContainerNews = $('<div class="News" id="New-News"></div>');
            newContainerNews.append('<div class="News-Title" id="New-Title">Pulsa para escribir el titulo</div>');
            newContainerNews.append('<div class="News-Text" id="New-Text">Pulsa para escribir</div>');
            $('#Container-News').append(newContainerNews);
            applyTinymce('#New-Title', '#New-Text');
            JSLogger.getInstance().traceExit();
         }

         $('#New-News').click(addNewNewsControl);
      </script>
<?php 
      self::getLogger()->trace("Exit");
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
      self::writeJSFunctionApplyTinyMce();
      self::writeJSFunctionNewNewsButtonClickEvent();
      self::getLogger()->trace("Exit");
   }
}
?>