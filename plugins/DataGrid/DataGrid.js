/**
 * Namespace for format the plugin DataGrid
 * 
 * Constrains: The jquery plugin must be defined previously
 * 
 * Use: DataGrid.format(parameters)
 * 
 * where paremeters are:
 * 
 *    theDataGrid: The HTML object DataGrid that want to be formatted. It 
 *                
 *    width: Optional. DataGrid width in pixels. If the paremeter is omitted, 
 *          the DataGrid width is the 100% of the parent container
 *    
 *    columnsWidth: Mandatory. Array with the width of the columns
 *    
 *    drawLines: Optional. Boolean value for draw the DataGrid lines.
 *    
 * Example: DataGrid.format('#DataGridExample', width: 100, 
 *                columnsWidth: {0:10px,1:25px, 3: 100px},
 *                drawLines: true);
 */

var DataGrid = DataGrid || {};
   
DataGrid.PARAMETER_WIDTH_C = "width";
DataGrid.PARAMETER_COLUMNS_WIDTH_C = "columnsWidth";
DataGrid.PARAMETER_DRAW_LINES_C = "drawLines";
   
DataGrid.format = function (theHtmlObject, theParameters){
   JSLogger.getInstance().registerLogger("DataGrid", JSLogger.levelsE.WARN);
   JSLogger.getInstance().traceEnter();
   
   JSLogger.getInstance().trace("The parameters are [ " + JSON.stringify(theParameters) +" ]");
   
   if (theParameters[DataGrid.PARAMETER_COLUMNS_WIDTH_C] == null){
      JSLogger.getInstance().error("The paremeter [ " + DataGrid.PARAMETER_COLUMNS_WIDTH_C +
            " ] is not present in the parameter list");
   }else{
      var columnsWidth = theParameters[DataGrid.PARAMETER_COLUMNS_WIDTH_C];
      var datagridWidth = theParameters[DataGrid.PARAMETER_WIDTH_C];
      var drawLines = theParameters[DataGrid.PARAMETER_DRAW_LINES_C];
      
      JSLogger.getInstance().trace("The DataGrid width is [ " +
             ((datagridWidth != null) ? datagridWidth : "100%") + " ]");
      
      JSLogger.getInstance().trace("The columns width are [ " + JSON.stringify(columnsWidth)
             + " ]");
      
      JSLogger.getInstance().trace("Draw the datagrid lines [ " +
            ((drawLines != null) ? (drawLines.toUpperCase() == "YES"?"Yes":"No") 
                  : "No") + " ]");
      
      if (datagridWidth != null){
         JSLogger.getInstance().trace("Set the DataGrid width to [ " + 
               datagridWidth + " ]");
         theHtmlObject.css("width", (datagridWidth));
      }
      
      
      JSLogger.getInstance().trace("Set the columns width. There are [ " + 
            Object.keys(columnsWidth).length + " ] columns");
      
      JSLogger.getInstance().trace("The DataGrid has [ " + 
            theHtmlObject.find(".Data-Grid-Row").length + " ] rows");
      
      var paddingColumn = parseInt($(".Data-Grid-Column").css("padding-left"));
      paddingColumn += parseInt($(".Data-Grid-Column").css("padding-right"));
      JSLogger.getInstance().trace("padding "+ paddingColumn + "px");
      theHtmlObject.find(".Data-Grid-Row").each(function(index){
            //JSLogger.getInstance().trace("Enter each function index [ " + index +" ]");
            //JSLogger.getInstance().trace("Get columns for the row number [ " + index +" ]");
            $(this).find(".Data-Grid-Column").each(function(indexColumn){
               // JSLogger.getInstance().trace("Enter each function row-column [ " + 
               //               index + "," +indexColumn + " ]");
               JSLogger.getInstance().trace("Set width [ " + 
                     (parseInt(columnsWidth[indexColumn]) - paddingColumn) + "px ] in row-column [ " +
                    index + "," +indexColumn + " ]");
               $(this).css("width", parseInt(columnsWidth[indexColumn]) - paddingColumn +"px");
              // JSLogger.getInstance().trace("Exit each function row-column [ " + 
              //       index + "," +indexColumn + " ]");
            });
            //JSLogger.getInstance().trace("Exit each function index [ " + index +" ]");
         }
      );
      
   }
   
   JSLogger.getInstance().traceExit();
   }


