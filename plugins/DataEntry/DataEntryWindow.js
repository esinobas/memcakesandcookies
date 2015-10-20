/**
 * File with the namespace for show a data entry window
 */

var DataEntryWindow = DataEntryWindow || {};

DataEntryWindow.PARAMETER_SIZE_C = "size";
DataEntryWindow.PARAMETER_SIZE_WIDTH_C = "width";
DataEntryWindow.PARAMETER_SIZE_HEIGHT_C = "height";

DataEntryWindow.show = function (theIdHtmlObject, theCallback, theOptionalParameters){
   
   JSLogger.getInstance().registerLogger("DataEntryWindow", JSLogger.levelsE.TRACE);
   JSLogger.getInstance().traceEnter();
   
   JSLogger.getInstance().trace("Show the DataEntryWindow [ " + theIdHtmlObject +" ]");
   
   if (theOptionalParameters != null ){
      JSLogger.getInstance().trace("The optional parameters are [ " + 
            JSON.stringify(theOptionalParameters) +" ]");
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
   JSLogger.getInstance().trace("Add the window background-shadow");
   $(theIdHtmlObject).before('<div class="DataEntryBackground"></div>');
   $(theIdHtmlObject).removeClass('DataEntryWindow-Hide');
   JSLogger.getInstance().traceExit();
}