/**
 * Class with the properties and methods for create a html form
 */

var HtmlForm = HtmlForm || function(){
   
   /*** Private constants ***/
   var TOOLBAR_PARAMS_C = "toolbar";
   
   
   /*** private properties ***/
   JSLogger.getInstance().registerLogger("HtmlForm", JSLogger.levelsE.WARN);
  
   /**
    * Constructor
    * 
    * @param theHtmlObject: Html Object that it is used like Form
    * @param theParams: The parameters for format the window.
    */
   function HtmlForm(theHtmlObject, theParams){
      JSLogger.getInstance().traceEnter();
      HtmlWindow.call(this, theHtmlObject, theParams);
      this.setToolbar();
      JSLogger.getInstance().traceExit();
   };
   
   /**
    * Private function for define the setToolbar
    */
   var setToolbar = function setToolbar(){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().info("The method setToolbar must be overwrite in a child class.");
      JSLogger.getInstance().traceExit();
   };
   
   HtmlForm.prototype = Object.create(HtmlWindow.prototype);
   HtmlForm.prototype.constructor = HtmlForm;
   HtmlForm.prototype.setToolbar = setToolbar;
   HtmlForm.prototype.TOOLBAR_PARAMS_C = TOOLBAR_PARAMS_C;
   
   return HtmlForm;
}();