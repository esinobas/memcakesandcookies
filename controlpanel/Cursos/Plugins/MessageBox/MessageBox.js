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

/*** Enumerated definition of the buttons and icons that will be showed 
     in the message box  ***/

MessageBox.ButtonsE = {OK: 0, OK_CANCEL: 1, YES_NO: 2, YES_NO_CANCEL: 3};
MessageBox.IconsE = {QUESTION: 0, ERROR: 1, WARNING: 2, INFORMATION: 3};


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
    * @param theCaption: The message title
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
         theOptionalParams[ICON_PARAM_C] = MessageBox.IconsE.INFORMATION;
         iconParam = MessageBox.IconsE.INFORMATION;
      }
      
    //Check buttons param
      var buttonsParam = this.getParameter(BUTTONS_PARAM_C, theOptionalParams);
      if (buttonsParam == null){
         theOptionalParams[BUTTONS_PARAM_C] = MessageBox.ButtonsE.OK;
         buttonsParam = MessageBox.ButtonsE.OK;
      }
      
      
      
      JSLogger.getInstance().trace("Processed Option Params [ " + 
            JSON.stringify(theOptionalParams) +" ]");
      
      HtmlWindow.call(this, $('#MessageBox'), theOptionalParams);
      
      //Add the divs, one for the icon and the message and other
      //where the buttons are showed.
      var divData = $('<div id="MessageBox-Data"></div>');
      var divIcon = $('<div id="MessageBox-Icon"></div>');
      var divMessage = $('<div id="MessageBox-Message">'+theMessage+'</div>');
      divData.append(divIcon);
      divData.append(divMessage);
      //Show the Icon.
      var urlImg = "";
      switch (iconParam){
         case MessageBox.IconsE.QUESTION:
              urlImg = this.getCurrentPath('MessageBox.js')+"/icons/question-icon.png";
              break;
         case MessageBox.IconsE.ERROR:
            urlImg = this.getCurrentPath('MessageBox.js')+"/icons/icon-error.png";
            break;
         case MessageBox.IconsE.WARNING:
            urlImg = this.getCurrentPath('MessageBox.js')+"/icons/icon-warning.png";
            break;
         case MessageBox.IconsE.INFORMATION:
            urlImg = this.getCurrentPath('MessageBox.js')+"/icons/information-icon.png";
            break;
      }
      divIcon.append('<img src="'+ urlImg + '">');
      $('#MessageBox').append(divData);
      
    //Calculate the size of the window
      
      var widthIcon = $('#MessageBox-Icon img').width();
      var marginLeft = parseInt($('#MessageBox-Message').css("margin-left"));
      
      JSLogger.getInstance().trace("The text width is [ " + divMessage.width() +" px] ");
      var widthMessageBox = divMessage.width() + widthIcon + (marginLeft*2) +20;
      JSLogger.getInstance().trace("Messagebox width [ " + widthMessageBox +" px] ");

      $('#MessageBox').width(widthMessageBox);
      
      $('#MessageBox-Message').width(widthMessageBox - widthIcon - (marginLeft*2));
      $('#MessageBox-Message').css("max-width", 
            $('#MessageBox').width() - widthIcon -(marginLeft*2)-5 +"px");
      
      
      $('#MessageBox-Message').height();
      
      divData.height($('#MessageBox-Icon').height() > $('#MessageBox-Message').height() ? 
            $('#MessageBox-Icon').height() : $('#MessageBox-Message').height());
      
            
      if (divData.height() > $('#MessageBox-Message').height()){
         
         $('#MessageBox-Message').css("margin-top", 
               (divData.height() - $('#MessageBox-Message').height())/2 + "px"); 
      }
      
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

