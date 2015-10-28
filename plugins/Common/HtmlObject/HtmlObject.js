/**
 * Object with the common properties and methods for html objects
 */


/**
 * HtmlObject namespace or classes declaration
 */
var HtmlObject = HtmlObject || function (){
   
   /*** private constants ***/
   var PARAM_SIZE_C = "Size";
   var PARAM_WIDTH_C = "Width";
   var PARAM_HEIGHT_C = "Height";
   
   var PARAM_APPEARANCE_C = "Appearance";
   this.PARAM_BACKGROUND_COLOR_C ="Background_Color";
   var PARAM_BORDER_C = "Border";
   var PARAM_BORDER_COLOR_C = "Border_Color";
   var PARAM_BORDER_WIDTH_C = "Border_Width";
   
   /*** private properties ***/
   JSLogger.getInstance().registerLogger("HtmlObject", JSLogger.levelsE.WARN);
   
   /*** private methods ***/
   
   /**
    * Constructor of the class
    * 
    * @param theHtmlObject is the html object in jquery
    * @param theParams are the parameters
    */
   function HtmlObject(theHtmlObject,theParams){
      JSLogger.getInstance().traceEnter();
      
      /*** Public or protected properties ***/
      /**
       * Property that saves the html object
       */
      this.htmlObjectM = theHtmlObject;
      /**
       * The parameters passed to the object to build it.
       */
      this.parametersM = theParams;
      
      JSLogger.getInstance().traceExit();
   }
   
   /***************************************************/
   /**** Public Methods ****/
   
   /**
    * It searches a parameter in the parameters passed to the namespace or class
    * 
    * @param theParameter. A string with the parameter is searched
    * @param theParameters. Array with the list parameters
    * 
    * @return The parameter value when it is found, else null
    */
    
   HtmlObject.prototype.getParameter = function(theParameter, theParameters){
      //JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Searching [ " + theParameter + " ] in "+
                     "the parameters [ " + 
                     JSON.stringify(theParameters) +" ]");
      var parameter = null;
      if (theParameters[theParameter] != null){
         JSLogger.getInstance().trace("[ " + theParameter + " ] found, return it");
         parameter=  theParameters[theParameter];
      }else{
         //JSLogger.getInstance().trace("[ " + theParameter + " ] doesn't found,"+
         //             "searching it in deep");
         if (typeof(theParameters)=="object"){
            for (var key in theParameters){
               //JSLogger.getInstance().trace("Search with key [ " + key +" ]");
               parameter = this.getParameter(theParameter, theParameters[key]);
               if ( parameter != null){
                  break;
               }
            }
         }
      }
         
      //JSLogger.getInstance().traceExit();
      return parameter;
   };
   
   /**
    * Sets the html object size
    */
   HtmlObject.prototype.setSize = function (){
      JSLogger.getInstance().traceEnter();
      
      var parameterSize = this.getParameter(PARAM_SIZE_C, this.parametersM);
      var width = this.getParameter(PARAM_WIDTH_C, parameterSize);
      var height = this.getParameter(PARAM_HEIGHT_C, parameterSize);
      JSLogger.getInstance().trace("Width [ " + width +" ] "+ 
            (height!=null ? ", height [ " +height + " ]" : ""));
      this.htmlObjectM.width(width);
      if (height != null){
         this.htmlObjectM.height(height);
      }
      
      JSLogger.getInstance().traceExit();
   };
   
   /**
    * Sets the html object appearance
    */
   HtmlObject.prototype.setAppearance = function (){
      JSLogger.getInstance().traceEnter();
      
      var paramAppearance = this.getParameter(PARAM_APPEARANCE_C, this.parametersM);
      
      if (paramAppearance == null){
         JSLogger.getInstance().trace("The parameter [ " + PARAM_APPEARANCE_C +
               + " ] is not present in the parameters");
         JSLogger.getInstance().traceExit();
         return;
      }
      var backgroundColor = this.getParameter(PARAM_BACKGROUND_COLOR_C, 
            paramAppearance);
      var border = this.getParameter(PARAM_BORDER_C, paramAppearance);
      
      if (backgroundColor != null){
         this.htmlObjectM.css("background-color", backgroundColor);
      }
      if (border != null){
         this.htmlObjectM.css("border-style", "solid");
         var borderColor = this.getParameter(PARAM_BORDER_COLOR_C, border);
         if (borderColor != null){
            this.htmlObjectM.css("border-color", borderColor);
         }
         var borderWidth = this.getParameter(PARAM_BORDER_WIDTH_C, border);
         if (borderWidth != null){
           
            this.htmlObjectM.css("border-width", borderWidth);
         }
      }
      
      JSLogger.getInstance().traceExit();
   };
   
   /**
    * Function that returns the current path
    * 
    * @return the current script path
    */
   HtmlObject.prototype.getCurrentPath = function(theFileName){
     
      JSLogger.getInstance().traceEnter();
      
      JSLogger.getInstance().trace("The current file is: " + theFileName);
     
      var path = "";
      var scripts = document.getElementsByTagName('script');
      if (scripts && scripts.length > 0) {
    
        for (var i in scripts) {
            if (scripts[i].src && scripts[i].src.match(/.js$/)){
               
               //this.debug(methodName,"Path Script[ " + scripts[i].src + " ]");
               
               if (scripts[i].src.match(new RegExp(theFileName+'$'))){
                  JSLogger.getInstance().trace("Current Script [ " + scripts[i].src + " ]");
                  path = scripts[i].src.substr(0, scripts[i].src.indexOf(theFileName));
                  
                  break;
               }
            }
           }
       }
      
      JSLogger.getInstance().debug("File path [ " + path +" ]");
      JSLogger.getInstance().traceExit();
      return path;
   };
   
   HtmlObject.prototype.PARAM_BACKGROUND_COLOR_C = PARAM_BACKGROUND_COLOR_C;
   
   return HtmlObject;
}();