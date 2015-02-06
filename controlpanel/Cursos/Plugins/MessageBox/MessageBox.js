/**
 * File with the implementation of the a message box for show information and
 * option for be selected by the user.
 * 
 * The messagebox returns a value indicating the option selected-
 * 
 * The MessageBox is a class or object that inherits properties and methods
 * form HtmlWindow class. 
 *             

 *          HtmlObject
 *             |
 *             |
 *          HtmlWindow
 *             |
 *             |
 *          MessageBox
 */

var vMessageBox = vMessageBox || function (){
   
   
   /*** private properties ***/
   JSLogger.getInstance().registerLogger("MessageBox", JSLogger.levelsE.TRACE);
   
   /*** Define the constante ***/
  
   var ICON_PARAM_C = "Icon";
   var BUTTONS_PARAM_C = "Buttons";
   
   /*** Constants for icons ***/
   var ICON_QUESTION_PARAM_C =" Question";
   var ICON_ERROR_PARAM_C =" Error";
   var ICON_WARNING_PARAM_C =" Warning";
   var ICON_INFORMATION_PARAM_C =" Information";
   
   /*** Constant for buttons ***/ 
   var BUTTONS_OK_PARAM_C = "Ok";
   var BUTTON_OK_CANCEL_PARAM_C = "Ok_Cancel";
   var BUTTON_YES_NO_PARAM_C = "Yes_No";
   var BUTTON_YES_NO_CANCEL_PARAM_C = "Yes_No_Cancel";
   
   /**
    * Constructor
    * 
    * @param theCaption: The message tittle
    * @param theMessage: Message that is displayed in the window
    * @param theOptionalParams. JSON structure that contains the paramteres for create
    * the messagebox. The parameter are the following:
    *                
    *                Icon:       The icon that is displayed.
    *                Buttons:    The buttons that are displayed and the user can
    *                            select.
    *                Z-index:    The html-css z-index
    *                Title_Params: 
    *                            Background_Color: Title background color
    *                            Font_Color: The text color.
    *                Appearance:
    *                            Background_Color: Window bankground color
    */
   
   
   
   function vMessageBox(theCaption, theMessage, theOptionalParams){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().debug("Add the div used like messagebox");
      $('body').append("<div id=\"MessageBox_Background\"></div>");
      $('body').append("<div id=\"MessageBox\"></div>");
      
      JSLogger.getInstance().trace("Caption [ " + theCaption +" ]");
      JSLogger.getInstance().trace("Message [ " + theMessage +" ]");
      //Add in the params the optional params
      theOptionalParams = (typeof theOptionalParams != "undefined" ? 
                                 theOptionalParams : {});
      
      JSLogger.getInstance().trace("Preprocessed Option Params [ " + 
                          JSON.stringify(theOptionalParams) +" ]");
      //Add the caption
      var barTitle = this.getParameter(this.TITLE_PARAMS_C, theOptionalParams);
      if ( barTitle == null ){
         barTitle = {};
      }
      barTitle[this.CAPTION_C] = theCaption;
      theOptionalParams[this.TITLE_PARAMS_C] = barTitle;
      
      //Check icon param
      var iconParam = this.getParameter(ICON_PARAM_C, theOptionalParams);
      if (iconParam == null){
         theOptionalParams[ICON_PARAM_C] = ICON_INFORMATION_PARAM_C;
      }
      
    //Check buttons param
      var buttonsParam = this.getParameter(BUTTONS_PARAM_C, theOptionalParams);
      if (buttonsParam == null){
         theOptionalParams[BUTTONS_PARAM_C] = BUTTONS_OK_PARAM_C;
      }
      
      //Calculate the size of the window
      /*
      <p id="place-name"> Llanfairpwllgwyngyllgogerychwyrndrobwllllantysiliogogogoch</p>
      
         
      #place-name{
          position: absolute;
          height: auto;
          width: auto;
      }
      JavaScript
      
         
      var oPlaceName = document.getElementById("place-name");
      if (oPlaceName){
          var iHeight = oPlaceName.clientHeight + 1;
          var iWidth = oPlaceName.clientWidth + 1;
          if (iWidth > 200){
              //Deal with the long text.
          }
      }
      */
      JSLogger.getInstance().trace("Processed Option Params [ " + 
            JSON.stringify(theOptionalParams) +" ]");
      
      HtmlWindow.call(this, $('#MessageBox'), theOptionalParams);
      
      $('#MessageBox').append(theMessage);
      
      JSLogger.getInstance().traceExit();
   }
   
   /*
    * Herachy definition 
    */
   vMessageBox.prototype = Object.create(HtmlWindow.prototype);
   vMessageBox.prototype.constructor = vMessageBox;
   
   
   return vMessageBox;
}();

function MessageBox(theCaption, theText, theOptionalParams){
   
   console.log("Enter");
   var messageBox = new vMessageBox(theCaption, theText, theOptionalParams);
   
}