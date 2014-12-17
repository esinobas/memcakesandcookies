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
   
   /*** private properties ***/
   JSLogger.getInstance().registerLogger(arguments.callee.name, JSLogger.levelsE.TRACE, JSLogger.levelsE.TRACE);
   
   /*** private methods ***/
   
   /**
    * Contructor of the class
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
       * The parameters passed to the objecto to build it.
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
   
   
   return HtmlObject;
}();