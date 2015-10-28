/**
 * Object with the properties and functions for create a html window
 * 
 * The parameteres for the HtmlWindow have the following format:
 *                   Title_Params:{ Background_Color:<background color>,
 *                                Font_Color:<font color>, 
 *                                Caption:<caption> }
 */

var HtmlWindow = HtmlWindow || function(){
   
   /*** Private constants ***/
   var TITLE_PARAMS_C = "Title_Params";
   var FONT_COLOR_C = "Font_Color";
   var CAPTION_C = "Caption";
   
   /*** private properties ***/
   JSLogger.getInstance().registerLogger("HtmlWindow", JSLogger.levelsE.WARN);
  
   /**
    * Constructor
    * 
    * @param theHtmlObject: Html Object that it is used like window
    * @param theParams: The parameters for format the window.
    */
   function HtmlWindow(theHtmlObject, theParams){
      
      JSLogger.getInstance().traceEnter();
      HtmlObject.call(this, theHtmlObject, theParams);
      this.setTitle();
      JSLogger.getInstance().traceExit();
   };
   
   var setTitle = function setTitle(){
      JSLogger.getInstance().traceEnter();
      var barTitle = this.getParameter(TITLE_PARAMS_C, this.parametersM);
      if ( barTitle != null){
         JSLogger.getInstance().trace("The window has bar title, adding it");
         var tittleBar = $('<div class="Title-Bar"><div></div></div>');
         this.htmlObjectM.prepend(tittleBar);
         
         var backgroundColor = this.getParameter(this.PARAM_BACKGROUND_COLOR_C,barTitle);
         if (backgroundColor != null){
            tittleBar.children('div').css("background-color", backgroundColor);
         }
         var fontColor = this.getParameter(FONT_COLOR_C, barTitle);
         if (fontColor !=null ){
            tittleBar.children('div').css("color", fontColor);
         }
         var caption = this.getParameter(CAPTION_C, barTitle);
         if (caption !=null ){
            tittleBar.children('div').append(caption);
         }
      }
      JSLogger.getInstance().traceExit();
   };
   /**
    * Herachy definition
    */
   HtmlWindow.prototype = Object.create(HtmlObject.prototype);
   HtmlWindow.prototype.constructor = HtmlWindow;
   HtmlWindow.prototype.setTitle = setTitle;
   HtmlWindow.prototype.TITLE_PARAMS_C = TITLE_PARAMS_C;
   HtmlWindow.prototype.CAPTION_C = CAPTION_C;
   
   return HtmlWindow;
}();