/**
 * File with the namespace for show a data entry window
 */

var DataEntryWindow = DataEntryWindow || {};

DataEntryWindow.PARAMETER_SIZE_C = "size";
DataEntryWindow.PARAMETER_SIZE_WIDTH_C = "width";
DataEntryWindow.PARAMETER_SIZE_HEIGHT_C = "height";
DataEntryWindow.PARAMETER_DATA_TO_ADD_C = "dataToAdd";

/**
 * Private funtion to close the Window
 */
var closeWindow = function(theIdHtmlObject){
   
   //JSLogger.getInstance().registerLogger("DataEntryWindow", JSLogger.levelsE.WARN);
   JSLogger.getInstance().traceEnter();
   JSLogger.getInstance().trace("Close window [ " + theIdHtmlObject +" ]");
   DataEntryFunctions.clearValues(theIdHtmlObject);
   $(theIdHtmlObject).addClass('DataEntryWindow-Hide');
   $(".DataEntryBackground").remove();
   $('body').removeClass('No-scrollbarDataEntry');
   JSLogger.getInstance().traceExit();
}

DataEntryWindow.show = function (theIdHtmlObject, theCallback, theOptionalParameters){
   
   JSLogger.getInstance().registerLogger("DataEntryWindow", JSLogger.levelsE.TRACE);
   JSLogger.getInstance().traceEnter();
   var dataToAdd = null;
   
   JSLogger.getInstance().trace("Show the DataEntryWindow [ " + theIdHtmlObject +" ]");
   
   if (theOptionalParameters != null ){
      JSLogger.getInstance().trace("The optional parameters are [ " + 
            JSON.stringify(theOptionalParameters) +" ]");
      if (theOptionalParameters[DataEntryWindow.PARAMETER_SIZE_C] != null){
         JSLogger.getInstance().trace("Set the window size [w: " + 
                  theOptionalParameters[DataEntryWindow.PARAMETER_SIZE_C][DataEntryWindow.PARAMETER_SIZE_WIDTH_C]+
                  " h: " + theOptionalParameters[DataEntryWindow.PARAMETER_SIZE_C][DataEntryWindow.PARAMETER_SIZE_HEIGHT_C]+
                   "] at the HTML object [ "+ theIdHtmlObject +" ]");
      
         $(theIdHtmlObject).css('width', 
                           theOptionalParameters[DataEntryWindow.PARAMETER_SIZE_C][DataEntryWindow.PARAMETER_SIZE_WIDTH_C]);
         $(theIdHtmlObject).css('height',
            theOptionalParameters[DataEntryWindow.PARAMETER_SIZE_C][DataEntryWindow.PARAMETER_SIZE_HEIGHT_C]);
      
         $(theIdHtmlObject).css('margin-left', 
               (0-parseInt(theOptionalParameters[DataEntryWindow.PARAMETER_SIZE_C][DataEntryWindow.PARAMETER_SIZE_WIDTH_C])/2)+"px");
          $(theIdHtmlObject).css('margin-top',
               (0-parseInt(theOptionalParameters[DataEntryWindow.PARAMETER_SIZE_C][DataEntryWindow.PARAMETER_SIZE_HEIGHT_C])/2)+"px");
      }
      
      
      
   }
   JSLogger.getInstance().trace("Add the functionality to the ok button, it consists in close the window and execute the callback");
   $(theIdHtmlObject).find(".DataEntryWindowButtonOk").off('click');
   $(theIdHtmlObject).find(".DataEntryWindowButtonOk").click(function(){
         var values = DataEntryFunctions.getValues(theIdHtmlObject, 
                theOptionalParameters[DataEntryWindow.PARAMETER_DATA_TO_ADD_C]);
         JSLogger.getInstance().trace("Values returned [ " + values + " ]");
         closeWindow(theIdHtmlObject);
         theCallback(values);
        
      }
   );
   JSLogger.getInstance().trace("Add the close functionality to the cancel button");
   $(theIdHtmlObject).find(".DataEntryWindowButtonCancel").click(function(){
         closeWindow(theIdHtmlObject);
       }
   );
   JSLogger.getInstance().trace("Add the  functionality to the key escape");
   $(document).keypress(function(e) {        
      if (e.keyCode == 27) {
         closeWindow(theIdHtmlObject);
      }
   });
   
   JSLogger.getInstance().trace("Add the window background-shadow");
   $(theIdHtmlObject).before('<div class="DataEntryBackground"></div>');
   $(theIdHtmlObject).removeClass('DataEntryWindow-Hide');
   $('body').addClass('No-scrollbarDataEntry');
   
   JSLogger.getInstance().traceExit();
}