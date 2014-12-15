/**
 * Class that creates and shows a file browser with the server files and directories
 */


/**
 * Constructor of the class
 * 
 * @param theParams: Array with the parameters to create the array. 
 *                   Supported params: [path]: Path where opens the filebrowser
 *                                     [type]: Filebrowser type (f = only files,
 *                                                               d = only directories,
 *                                                               a = all, default value)
 *                                     [filter]: Filter to the files. Default value *.*
 * @param theCallback: The function that is executed when the ok button is pushed
 * 
 */
function FileBrowser(theParams, callback){
   
   /*** Constants for access to the parameters ***/
   var paramPathC = "path";
   var paramRootPathC = "root_path";
   var paramCurrentPathC = "current_path";
   var paramTypeC = "type";
   var paramFilterC = "filter";
   var paramCallbackC = "callback";
   var TITLE_PARAMS_C = "title_params";
   var TITLE_CAPTION_C = "title_caption";
   var TITLE_BACKGROUND_COLOR_C = "title_background_color";
   var TITLE_FONT_COLOR_C = "title_font_color";
   var TOOLBAR_C = "toolbar";
   var TOOLBAR_BUTTON_UPLOAD_FILE_C = "upload_file";
   var TOOLBAR_CREATE_FOLDER_C = "create_folder";
   
   var INCREASE_HEIGHT_C = 75;
   /*** Private variables ***/
   var pathM = "./";
   var rootPathM = pathM;
   var currentPathM = rootPathM;
   var typeM = "a";
   var filterM = "*.*";
   
   var callbackM = null;
   
   var stackPathM = new Array();
   var stackFilesAndDirectoriesM = new Array();
   var idxStackM = -1;
   
   var elementSelectedM = "";
   var previousSelectedM = elementSelectedM;
   
   var parametersM = null;
   
   /**
    * Variable of type array where are saved the toolbar buttons
    */
   
   var toolbarM = null;
   
   /****** Private functions *******/
   
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
    * Funtions that returns the current path
    * 
    * @return the current script path
    */
   function getCurrentPath (theFileName){
     
      JSLogger.getInstance().traceEnter();
      
      JSLogger.getInstance().trace("The current file is: " + theFileName);
     
      var path = "";
      var scripts = document.getElementsByTagName('script');
      if (scripts && scripts.length > 0) {
          
          
           for (var i in scripts) {
            if (scripts[i].src && scripts[i].src.match(/.js$/)){
               
               //this.debug(methodName,"Path Script[ " + scripts[i].src + " ]");
               
               if (scripts[i].src.match(new RegExp(theFileName+'$'))){
                  JSLogger.getInstance().trace("Current Script [ " + scripts[i].src + " ]");
                  path = scripts[i].src.substr(0, scripts[i].src.indexOf(theFileName));
                  
                  break;
               }
               
                
            }
               
               
           }
       }
      
      JSLogger.getInstance().debug("File path [ " + path +" ]");
      JSLogger.getInstance().traceExit();
       return path;
      
   }
   
   /**
    * Addes a directory data (directories and files) in a stack
    * 
    * @param theFilesAndDirectories. Array with the files and directories
    */
   function pushFilesAndDirectories(theFilesAndDirectories){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("The stack has [ " + 
                             stackFilesAndDirectoriesM.length + " ]. IdxStack [ " + 
                             idxStackM +" ]");
      
      stackFilesAndDirectoriesM[++idxStackM] = 
                                   theFilesAndDirectories;
      
      JSLogger.getInstance().traceExit();
   }
   
   /**
    * Gets the structurte (files and directories) in the start of tje stack
    * 
    * @return An array with the files and directories
    */
   function getFilesAndDirectories(){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("The stack has [ " + 
            stackFilesAndDirectoriesM.length + " ]. IdxStack [ " + 
            idxStackM +" ]");
      
      JSLogger.getInstance().traceExit();
      return stackFilesAndDirectoriesM[idxStackM];
  
   }
   
   /**
    * Gets and removes the firts data directory in the stack
    * 
    * @return An arrya with the files and directories
    */
   function popFilesAndDirectories(){
      
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("The stack has [ " + 
            stackFilesAndDirectoriesM.length + " ]. IdxStack [ " + 
            idxStackM +" ]");
      var returnObject = stackFilesAndDirectoriesM[idxStackM];
      stackFilesAndDirectoriesM[idxStackM] = null;
      idxStackM --;
      JSLogger.getInstance().traceExit();
      return returnObject;
   }
   
   /**
    * Ask if the stack has only one element, the root
    * 
    * @return A boolean value
    */
   function isRoot(){
      
      JSLogger.getInstance().trace("Enter / Exit");
      //return (idxStackM == 0);
      return (fullPathToString().length == 0);
      return (rootPathM == currentPathM);
   }
   
   /**
    * Returns the selected element full path
    * 
    * @return A string
    */
   function fullPathToString(){
      JSLogger.getInstance().traceEnter();
      
      var fullPath = "";
      JSLogger.getInstance().trace("Length stackPathM [ " + stackPathM.length +" ]");
      if (stackPathM.length > 0){
         for (var idx = 0; idx < idxStackM; idx++){
         
            JSLogger.getInstance().trace("Add the directory [ " + stackPathM[idx] +" ] in fullPath");
            fullPath += stackPathM[idx] +"/";
         }
      }
      JSLogger.getInstance().trace("Return full path [ " + fullPath +" ]");
      JSLogger.getInstance().traceExit();
      return fullPath;
   }
   
   /**
    * Functions that performances a get request for take the directories and 
    * files of the directory.
    * The request is done througth an Ajax class. The response is a JSON object
    * that contains the files and directories.
    * The response is save in JSON format in the stack
    */
   function getDirectoriesAndFiles(){
      
      JSLogger.getInstance().traceEnter();
      
      var url = getCurrentPath("FileBrowser.js")+"Filebrowser.php";
      JSLogger.getInstance().trace("URL: [ " + url + " ]");
      
      var ajaxObject = new Ajax();
      ajaxObject.setUrl(url);
      ajaxObject.setPostMethod();
      ajaxObject.setSyn();
      var parameters = {};
      parameters.rootDirectory = rootPathM;
      parameters.type = typeM;
      parameters.filter = filterM;
      JSLogger.getInstance().debug("Parameters [ " + JSON.stringify(parameters) +" ]");
      ajaxObject.setParameters( JSON.stringify(parameters));
      ajaxObject.setCallback(null);
      JSLogger.getInstance().debug("Sending sync request ...");
      ajaxObject.send();
      JSLogger.getInstance().debug("Response [ " + ajaxObject.getResponse() +" ]");
      
      pushFilesAndDirectories(JSON.parse(ajaxObject.getResponse()));
      JSLogger.getInstance().traceExit();
      
   }
   
   /**
    * Function that is executed when the user does click on a file or directory
    * The html object style is changed
    */
   function onClickFileOrDirectory(){
      JSLogger.getInstance().traceEnter();
      
      JSLogger.getInstance().trace("Selected: [ " + 
              $(this).attr('id') +" ]");
      
      JSLogger.getInstance().trace("Set default css");
      $('.DataElement').css("background-color", "white");
      $('.DataElement').css("border-top-color", "white");
      $('.DataElement').css("border-bottom-color", "white");
      
      JSLogger.getInstance().trace("Set selected css");
      $(this).css("background-color", "lightblue");
      $(this).css("border-top-color","blue");
      $(this).css("border-bottom-color","blue");
      
      $('#btnSelect').attr("disabled", true);
      
      JSLogger.getInstance().trace("Evalute whether enable the select button");
      JSLogger.getInstance().trace("Type [ " + typeM.toUpperCase() +" ]");
      
      if (typeM.toUpperCase() == "A" && getFilesAndDirectories()[$(this).attr('id')] == null){
         JSLogger.getInstance().trace("Is all and the element is a file");
         $('#btnSelect').attr("disabled", false);
      }else{
      
         if (typeM.toUpperCase() == "F"){
            JSLogger.getInstance().trace("Is only files");
            $('#btnSelect').attr("disabled", false);
         }else{
            if (typeM.toUpperCase() == "D"){
               JSLogger.getInstance().trace("Is only directories");
               $('#btnSelect').attr("disabled", false);
            }
         }

      }
      if ($(this).attr('id') != ".."){
         previousSelectedM = elementSelectedM;
         elementSelectedM = $(this).attr('id');
      }else{
         elementSelectedM = previousSelectedM;
      }
      JSLogger.getInstance().trace("Selected Element: " +elementSelectedM);
      JSLogger.getInstance().traceExit();
   }
   
   /**
    * Function that is executed when the user does double click on a file or directory
    * The html object style is changed
    */
   function onDoubleClickFileOrDirectory(){
      
      JSLogger.getInstance().traceEnter();
      $('#btnSelect').attr("disabled", true);
      JSLogger.getInstance().trace("Selected: [ " + 
            $(this).attr('id') +" ]");
      
      if ($(this).attr('id') == ".."){
         
         JSLogger.getInstance().trace("Go to parent directory");
         popFilesAndDirectories();
         showFilesAndDirectories(fullPathToString());
      }
      var directoryData = getFilesAndDirectories();
      
      if (directoryData[ $(this).attr('id') ] == null ){
         JSLogger.getInstance().trace("Selected element: [ " + 
               $(this).attr('id') +" ] is a file.");
      }else{
         JSLogger.getInstance().trace("Selected element: [ " + 
               $(this).attr('id') +" ] is a directory. Entering into ...");
         
         stackPathM[idxStackM] = $(this).attr('id');
         pushFilesAndDirectories(directoryData[ $(this).attr('id') ]);
         
         currentPathM = fullPathToString();
         showFilesAndDirectories(currentPathM);
      }
      JSLogger.getInstance().traceExit();
   }
   
   /**
    * Function that writes the files and directories in the file browser
    * 
    * @param theDirectory: A string with the name of the directory its 
    * files and sub directories are showed.
    */
   function showFilesAndDirectories(theDirectory){
      
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().debug("Show the files and directories under [ " +
                                       theDirectory +" ]");
      $('.DataElement').remove();
      $('#CurrentPath').empty();
      $('#CurrentPath').append(fullPathToString());
      var filesAndDirectories = getFilesAndDirectories();
      var objCandidate = null;
      if ( ! isRoot() ){
         JSLogger.getInstance().trace("The directory is not root");
         
         objCandidate = $("<div id=\"..\" class=\"DataElement\"></div>");
         objCandidate.append("<img src=\""+ getCurrentPath("FileBrowser.js") +
         "/icons/folder.png\">");
         objCandidate.append("<div>..</div>");
      
         objCandidate.click(onClickFileOrDirectory);
         objCandidate.dblclick(onDoubleClickFileOrDirectory);
         $('#FilesContainer').append(objCandidate);
      }
      
      for (var candidate in filesAndDirectories){
         var data = filesAndDirectories[candidate];
         objCandidate = $("<div id=\""+
                            candidate+"\" class=\"DataElement\"></div>");
         
         $('#FilesContainer').append(objCandidate);
         
         if (data == null){
            JSLogger.getInstance().trace("Candidate [ " + candidate +" ] is a file");
            objCandidate.append("<img src=\""+getCurrentPath("FileBrowser.js")+
                        "/icons/page_white.png\">");
         }else{
            JSLogger.getInstance().trace("Candidate [ " + candidate +" ] is a directory");
            objCandidate.append("<img src=\""+ getCurrentPath("FileBrowser.js") +
                             "/icons/folder.png\">");
         }
         objCandidate.append("<div>"+candidate+"</div>");
         
         objCandidate.click(onClickFileOrDirectory);
         objCandidate.dblclick(onDoubleClickFileOrDirectory);
         
      }
      JSLogger.getInstance().traceExit();
   }
   
   /**
    * Adds the filebrowser buttons and the then functions.
    */
   function addButtons(){
      JSLogger.getInstance().traceEnter();
      
      var buttonCancel= $("<button type=\"button\" id=\"btnCancel\">Cancelar</button>");
      $('#ButtonsContainer').append(buttonCancel);
      buttonCancel.click(function(){
            
            $('#Filebrowser').remove();
            $('#FilebrowserBackground').remove();
         }
      );
      var buttonSelect = $("<button type=\"button\" id=\"btnSelect\">Seleccionar</button>");
      buttonSelect.attr("disabled", true);
      
      JSLogger.getInstance().trace("Function callback: " + callbackM );
      buttonSelect.click(function (){
           
            JSLogger.getInstance().traceEnter();
            var dataCallback = {};
            dataCallback.path = fullPathToString() + elementSelectedM;
            if (typeM.toUpperCase() == "A" || typeM.toUpperCase() == "F"){
               
               dataCallback.file = true;
            }else{
               dataCallback.file = false;
            }
            JSLogger.getInstance().trace("Calling callback with parameter [ " + 
                            JSON.stringify(dataCallback) + " ]");
            
            callbackM(dataCallback);
            $('#btnCancel').click();
            JSLogger.getInstance().traceExit();
         }
      
      );
      $('#ButtonsContainer').append(buttonSelect);
      
      
      JSLogger.getInstance().traceExit();
   }
   
   function goToCurrentPath(theCurrentPath){
      
      JSLogger.getInstance().traceEnter();
      //if ( !isRoot()) {
      if (rootPathM != currentPathM ){
         JSLogger.getInstance().trace("Current Path [ " + theCurrentPath +" ]");
         var arrayDirectories = theCurrentPath.split("/");
         JSLogger.getInstance().trace("The current path has [ " + arrayDirectories.length +
                        " ] directories");
      
         for (var directory in arrayDirectories){
            JSLogger.getInstance().trace("Go to directoy [ " + arrayDirectories[directory] +" ]");
            var dataDirectory = getFilesAndDirectories();
            var goToDirectory = dataDirectory[ arrayDirectories[directory]];
            JSLogger.getInstance().trace("idxStackM: " + idxStackM);
            stackPathM[idxStackM] = arrayDirectories[directory];
            pushFilesAndDirectories(goToDirectory);
         
         }
     }else{
         JSLogger.getInstance().trace("The Current Path [ " + theCurrentPath +" ] is equal to Root Path");
     }
      JSLogger.getInstance().traceExit();
   }
   
   /****** Public functions *******/
   
   /*** Constructor ***/
   JSLogger.getInstance().registerLogger(arguments.callee.name, JSLogger.levelsE.TRACE);
   
   JSLogger.getInstance().traceEnter();
   parametersM = theParams;
   
   if (theParams[paramPathC] != null){
      pathM = theParams[paramPathC];
      JSLogger.getInstance().debug("The parameter path is present in the parameters");
      if (pathM[paramRootPathC] != null){
         rootPathM = pathM[paramRootPathC];
         JSLogger.getInstance().debug("The parameter \"root path\" [ " + rootPathM +" ]");
      }else{
         JSLogger.getInstance().error("The parameter \"root path\" is not present in parameters.");
         return 1;
      }
      if (pathM[paramCurrentPathC] != null){
         currentPathM = pathM[paramCurrentPathC];
         JSLogger.getInstance().debug("The parameter \"current path\" [ " + currentPathM +" ]");
      }else{
         JSLogger.getInstance().warn("The parameter \"current path\" is not present in parameters. Set root path");
         currentPathM = rootPathM;
      }
   }else{
      JSLogger.getInstance().error("The parameter \"path\" is not present in parameters.");
      return 1;
   }
   
   if (theParams[paramTypeC] != null){
      typeM = theParams[paramTypeC];
      JSLogger.getInstance().debug("The type is [ " + (typeM == "a" ? "All": 
                                                      typeM == "f" ? "Only files":
                                                      "Only directories") + " ]");
   }else{
      JSLogger.getInstance().warn("The parameter \"type\" is not present in parameters. Default value All");
   }
   if (theParams[paramFilterC] != null){
      filterM = theParams[paramFilterC];
      JSLogger.getInstance().debug("The filter is [ " + filterM + " ]");
   }else{
      JSLogger.getInstance().warn("The parameter \"filer\" is not present in parameters. Use filer \"*.*\"");
   }
   if (theParams[paramCallbackC] != null){
      callbackM = theParams[paramCallbackC];
      JSLogger.getInstance().debug("The callback is present");
   }else{
      JSLogger.getInstance().warn("The parameter \"callback\" is not present in parameters.");
   }
   if (theParams[TOOLBAR_C] != null){
      toolbarM = theParams[TOOLBAR_C];
      JSLogger.getInstance().debug("The file browser has toolbar [ " + toolbarM + " ]");
      
   }
   
   JSLogger.getInstance().traceExit();
   
   
   /**
    * Show the filebrowser
    */
   this.show = function show(){
      
      JSLogger.getInstance().traceEnter();
      
      JSLogger.getInstance().debug("Add the div that filebrowser");
      $('body').append("<div id=\"FilebrowserBackground\"></div>");
      $('body').append("<div id=\"Filebrowser\"></div>");
      
      JSLogger.getInstance().debug("Add the label that contains the current path");
      $('#Filebrowser').append("<div id=\"PathContainer\"></div>");
      $('#PathContainer').append("<div id=\"LabelPath\">Directorio</div>");
      $('#PathContainer').append("<div id=\"CurrentPath\">./Current</div>");
      
      JSLogger.getInstance().debug("Add the div that has the directory contained");
      $('#Filebrowser').append("<div id=\"FilesContainer\"></div>");
      
      JSLogger.getInstance().debug("Add the buttons");
      $('#Filebrowser').append("<div id=\"ButtonsContainer\"></div>");
      showToolbar();
      setTitle();
      addButtons();
      showLoading();
      getDirectoriesAndFiles();
      goToCurrentPath(currentPathM);
      showFilesAndDirectories(fullPathToString());
      hideLoading();
      
      JSLogger.getInstance().traceExit();
      
   }
   
   /**
    * Function creates the title window
    */
   function setTitle(){
      
      JSLogger.getInstance().traceEnter();
      if (getParameter(TITLE_PARAMS_C, parametersM) != null){
         $('#Filebrowser').prepend('<div id="FileBrowser-Title"><div></div></div>');
         if (getParameter(TITLE_CAPTION_C, parametersM) != null){
            $('#FileBrowser-Title div').append(getParameter(
                        TITLE_CAPTION_C, parametersM));
         }
         if (getParameter(TITLE_BACKGROUND_COLOR_C, parametersM) != null){
            $('#FileBrowser-Title div').css("background-color", 
                  getParameter(TITLE_BACKGROUND_COLOR_C, parametersM));
         }
         if (getParameter(TITLE_FONT_COLOR_C, parametersM) != null){
            $('#FileBrowser-Title div').css("color", 
                  getParameter(TITLE_FONT_COLOR_C, parametersM));
         }
      }
      JSLogger.getInstance().traceExit();
   }
   
   /**
    * Function that shows an image while the files and directories are loaded
    * from the server
    */
   function showLoading(){
      JSLogger.getInstance().traceEnter();
      $('#FilesContainer').append("<img src=\""+ getCurrentPath("FileBrowser.js") +
      "/icons/load.gif\" width=\"48\" height=\"48\" style=\"position:absolute;"+
      "left:220px; top:175px\" id=\"loading\">");
      JSLogger.getInstance().traceExit();
   }
   
   /**
    * Function that hides the image while the files and directories are loaded
    */
   function hideLoading(){
      JSLogger.getInstance().traceEnter();
      $('#loading').remove();
      JSLogger.getInstance().traceExit();
   }
   
   /**
    * Function that show the toolbar button
    */
   function showToolbar(){
      JSLogger.getInstance().traceEnter();
      if (toolbarM != null){
         JSLogger.getInstance().trace("Show toolbar");
         var filebrowserHeight = $('#Filebrowser').height();
         JSLogger.getInstance().trace("The current filebrowser height is [ " +
               filebrowserHeight + "px ]");
         filebrowserHeight += INCREASE_HEIGHT_C;
         JSLogger.getInstance().trace("Set new height [ " +
               filebrowserHeight + "px ]");
         $('#Filebrowser').height(filebrowserHeight);
         var marginTop = parseInt($('#Filebrowser').css('margin-top'));
         marginTop -= INCREASE_HEIGHT_C;
         $('#Filebrowser').css('margin-top',marginTop+'px');
         JSLogger.getInstance().trace("The new filebrowser margin top is [ " +
               $('#Filebrowser').css('margin-top') + " ]");
         
         $('#Filebrowser').prepend('<div id="FileBrowser-Toolbar"><div></div></div>');
         
         var buttons = toolbarM.split("|");
         JSLogger.getInstance().trace("The toolbar has [ " + buttons.length +
               " ] buttons");
         var toolbarObject = $('#FileBrowser-Toolbar div');
         for( var button in buttons){
            
            if (buttons[button] == TOOLBAR_BUTTON_UPLOAD_FILE_C){
               JSLogger.getInstance().trace("Show button [ " + 
                     TOOLBAR_BUTTON_UPLOAD_FILE_C +" ]");
               toolbarObject.append('<button type="button" '+
                     'id="FileBrowser-upload-file" title="Subir un fichero" '+
                     'style="background-image:url(\''+
                     getCurrentPath("FileBrowser.js")+'icons/file_upload.png\');'+
                     'background-repeat: no-repeat;background-position: center"></button>');
               
                     
            }
            if (buttons[button] == TOOLBAR_CREATE_FOLDER_C ){
               JSLogger.getInstance().trace("Show button [ " + 
                     TOOLBAR_CREATE_FOLDER_C +" ]");
               toolbarObject.append('<button type="button" '+
                     'id="FileBrowser-create-folder" title="Crear carpeta" '+
                     'style="background-image:url(\''+
                     getCurrentPath("FileBrowser.js")+'icons/folder_add.png\');'+
                     'background-repeat: no-repeat;background-position: center"></button>');
               
            }
           
         }
      }
      JSLogger.getInstance().traceExit();
      
   }
}