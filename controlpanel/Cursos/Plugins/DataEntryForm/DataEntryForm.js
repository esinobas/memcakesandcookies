/**
 * Namespace formats html elements like a data entry form and allows to user
 * insert the data
 * 
 * Use:
 *  The html document must have a div of the class "Data-Entry-Form", where
 *  the inputs elemets and labes will are located.
 *  The row data, label and input, are or should be within a class div 
 *  "Data-Entry-Form-Data". It is like a row and it is composed by 2 elemetns:
 *  Data-Entry-Form-Data-Label and Data-Entry-Form-Data-Value
 */

/**
 * DataEntryForm namespace declaration.
*/
var DataEntryForm =  DataEntryForm || function (){
   
   /*** Declaration of the namespace or class ***/
   
   /*** Constants definitions ***/
   
   var PARAM_APPEARANCE_C = "Appearance";
   var PARAM_TITLE_PARAMS_C = "Title_Params";
   var PARAM_TITLE_C = "Title";
   var PARAM_BACKGROUND_COLOR_C ="Background_Color";
   var PARAM_LABEL_FONT_COLOR_C = "Label_Font_Color";
   var PARAM_INPUT_FONT_COLOR_C = "Input_Font_Color";
   var PARAM_FONT_SIZE_C = "Font_Size";
   var PARAM_WINDOW_PARAMS_C = "Window_Params";
   var PARAM_SIZE_C = "Size";
   var PARAM_WIDTH_C = "Width";
   var PARAM_HEIGHT_C = "Height";
   var PARAM_CALLBACKS_C = "Callbacks";
   var PARAM_CALLBACK_OK_C = "Callback_OK";
   var PARAM_CALLBACK_CANCEL_C = "Callback_Cancel";
   var PARAM_HTML_ELEMENT_ID_C = "html_Id";
   
   /***** private variables *****/
   JSLogger.getInstance().registerLogger(arguments.callee.name, JSLogger.levelsE.TRACE);
   
   /**
    * Variable that saves the parameters
    * Array
    */
   var parametersM;
   
   /**
    * Variable that saves the html(div) element where the html tags are for
    * enter the data
    */
   var elementIdM;
   
   /**
    * JQuery object contains the form
    */
   var divFormM;
   
   /****** private functions ***/
   
   /**
    * It searches a parameter in the parameters passed to the namespace or class
    * 
    * @param theParameter. A string with the parameter is searched
    * @param theParameters. Array with the list parameters
    * 
    * @return The parameter value when it is found, else null
    */
   function getParameter(theParameter, theParameters){
      
      //JSLogger.getInstance().traceEnter();
      //JSLogger.getInstance().trace("Searching [ " + theParameter + " ] in "+
      //               "the parameters [ " + 
      //               JSON.stringify(theParameters) +" ]");
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
               parameter = getParameter(theParameter, theParameters[key]);
               if ( parameter != null){
                  break;
               }
            }
         }
      }
      
      //JSLogger.getInstance().traceExit();
      return parameter;
   }
   
   /**
    * It checks the minimum parameters for apply or show the form
    * 
    * @return A boolean value.
    */
   function checkMinimumParameters(){
      
      JSLogger.getInstance().traceEnter();
      var result = true;
      if (getParameter(PARAM_HTML_ELEMENT_ID_C, parametersM) == null){
         JSLogger.getInstance().error("The param [ "+
               PARAM_HTML_ELEMENT_ID_C + " ] is not present");
         result = false;
      }
      if ( result && getParameter(PARAM_APPEARANCE_C, parametersM) == null){
         JSLogger.getInstance().error("The param [ "+
                         PARAM_APPEARANCE_C + " ] is not present");
         result = false;
      }else{
         if (getParameter(PARAM_TITLE_PARAMS_C, parametersM) == null){
            JSLogger.getInstance().error("The param [ "+
                  PARAM_TITTLE_PARAMS_C + " ] is not present");
            result = false;
         }else{
            if (getParameter(PARAM_TITLE_C, parametersM) == null){
               JSLogger.getInstance().error("The param [ "+
                     PARAM_TITTLE_C + " ] is not present");
               result = false;
            }else{
               if (getParameter(PARAM_SIZE_C, parametersM) == null){
                  JSLogger.getInstance().error("The param [ "+
                        PARAM_SIZE_C + " ] is not present");
                  result = false;
               }else{
                  if (getParameter(PARAM_WIDTH_C, parametersM) == null){
                     JSLogger.getInstance().error("The param [ "+
                           PARAM_WIDTH_C + " ] is not present");
                     result = false;
                  }
               }
            }
         }
      }
      JSLogger.getInstance().traceExit();
      return result;
   }
   
   /**
    * Add in to document a div for avoid the user click behind form
    */
   function addBackgroundWindow(){
      $('body').append('<div id="Data-Entry-Form-Data-Window-Background"></div>');
   }
   
   /**
    * Set the form dimension and locates it in the document. It is center
    * located.
    */
   function setFormDimensions(){
      JSLogger.getInstance().traceEnter();
      var parameterSize = getParameter(PARAM_SIZE_C, parametersM);
      var width = getParameter(PARAM_WIDTH_C, parameterSize);
      var height = getParameter(PARAM_HEIGHT_C, parameterSize);
      
      divFormM.width(width);
      divFormM.css("margin-left", "-"+(width/2).toString()+"px");
      if (height != null){
         divFormM.height(height);
      }else{
         height = divFormM.height();
      }
      divFormM.css("margin-top", "-"+(height/2).toString()+"px");
      
      var labelLength = getNumCharsFromGreaterLabel();
      JSLogger.getInstance().trace("The max label length is [ " + labelLength +" ]");
      $('.Data-Entry-Form-Data-Label').width(labelLength);
      JSLogger.getInstance().traceExit();
   }
   
   /**
    * Inserts the title bar and the title
    */
   function addTitleBar(){
      
      JSLogger.getInstance().traceEnter();
      var titleParams = getParameter(PARAM_TITLE_PARAMS_C, parametersM);
      divFormM.prepend('<div class="Data-Entry-Form-Title-Bar">'+
            getParameter(PARAM_TITLE_C, titleParams) +'</div>');
      
      if (getParameter(PARAM_BACKGROUND_COLOR_C, titleParams) != null){
         $('.Data-Entry-Form-Title-Bar').css("background-color", 
               getParameter(PARAM_BACKGROUND_COLOR_C, titleParams));
      }
      JSLogger.getInstance().traceExit();
   }
   /**
    * Gets the label with greater length and returns the number of characters
    */
   function getNumCharsFromGreaterLabel(){
      JSLogger.getInstance().traceEnter();
      var greaterLength = 0;
      $('.Data-Entry-Form-Data-Label').each(function(){
         var value = $(this).html();
         var tmp = $('<span id="SpanTemporal" '+
              'style="display:none;width:auto;height:auto; position:absolute">'+
               $(this).html()+'</span>');
         $('body').append(tmp);
         if (greaterLength < $('#SpanTemporal').width()){
            greaterLength = $('#SpanTemporal').width();
         }
         $('#SpanTemporal').remove();
      });
      JSLogger.getInstance().traceExit();
      return greaterLength;
   }
   /**
    * Shows the form
    */
   function showForm(){
      JSLogger.getInstance().traceEnter();
      divFormM.css( "display", "block");
      divFormM.show();
      JSLogger.getInstance().traceExit();
   }
   /**
    * Function executed when the cancel button is pushed
    */
   function cancelButtonClick(){
      
      JSLogger.getInstance().traceEnter();
      
      var callbacks = getParameter(PARAM_CALLBACKS_C, parametersM);
      if (callbacks != null){
         var callbackCancel = getParameter(PARAM_CALLBACK_CANCEL_C, callbacks);
         if (callbackCancel != null){
            JSLogger.getInstance().trace("Excuting callback cancel");
            callbackCancel();
         }
      }
      
      divFormM.hide();
      $('.Data-Entry-Form-Title-Bar').remove();
      $('.Data-Entry-Form-Bar-Buttons').remove();
      $('#Data-Entry-Form-Data-Window-Background').remove();
      JSLogger.getInstance().traceExit();
   }
   
   /**
    * Function executed when the cancel button is pushed
    */
   function okButtonClick(){
      
      JSLogger.getInstance().traceEnter();
      
      var callbacks = getParameter(PARAM_CALLBACKS_C, parametersM);
      if (callbacks != null){
         var callbackOk = getParameter(PARAM_CALLBACK_OK_C, callbacks);
         if (callbackOk != null){
            JSLogger.getInstance().trace("Excuting callback OK");
            callbackOk();
         }
      }
      
      divFormM.hide();
      $('.Data-Entry-Form-Title-Bar').remove();
      $('.Data-Entry-Form-Bar-Buttons').remove();
      $('#Data-Entry-Form-Data-Window-Background').remove();
      JSLogger.getInstance().traceExit();
   }
   /**
    * Adds a div in the form bottom with the butons
    */
   function addButtons(){
      JSLogger.getInstance().traceEnter();
      var divButtons = divFormM.append('<div class="Data-Entry-Form-Bar-Buttons"><div/></div>');
      
      $('.Data-Entry-Form-Bar-Buttons div').append('<input type="button" id="Data-Entry-Form-Cancel" class="Data-Entry-Form-Button" value="Cancelar">');
      $('.Data-Entry-Form-Bar-Buttons div').append('<input type="button" id="Data-Entry-Form-Ok" class="Data-Entry-Form-Button" value="Aceptar">');
      
      $('#Data-Entry-Form-Cancel').click(function(){
         cancelButtonClick();
      });
      $('#Data-Entry-Form-Ok').click(function(){
         okButtonClick();
      });
      
      JSLogger.getInstance().traceExit();
   }
   
   function setWindowParameter(){
      JSLogger.getInstance().traceEnter();
      
      var windowParams = getParameter(PARAM_WINDOW_PARAMS_C, parametersM);
      
      if ( windowParams != null && 
                getParameter(PARAM_BACKGROUND_COLOR_C, windowParams) != null){
            divFormM.css("background-color", 
               getParameter(PARAM_BACKGROUND_COLOR_C, windowParams));
      }
      
      JSLogger.getInstance().traceExit();
      
   }
   /****** public functions. They must be mapped in the return part ***/
   
   /**
    * It shows the form with the values passes in the array parameter
    * 
    * @param theParameters: Array in JSON format that contains the parameters
    */
   var show = function show(theParameters){
      
      JSLogger.getInstance().traceEnter();
      parametersM = theParameters;
      if (checkMinimumParameters()){
         addBackgroundWindow();
         divFormM =  $('#'+getParameter(PARAM_HTML_ELEMENT_ID_C, parametersM));
         
         addTitleBar();
         addButtons();
         setWindowParameter();
         setFormDimensions();
         showForm();
      }else{
         JSLogger.Instance().debug("The form is not showed. See previous errors");
      }
      JSLogger.getInstance().traceExit();
   }

return{
   show: show
}}();
   

