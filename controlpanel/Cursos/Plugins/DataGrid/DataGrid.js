/**
 * Class that shows the data in a grid and it allows selected a row for 
 * performance any action on the row data.
 * 
 * Hay que explicar el formato que debe de tener el codigo html
 */



/**
 * Constructor of the datagrid.
 * 
 * @param theParams. Array in json format that contains the parematers used
 * for show the data with a format.
 *                   Params: [divId]: Div identifier of the class data-grid-class
 *                                 that is used like data grid 
 *                           [size]: Datagrid size. It is composed by 2 params
 *                                     [width] and [heigth]
 *                           [columns_size]: Array with the width columns size.
 *                                          The plus of these size must be 
 *                                          equal at the data grid width.
 *                           [show_lines]: Shows the lines of the grid cells.
 *                                        Values: Vertical|Horizontal
 *                           [click_callback]: Function that is executed when
 *                                  a click is done on a row.
 *                           [double_click_callback]: Function that is executed
 *                                  when a double click is done on a row. 
 */
function DataGrid(theParams){
   
   /*************** Constants *************************/
   var DIV_ID = "divId";
   var SIZE_C = "size";
   var WIDTH_C = "width";
   var HEIGHT_C = "height";
   var COLUMNS_SIZE_C = "columns_size";
   var CLICK_CALLBACK_C = "click_callback";
   var DOUBLE_CLICK_CALLBACK_C = "double_click_callback"
   var SHOW_LINES_C = "show_lines";
   var HEADER_BACKGROUND_COLOR_C = "header_background_color";
   var HEADER_FONT_COLOR_C= "header_font_color";
   var SELECTED_ROW_BACKGROUND_COLOR_C = "selected_row_background_color";
   var SELECTED_ROW_FONT_COLOR_C = "selected_row_font_color";
   
   var ROW_BACKGROUND_COLOR_C = "row_background_color";
   var ROW_FONT_COLOR_C ="row_font_color";
   
   
   var SELECTED_ROW_BACKGROUND_COLOR = "orange";
   var SELECTED_ROW_FONT_COLOR = "white";
   
   var ROW_BACKGROUND_COLOR = "white";
   var ROW_FONT_COLOR ="black";
   

   
   
   
   /************* private variables ************/
   var divIdM = "";
   var widthM = 0;
   var heightM = 0;
   var columnsSizeM = new Array();
   var clickCallbackM = null;
   var doubleClickCallbackM = null;
   var showVerticalLinesM = false;
   var showHorizontalLinesM = false;
   var selectedRow = -1;
   
   var parametersM = null;
   
   /*************** Constructor **********************/
   
   JSLogger.getInstance().registerLogger(arguments.callee.name, JSLogger.levelsE.ERROR);
   JSLogger.getInstance().traceEnter();
   JSLogger.getInstance().trace("Check parameters");
   
   parametersM = theParams;
   
   if (theParams[DIV_ID] != null){
      divIdM = theParams[DIV_ID];
      JSLogger.getInstance().trace("Div where aplies the datagrid [ " + divIdM +
             " ]");
   }
   if (theParams[SIZE_C] != null){
      widthM = theParams[SIZE_C][WIDTH_C];
      heightM = theParams[SIZE_C][HEIGHT_C];
      JSLogger.getInstance().trace("Size: width [ " + widthM + " ] heigth [ " +
                                 heightM +" ]");
       
   }
   if (theParams[COLUMNS_SIZE_C] != null){
      JSLogger.getInstance().trace("Get columns size");
      for (var idx in theParams[COLUMNS_SIZE_C]){
         JSLogger.getInstance().trace("Column [ " + idx + " ] size [ " + 
               theParams[COLUMNS_SIZE_C][idx] + " ]");
         columnsSizeM[idx] = theParams[COLUMNS_SIZE_C][idx];
         
      }
   }
   
   if (theParams[SHOW_LINES_C] != null){
      JSLogger.getInstance().trace("Get Show lines parameter");
      showVerticalLinesM = (theParams[SHOW_LINES_C].toLowerCase().search("vertical") != -1);
      showHorizontalLinesM = (theParams[SHOW_LINES_C].toLowerCase().search("horizontal") != -1);
      
   }
   JSLogger.getInstance().trace("Show Lines, vertical [ " + 
         (showVerticalLinesM?"TRUE":"FALSE") + 
         " ] and horizontal [ " +
         (showHorizontalLinesM?"TRUE":"FALSE") + " ]");
   
   if (theParams[CLICK_CALLBACK_C] != null){
      JSLogger.getInstance().trace("Get click callback");
      clickCallbackM = theParams[CLICK_CALLBACK_C];
   }
   
   if (theParams[DOUBLE_CLICK_CALLBACK_C] != null){
      JSLogger.getInstance().trace("Get double click callback");
      doubleClickCallbackM = theParams[DOUBLE_CLICK_CALLBACK_C];
   }
   
   
   setSizeToDatagrid();
   setSizeHeaderColumns();
   setSizeColumns();
   setColors();
   JSLogger.getInstance().traceExit();
   
   
   
   
   /******* Private functions   ******/
   
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
   
   function setColors(){
      JSLogger.getInstance().traceEnter();
      var element = "#" + divIdM;
       
      if (getParameter(HEADER_BACKGROUND_COLOR_C, parametersM) != null){
         
         $(element).find('.class-grid-header div').css("background-color", 
               getParameter(HEADER_BACKGROUND_COLOR_C, parametersM) );
      }
      if (getParameter(HEADER_FONT_COLOR_C, parametersM) != null){
         
         $(element).find('.class-grid-header').css("color", 
               getParameter(HEADER_FONT_COLOR_C, parametersM) );
      }
      
     if (getParameter(ROW_BACKGROUND_COLOR_C, parametersM) != null){
         
         $(element).find('.class-grid-row').css("background-color", 
               getParameter(ROW_BACKGROUND_COLOR_C, parametersM) );
     }
     if (getParameter(ROW_FONT_COLOR_C, parametersM) != null){
        
        $(element).find('.class-grid-row').css("color", 
              getParameter(ROW_FONT_COLOR_C, parametersM) );
     }
      JSLogger.getInstance().traceExit();
   }
   
   function setSizeToDatagrid(){
      JSLogger.getInstance().traceEnter();
      
      var element = "#" + divIdM;
      JSLogger.getInstance().trace("Set width [ " + widthM + " ], height [ " +
                                  heightM + " ] to element [ " + element +" ]"); 
      $(element).css("width", widthM.toString()+"px");
      $(element).css("height", heightM.toString()+"px");
      
      JSLogger.getInstance().traceExit();
   } 
   
   function setSizeHeaderColumns(){
      JSLogger.getInstance().traceEnter();
      var element = "#" + divIdM;
      var divHeader = $(element).find('.class-grid-header');
      var columnsHeader = divHeader.find('div');
      JSLogger.getInstance().trace("The header has [ " + columnsHeader.length +
                                             " ] columns.");
      var maxDivHeight = 0;
      
      columnsHeader.each(function(index){
         
         JSLogger.getInstance().trace("Set width [ " + columnsSizeM[index] +" ]");
         $(this).css("width", columnsSizeM[index].toString()+"px");
         
         if ($(this).height() > maxDivHeight){
            
            maxDivHeight = $(this).height();
            JSLogger.getInstance().trace("New Max Div height [ " + 
                       maxDivHeight + " ]");
         }
         
         //show vertical lines
         if (showVerticalLinesM){
            if ((columnsHeader.length)!= index){
         
               $(this).css("border-right-style", "solid");
               $(this).css("border-right-width", "1px");
               $(this).css("border-right-color", "black");
            }
         }
         
       //show horizontal lines
         if (showHorizontalLinesM){
               $(this).css("border-bottom-style", "solid");
               $(this).css("border-bottom-width", "1px");
               $(this).css("border-bottom-color", "black");
            
         }
      });
      
      //Resize divs
      JSLogger.getInstance().trace("Resize for all columns in header " +
                  "with height [ " + maxDivHeight + "px ]");
      columnsHeader.each(function(index){
         JSLogger.getInstance().trace("Resize columns [ " +index+ " ]");
         $(this).height(maxDivHeight);
      });
      JSLogger.getInstance().traceExit();
      
   }
   
   function setSizeColumns(){
      
      JSLogger.getInstance().traceEnter();
      var element = "#" + divIdM;
      var rows = $(element).find('.class-grid-row');
      JSLogger.getInstance().trace("The grid has [ " + rows.length +
      " ] rows.");
      rows.each(function(index){
         JSLogger.getInstance().trace("Set columns width for row [ " + index + 
                                          " ]");
         var maxDivHeight = 0;
         
         var columns = $(this).find('.class-grid-row-data');
         JSLogger.getInstance().trace("The row [ " + index + 
                            " ] has [ " + columns.length + " ] columns");   
         
         columns.each(function(indexColumn){
            
            
            JSLogger.getInstance().trace("Set width [ " + columnsSizeM[indexColumn] +
                                   " ] in row [ " + index + " ]");
            $(this).css("width", columnsSizeM[indexColumn].toString()+"px");
            
            JSLogger.getInstance().trace("Div Height [ " + $(this).height() +" ]");
            if ($(this).height() > maxDivHeight){
               
               maxDivHeight = $(this).height();
               JSLogger.getInstance().trace("New Max Div height [ " + 
                          maxDivHeight + " ]");
            }
           
          //show vertical lines
            if (showVerticalLinesM){
               if ((columns.length )!= indexColumn){
                  JSLogger.getInstance().trace("Show vertical line");
                  $(this).css("border-right-style", "solid");
                  $(this).css("border-right-width", "1px");
                  $(this).css("border-right-color", "black");
               }
            }
            
         });
         //Resize height for all columns in the row
         JSLogger.getInstance().trace("Resize for all columns in row [ " +
                   index + " ] with height [ " + maxDivHeight + "px ]");
         columns.each(function(indexColumn){
            $(this).css("height", maxDivHeight.toString()+"px");
         });
         $(this).height(maxDivHeight);
         if (showHorizontalLinesM){
            JSLogger.getInstance().trace("Show horizontal line");
            
            $(this).css("border-bottom-style", "solid");
            $(this).css("border-bottom-width", "1px");
            $(this).css("border-bottom-color", "black");
         }
       
         $(this).click(function(){
            setOnClickEvent($(this), index)
         });
         
         $(this).dblclick(function(){
            setOnDoubleClickEvent(index);
         });
         
      }); 
      JSLogger.getInstance().traceExit();
   }
   
   function setOnClickEvent(theElement, theIndex){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Set event click on row [ " + theIndex +" ]");
     
      $('.class-grid-row').each(function(){
         if (getParameter(ROW_BACKGROUND_COLOR_C, parametersM) != null){
            
           $(this).css("background-color", 
                  getParameter(ROW_BACKGROUND_COLOR_C, parametersM) );
        }
        if ( getParameter(ROW_FONT_COLOR_C, parametersM) !=  null){
         $(this).css("color", 
               getParameter(ROW_FONT_COLOR_C, parametersM) );
        }
      });
 
      theElement.css("background-color", getParameter(SELECTED_ROW_BACKGROUND_COLOR_C, parametersM));
      theElement.css("color", getParameter(SELECTED_ROW_FONT_COLOR_C, parametersM));
      
      if (clickCallbackM != null){
         clickCallbackM(theIndex);
      }
      
      JSLogger.getInstance().traceExit();
      
   }
   
   function setOnDoubleClickEvent(theIndex){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Set event double click on row [ " + theIndex +" ]");
          
      if (doubleClickCallbackM != null){
         doubleClickCallbackM(theIndex);
      }
      
      JSLogger.getInstance().traceExit();
      
   }
   
 }