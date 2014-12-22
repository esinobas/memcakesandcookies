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
var DataGrid = DataGrid || function(theHtmlObject, theParams){
   
   /*************** Constants *************************/
   var COLUMNS_SIZE_C = "columns_size";
   var CLICK_CALLBACK_C = "click_callback";
   var DOUBLE_CLICK_CALLBACK_C = "double_click_callback"
   var SHOW_LINES_C = "show_lines";
   var SHOW_VERTICAL_LINES_C = "vertical";
   var SHOW_HORIZONTAL_LINES_C = "horizontal";
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
   JSLogger.getInstance().registerLogger("DataGrid", JSLogger.levelsE.ERROR);
   
   
   var columnsSizeM = new Array();
   var clickCallbackM = null;
   var doubleClickCallbackM = null;
   var selectedRow = -1;
  
   
   /*************** Constructor **********************/
   function DataGrid(theHtmlObject, theParams){
   
      JSLogger.getInstance().traceEnter();
      
      HtmlObject.call(this, theHtmlObject, theParams);
      
      JSLogger.getInstance().traceExit();
      
      
      /**
       * Sets the colors in the grid
       */
      this.setColors = function setColors(){
         JSLogger.getInstance().traceEnter();
         
          
         if (this.getParameter(HEADER_BACKGROUND_COLOR_C, this.parametersM) != null){
            
            this.htmlObjectM.find('.class-grid-header div').css("background-color", 
                  this.getParameter(HEADER_BACKGROUND_COLOR_C, this.parametersM));
         }
         if (this.getParameter(HEADER_FONT_COLOR_C, this.parametersM) != null){
            
            this.htmlObjectM.find('.class-grid-header').css("color", 
                  this.getParameter(HEADER_FONT_COLOR_C, this.parametersM) );
         }
         
        if (this.getParameter(ROW_BACKGROUND_COLOR_C, this.parametersM) != null){
            
           this.htmlObjectM.find('.class-grid-row').css("background-color", 
                 this.getParameter(ROW_BACKGROUND_COLOR_C, this.parametersM) );
        }
        if (this.getParameter(ROW_FONT_COLOR_C, this.parametersM) != null){
           
           this.htmlObjectM.find('.class-grid-row').css("color", 
                 this.getParameter(ROW_FONT_COLOR_C, this.parametersM) );
        }
         JSLogger.getInstance().traceExit();
      };
      
      /**
       * Sets the header columns size
       */
      this.setSizeHeaderColumns = function setSizeHeaderColumns(){
         JSLogger.getInstance().traceEnter();
         
         var divHeader = this.htmlObjectM.find('.class-grid-header');
         var columnsHeader = divHeader.find('div');
         JSLogger.getInstance().trace("The header has [ " + columnsHeader.length +
                                                " ] columns.");
         var maxDivHeight = 0;
         var showVerticalLines = false;
         var showHorizontalLines = false;
         
         if (this.getParameter(SHOW_LINES_C,this.parametersM)){
            showVerticalLines = 
               this.getParameter(SHOW_LINES_C,this.parametersM).indexOf(SHOW_VERTICAL_LINES_C)!=-1;
            showHorizontalLines = 
               this.getParameter(SHOW_LINES_C,this.parametersM).indexOf(SHOW_HORIZONTAL_LINES_C)!=-1;
            
         }
         
         var columnsSize = this.getParameter(COLUMNS_SIZE_C,this.parametersM);
         
         columnsHeader.each(function(index){
            
            JSLogger.getInstance().trace("Set width [ " + columnsSize[index] +" ]");
            $(this).css("width", columnsSize[index].toString()+"px");
            
            if ($(this).height() > maxDivHeight){
               
               maxDivHeight = $(this).height();
               JSLogger.getInstance().trace("New Max Div height [ " + 
                          maxDivHeight + " ]");
            }
            
            //show vertical lines
            if (showVerticalLines){
               if ((columnsHeader.length)!= index){
            
                  $(this).css("border-right-style", "solid");
                  $(this).css("border-right-width", "1px");
                  $(this).css("border-right-color", "black");
               }
            }
            
          //show horizontal lines
            if (showHorizontalLines){
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
         
      };
      
      /**
       * Sets the click envent in the row
       */
      function setOnClickEvent(theObject, theElement, theIndex){
         JSLogger.getInstance().traceEnter();
         JSLogger.getInstance().trace("Set event click on row [ " + theIndex +" ]");
        
         var rowBackgroundColor = theObject.getParameter(ROW_BACKGROUND_COLOR_C, theObject.parametersM);
         var rowFontColor = theObject.getParameter(ROW_FONT_COLOR_C, theObject.parametersM);
         $('.class-grid-row').each(function(){
            if ( rowBackgroundColor != null){
               
              $(this).css("background-color", 
                    rowBackgroundColor );
           }
           if ( rowFontColor!=  null){
            $(this).css("color", 
                  rowFontColor );
           }
         });
    
         theElement.css("background-color", theObject.getParameter(SELECTED_ROW_BACKGROUND_COLOR_C, theObject.parametersM));
         theElement.css("color", theObject.getParameter(SELECTED_ROW_FONT_COLOR_C, theObject.parametersM));
         
         if (theObject.getParameter(CLICK_CALLBACK_C, theObject.parametersM)){
            theObject.getParameter(CLICK_CALLBACK_C, theObject.parametersM)(theIndex);
         }
         
         
         JSLogger.getInstance().traceExit();
         
      };
      
      /**
       * Sets the double click event in the row
       */
      function setOnDoubleClickEvent(theObject, theIndex){
         JSLogger.getInstance().traceEnter();
         JSLogger.getInstance().trace("Set event double click on row [ " + theIndex +" ]");
             
         if (theObject.getParameter(DOUBLE_CLICK_CALLBACK_C, theObject.parametersM)){
            theObject.getParameter(DOUBLE_CLICK_CALLBACK_C, theObject.parametersM)(theIndex);
         }
         
         
         JSLogger.getInstance().traceExit();
         
      };
      
      /**
       * Sets the columns sizes
       */
      this.setSizeColumns = function setSizeColumns(){
         
         JSLogger.getInstance().traceEnter();
         
         var rows = this.htmlObjectM.find('.class-grid-row');
         JSLogger.getInstance().trace("The grid has [ " + rows.length +
         " ] rows.");
         
         var showVerticalLines = false;
         var showHorizontalLines = false;
         
         if (this.getParameter(SHOW_LINES_C,this.parametersM)){
            showVerticalLines = 
               this.getParameter(SHOW_LINES_C,this.parametersM).indexOf(SHOW_VERTICAL_LINES_C)!=-1;
            showHorizontalLines = 
               this.getParameter(SHOW_LINES_C,this.parametersM).indexOf(SHOW_HORIZONTAL_LINES_C)!=-1;
            
         }
         var columnsSize = this.getParameter(COLUMNS_SIZE_C,this.parametersM);
         var object = this;
         rows.each(function(index){
            JSLogger.getInstance().trace("Set columns width for row [ " + index + 
                                             " ]");
            var maxDivHeight = 0;
            
            var columns = $(this).find('.class-grid-row-data');
            JSLogger.getInstance().trace("The row [ " + index + 
                               " ] has [ " + columns.length + " ] columns");   
            
            columns.each(function(indexColumn){
               
               
               JSLogger.getInstance().trace("Set width [ " + columnsSize[indexColumn] +
                                      " ] in row [ " + index + " ]");
               $(this).css("width", columnsSize[indexColumn].toString()+"px");
               
               JSLogger.getInstance().trace("Div Height [ " + $(this).height() +" ]");
               if ($(this).height() > maxDivHeight){
                  
                  maxDivHeight = $(this).height();
                  JSLogger.getInstance().trace("New Max Div height [ " + 
                             maxDivHeight + " ]");
               }
              
             //show vertical lines
               if (showVerticalLines){
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
            if (showHorizontalLines){
               JSLogger.getInstance().trace("Show horizontal line");
               
               $(this).css("border-bottom-style", "solid");
               $(this).css("border-bottom-width", "1px");
               $(this).css("border-bottom-color", "black");
            }
          
            $(this).click(function(){
               setOnClickEvent(object, $(this), index)
            });
            
            $(this).dblclick(function(){
               setOnDoubleClickEvent(object,index);
            });
            
         }); 
         JSLogger.getInstance().traceExit();
      };
      
    
      
      
      
   }
   
   
   DataGrid.prototype = Object.create(HtmlObject.prototype);
   DataGrid.prototype.constructor = DataGrid;
   /*** Public methods ***/
   DataGrid.prototype.format = function (){
      JSLogger.getInstance().traceEnter();
      this.setSize();
      this.setColors();
      this.setSizeHeaderColumns();
      this.setSizeColumns();
      JSLogger.getInstance().traceExit();
   }
   
   /****/
   var show = function(theHtmlObject, theParams){
      var a = new DataGrid(theHtmlObject, theParams);
      a.format();
   }
   
   return {
      show: show
    }
 }();