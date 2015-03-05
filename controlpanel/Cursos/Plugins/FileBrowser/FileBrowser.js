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
 * a
 */
var FileBrowser = FileBrowser || function (){
   
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
   var TOOLBAR_DELETE_C = "delete";
   
   var INCREASE_HEIGHT_C = 75;
   /*** Private variables ***/
   var pathM = "./";
   //var rootPathM = pathM;
   var currentPathM = pathM; //rootPathM;
   var typeM = "a";
   var filterM = "*.*";
   
   var callbackM = null;
   
   var stackPathM = [];
   var stackFilesAndDirectoriesM = [];
   var idxStackM = -1;
   
   var elementSelectedM = "";
   var previousSelectedM = elementSelectedM;
   
   var localGetCurrentPathM;
   var localParamsM = null;
   

   
   JSLogger.getInstance().registerLogger("FileBrowser", JSLogger.levelsE.TRACE);
   
   /****** Private functions *******/
   
   /**
    * It sets up the object memory to an initial status
    */
   function initObjectMemory(){
      JSLogger.getInstance().traceEnter();
      
      stackPathM = [];
      stackFilesAndDirectoriesM = [];
      idxStackM = -1;
      
      elementSelectedM = "";
      previousSelectedM = elementSelectedM;
      
      JSLogger.getInstance().traceExit();
   }
   
   /**
    * Adds a directory data (directories and files) in a stack
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
    * Gets the structure (files and directories) in the start of the stack
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
    * Function that goes to the current path into the directories
    * structure
    */
   function goToCurrentPath(theRootPath, theCurrentPath){
      
      JSLogger.getInstance().traceEnter();
      //if ( !isRoot()) {
      JSLogger.getInstance().trace("Root Path [ " + theRootPath 
            + " ]. Current Path [ " + theCurrentPath +" ]");
      if (theRootPath != theCurrentPath ){
        
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
         JSLogger.getInstance().trace("Both Path [ " + theCurrentPath +" ] are equals");
     }
      JSLogger.getInstance().traceExit();
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
    * Ask if the stack has only one element, the root
    * 
    * @return A boolean value
    */
   function isRoot(){
      
      JSLogger.getInstance().trace("Enter / Exit");
      //return (idxStackM == 0);
      return (fullPathToString().length == 0);
      //return (rootPathM == currentPathM);
   }
   
   /**
    * Gets and removes the firts data directory in the stack
    * 
    * @return An array with the files and directories
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
            $('#FileBrowser-delete-folder').attr("disabled", true);
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
         $('#FileBrowser-delete').attr("disabled", false);
         
         $('#FileBrowser-delete').css("background-image","url('"+
               localGetCurrentPathM("FileBrowser.js")+"icons/delete.png'");
      }else{
         elementSelectedM = previousSelectedM;
         
         $('#FileBrowser-delete').css("background-image","url('"+
               localGetCurrentPathM("FileBrowser.js")+"icons/disabled_delete.png'");
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
      $('#FileBrowser-delete').attr("disabled", true);
      $('#FileBrowser-delete').css("background-image","url('"+
            localGetCurrentPathM("FileBrowser.js")+"icons/disabled_delete.png'");
      
      JSLogger.getInstance().trace("Selected: [ " + 
            $(this).attr('id') +" ]");
      
      if ($(this).attr('id') == ".."){
         
         JSLogger.getInstance().trace("Go to parent directory");
         popFilesAndDirectories();
         currentPathM = fullPathToString()
         showFilesAndDirectories(currentPathM);
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
         objCandidate.append("<img src=\""+ FileBrowser.prototype.getCurrentPath("FileBrowser.js") +
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
            objCandidate.append("<img src=\""+FileBrowser.prototype.getCurrentPath("FileBrowser.js")+
                        "/icons/page_white.png\">");
         }else{
            JSLogger.getInstance().trace("Candidate [ " + candidate +" ] is a directory");
            objCandidate.append("<img src=\""+ FileBrowser.prototype.getCurrentPath("FileBrowser.js") +
                             "/icons/folder.png\">");
         }
         objCandidate.append("<div>"+candidate+"</div>");
         
         objCandidate.click(onClickFileOrDirectory);
         objCandidate.dblclick(onDoubleClickFileOrDirectory);
         
      }
      JSLogger.getInstance().traceExit();
   }
   
   
  
   
   /**
    * Constructor
    * 
    * @param theParameters Array with the parameters used for show the filebrowser
    */
   
  function FileBrowser(theParams){
     
     JSLogger.getInstance().traceEnter();
     JSLogger.getInstance().debug("Add the div that filebrowser");
     $('body').append("<div id=\"FilebrowserBackground\"></div>");
     $('body').append("<div id=\"Filebrowser\"></div>");
     HtmlForm.call(this, $('#Filebrowser'), theParams);
     
     JSLogger.getInstance().debug("Add the label that contains the current path");
     $('#Filebrowser').append("<div id=\"PathContainer\"></div>");
     $('#PathContainer').append("<div id=\"LabelPath\">Directorio</div>");
     $('#PathContainer').append("<div id=\"CurrentPath\">./Current</div>");
     
     JSLogger.getInstance().debug("Add the div that has the directory contained");
     $('#Filebrowser').append("<div id=\"FilesContainer\"></div>");
     
     JSLogger.getInstance().debug("Add the buttons");
     $('#Filebrowser').append("<div id=\"ButtonsContainer\"></div>");
     
     localGetCurrentPathM = this.getCurrentPath;
     
     this.addButtons();
     
     this.showLoading();
     
     initObjectMemory();
     
     typeM = this.getParameter(paramTypeC, this.parametersM);
     if (typeM == null){
        typeM = "a";
     }
     
     this.getDirectoriesAndFiles();
     var rootPath = this.getParameter(paramRootPathC, 
           this.getParameter(paramPathC, this.parametersM));
     currentPathM = this.getParameter(paramCurrentPathC, 
                   this.getParameter(paramPathC, this.parametersM));
     if (currentPathM == null){
        currentPathM = rootPath;
     }
     goToCurrentPath(rootPath, currentPathM);
     
     showFilesAndDirectories(fullPathToString());
     localParamsM = this.parametersM;
     this.hideLoading();
     
     
     JSLogger.getInstance().traceExit();
  };
  
  /**
   * Adds the filebrowser buttons and the then functions.
   */
  var addButtons = function addButtons(){
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
     
     localCallback = this.getParameter(paramCallbackC, this.parametersM);
     JSLogger.getInstance().trace("Callback [ " + localCallback + " ]");
     buttonSelect.click(function (){
       
         JSLogger.getInstance().traceEnter();
         var dataCallback = {};
         dataCallback.path = fullPathToString() + elementSelectedM;
         if (typeM.toUpperCase() == "A" || typeM.toUpperCase() == "F"){
           
            dataCallback.file = true;
         }else{
             dataCallback.file = false;
         }
         
         if (localCallback != null){
            JSLogger.getInstance().trace("Calling callback with parameter [ " + 
                  JSON.stringify(dataCallback) + " ]");
         
         
            localCallback(dataCallback);
         }
         $('#btnCancel').click();
         JSLogger.getInstance().traceExit();
       }
     );
     
     $('#ButtonsContainer').append(buttonSelect);
     JSLogger.getInstance().traceExit();
  }
  
  /**
   * Function that adds in the current directory the new directory
   *
   * @param theNewDirectory. The directory name
   */
  function addDirectory(theNewDirectory){
     JSLogger.getInstance().traceEnter();
     JSLogger.getInstance().trace("Add new directory [ " + theNewDirectory +
           " ] into [ " + fullPathToString() +" ]");
     
     var directoryStructure = getFilesAndDirectories();
     
     directoryStructure[theNewDirectory]= {};
     
     showFilesAndDirectories(fullPathToString());
     JSLogger.getInstance().traceExit();
  }
  
  /**
   * Function that removes the element from the file-directory structure
   * 
   * @param theElementName: The file or directory name
   */
  function removeElement(theElementName){
     
     JSLogger.getInstance().traceEnter();
     JSLogger.getInstance().trace("Remove [ " + theElementName +
           " ] from  [ " + fullPathToString() +" ]");
     
     var directoryStructure = getFilesAndDirectories();
     
     delete directoryStructure[theElementName];
     
     
     showFilesAndDirectories(fullPathToString());
     JSLogger.getInstance().traceExit();
  }
  
  /**
   * Function that sends to the server the commnad for create a directory
   */
  function createDirectory(theDirectoryName, theParameters){
     JSLogger.getInstance().traceEnter();
     
     showLoading();
     JSLogger.getInstance().trace("The directory name is [ " +theDirectoryName + " ]");
     
     var url = FileBrowser.prototype.getCurrentPath("FileBrowser.js")+"FileSystem.php";
     JSLogger.getInstance().trace("URL: [ " + url + " ]");
     
     var ajaxObject = new Ajax();
     ajaxObject.setUrl(url);
     ajaxObject.setPostMethod();
     ajaxObject.setSyn();
     var parameters = {};
     var rootDirectory = FileBrowser.prototype.getParameter(paramRootPathC,
                        FileBrowser.prototype.getParameter(paramPathC, 
                              theParameters));
     
     var newDirectory = (rootDirectory == currentPathM ? currentPathM + "/"+ theDirectoryName:
        rootDirectory+"/"+ currentPathM + theDirectoryName);
     
     JSLogger.getInstance().debug("Create directory [ " +
                                          newDirectory +" ]") ;
     
     parameters.command = "mkdir";
     parameters.parameters = {}
     parameters.parameters.new_dir = newDirectory;
     
     JSLogger.getInstance().debug("Ajax Parameters [ " + JSON.stringify(parameters) +" ]");
     ajaxObject.setParameters( JSON.stringify(parameters));
     ajaxObject.setCallback(null);
     JSLogger.getInstance().debug("Sending sync request ...");
     ajaxObject.send();
     JSLogger.getInstance().debug("Response [ " + ajaxObject.getResponse() +" ]");
   
     var jsonResponse = JSON.parse(ajaxObject.getResponse());
     if (jsonResponse["result"] == "ERROR"){
        MessageBox("Error", "El directorio no se ha creado. Error [ " + 
              jsonResponse["message_return"] +" ]",
              {Icon: MessageBox.IconsE.ERROR }
        );
        
     }else{
        //refresh the files showed
        addDirectory(theDirectoryName);
     }
     hideLoading();
     
     JSLogger.getInstance().traceExit();
  }
  
  /**
   * It shows a input text for get the directory name and call to the 
   * function in the server that creates the directory
   */
  function showEnterDirectoryName(theObject, theEvent, theCurrentPath, theParameters){
     JSLogger.getInstance().traceEnter();
     var posX = theObject.offset().left;
     var posY = theObject.offset().top;
      
     JSLogger.getInstance().trace("left [ " + (theEvent.pageX) + 
                             " ]. top [ " + (theEvent.pageY) + " ]");
     
     //open a div where the directory name will be written
     $('body').append('<div id="Background-Name-Entry"></div>');
     var directoryNameObj = $('<div id="Directory-Name-Entry"></div>');
     directoryNameObj.append('<div><input id="Input-Directory-Name-Entry" type="text" autofocus="autofocus"></div>');
     var buttonAccept = $('<img src="' + theCurrentPath +'icons/disabled_accept.png">');
     var cancelButton = $('<img src="' + theCurrentPath +'icons/cancel.png">');
     directoryNameObj.append(buttonAccept);
     directoryNameObj.append(cancelButton);
     directoryNameObj.css('top', (theEvent.pageY)+"px");
     directoryNameObj.css('left',(theEvent.pageX)+"px");
     $('body').append(directoryNameObj);
     $('#Input-Directory-Name-Entry').focus();
     
     //Add cancel event to the cancel button
     cancelButton.click(function() {
        $('#Directory-Name-Entry').remove();
        $('#Background-Name-Entry').remove();
     });
     //Add the event of JQuery keyup, for count the number of characters into
     //the input text
     $('#Input-Directory-Name-Entry').keyup(function(){
        
        if ($(this).val().length > 0){
           buttonAccept.attr("src", theCurrentPath +"icons/accept.png")
        }else{
           buttonAccept.attr("src", theCurrentPath +"icons/disabled_accept.png")
        }
     });
     
     //Add the event to the accept button for create the directory.
     buttonAccept.click(function(){
        if ($('#Input-Directory-Name-Entry').val().length > 0){
           
           
           createDirectory($('#Input-Directory-Name-Entry').val(), theParameters);
           $('#Directory-Name-Entry').remove();
           $('#Background-Name-Entry').remove();
        }
      }
     );
     JSLogger.getInstance().traceExit();
  }
  
  /**
   * Function that performances the remove in the server of the file or 
   * directory
   
   */
  function removeInServer(){
     
     JSLogger.getInstance().traceEnter();
     
     
     showLoading();
     
     var rootDirectory = FileBrowser.prototype.getParameter(paramRootPathC,
           FileBrowser.prototype.getParameter(paramPathC, 
                                 localParamsM));
     var elmentToRemove = (rootDirectory == currentPathM ? currentPathM + "/" + elementSelectedM:
        rootDirectory+"/"+ currentPathM + elementSelectedM);
     JSLogger.getInstance().debug("Trying remove [ " + elmentToRemove +" ]");
     
     
     var url = FileBrowser.prototype.getCurrentPath("FileBrowser.js")+"FileSystem.php";
     JSLogger.getInstance().trace("URL: [ " + url + " ]");
     
     var ajaxObject = new Ajax();
     ajaxObject.setUrl(url);
     ajaxObject.setPostMethod();
     ajaxObject.setSyn();
     var parameters = {};
     
      parameters.command = "rm";
      parameters.parameters = {}
      parameters.parameters.element_name = elmentToRemove;

     JSLogger.getInstance().debug("Ajax Parameters [ " + JSON.stringify(parameters) +" ]");
     ajaxObject.setParameters( JSON.stringify(parameters));
     ajaxObject.setCallback(null);
     JSLogger.getInstance().debug("Sending sync request ...");
     ajaxObject.send();
     JSLogger.getInstance().debug("Response [ " + ajaxObject.getResponse() +" ]");
   
     var jsonResponse = JSON.parse(ajaxObject.getResponse());
     if (jsonResponse["result"] == "ERROR"){

        MessageBox("Error", "No se ha podido borrar \"" + elementSelectedM +
              "\". Error [ " +jsonResponse["message_return"] + " ]",
              {Icon: MessageBox.IconsE.ERROR});
     }else{
        removeElement(elementSelectedM);
        $('#FileBrowser-delete').attr("disabled", true);
        $('#FileBrowser-delete').css("background-image","url('"+
              localGetCurrentPathM("FileBrowser.js")+"icons/disabled_delete.png'");
     }
     hideLoading();
    
   
     JSLogger.getInstance().traceExit();
  }
  
  /**
   * Function that shows a window dialog asking confirmation for remove a
   * file or a directory. Depending of the user's response the file or 
   * directory is removed.
   */
  function removeFileOrDirectory(theParameters){
     JSLogger.getInstance().traceEnter();
     
     MessageBox("Borrar", "¿Borrar \"" + elementSelectedM + "\"?",
           {Buttons:{Buttons: MessageBox.ButtonsE.YES_NO,
                     Callback_Yes: removeInServer},
            Icon: MessageBox.IconsE.QUESTION});
     
     
     JSLogger.getInstance().traceExit();
  }
  
  /**
   * Checks if the file exists in the current directory
   */
  function fileExistsInDirectory(theFileName, theDirectory){
     JSLogger.getInstance().traceEnter();
     JSLogger.getInstance().trace("Checking if the file [ " + theFileName +
           " ] exist in the current directory [ " + 
                          theDirectory+ " ]");
     
    
     var directoryStructure = getFilesAndDirectories();
     var exists = false;
     for (var key in directoryStructure){
        JSLogger.getInstance().trace("Key [ " + key +" ]");
        if (key == theFileName){
           JSLogger.getInstance().trace("The file has been found in the directory");
           exists = true;
           break;
        }
     }
     
     JSLogger.getInstance().traceExit();
     return exists;
  }
  
  /**
   * Function that upload a file to the server
   * 
   * @param theFileName: The file name that will be uploaded to the server
   */
  //function uploadFile(theFileName, theParameters, theLocalCurrentPath){
  function uploadFile(){
     JSLogger.getInstance().traceEnter();
     showLoading();
     var rootDirectory = FileBrowser.prototype.getParameter(paramRootPathC,
           FileBrowser.prototype.getParameter(paramPathC, 
                 localParamsM));
    
     var toDirectory = (rootDirectory == currentPathM ? currentPathM :
                      rootDirectory+"/"+ currentPathM );
     
     //if ( fileExistsInDirectory(theFileName,toDirectory) ){
     //   MessageBox("Sobreescribir fichero", 
     //             "El fichero \"" + theFileName +
     //              "\" ya existe. ¿Quieres sobreescribirlo? ",
     //              {Icon: MessageBox.IconsE.QUESTION});
     //}
     var fileName = $('#inputUploadFile').val();
     JSLogger.getInstance().debug("The file [ " + fileName +" ] will be "+
           "uploaded to the server in path [ " + toDirectory +" ]");
     
     var file = $('#inputUploadFile').get(0).files[0];
     
     var ajaxObject = new Ajax();
     var url = localGetCurrentPathM("FileBrowser.js") + "UploadFile.php";
     JSLogger.getInstance().trace("The file is uploaded using [ " + url +" ] ");
     ajaxObject.setUrl(url);
     ajaxObject.setPostMethod();
     ajaxObject.setCallback(null);
     var parameters = {};
     parameters.path = toDirectory;
     JSLogger.getInstance().trace("Paremeters [ " + JSON.stringify(parameters) +
           " ]");
     ajaxObject.setParameters(JSON.stringify(parameters));
     ajaxObject.sendFile(file);
     JSLogger.getInstance().debug("The request was processed with this response [ " + 
                            ajaxObject.getResponse() +" ]");
     
     //Process the response
     var jsonResponse = JSON.parse(ajaxObject.getResponse());
     if (parseInt(jsonResponse['ResultCode']) != 200 ){
        JSLogger.getInstance().error("The file [ "+fileName+
              " ] has not been uploaded to the server. Error [ " +
              jsonResponse['ErrorMsg'] +" ]");
        
        MessageBox("Error", "El fichero \"" + fileName +
              "\" no se ha subido al servidor. Error [ " + 
              jsonResponse['ErrorMsg'] +" ]",
              {Icon: MessageBox.IconsE.ERROR }
        );
        
     }else{
        JSLogger.getInstance().debug("The file [ " + fileName + 
              " ] was uploaded sucessfull");
        
        var directoryStructure = getFilesAndDirectories();
        
        directoryStructure[fileName]= null;
        
        showFilesAndDirectories(fullPathToString());
        
     }
     hideLoading();
     JSLogger.getInstance().traceExit();
  }
  
  /**
   * Function that show the toolbar button
   */
  this.setToolbar = function setToolbar(){
     JSLogger.getInstance().traceEnter();
     var toolbar = this.getParameter(this.TOOLBAR_PARAMS_C, this.parametersM);
     
     if (toolbar != null){
        JSLogger.getInstance().trace("Toolbar [ " + toolbar + " ]");
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
        
        $('#Filebrowser').find('.Title-Bar').after('<div id="FileBrowser-Toolbar"><div></div></div>');
        
        var buttons = toolbar.split("|");
        JSLogger.getInstance().trace("The toolbar has [ " + buttons.length +
              " ] buttons");
        var toolbarObject = $('#FileBrowser-Toolbar div');
        for( var button in buttons){
           
           var localParameters = this.parametersM;
           var localGetCurrentPathM = this.getCurrentPath("FileBrowser.js");
           
           if ( buttons[button] == TOOLBAR_BUTTON_UPLOAD_FILE_C ){
              JSLogger.getInstance().trace("Show button [ " + 
                    TOOLBAR_BUTTON_UPLOAD_FILE_C +" ]");
              toolbarObject.append('<button type="button" '+
                    'id="FileBrowser-upload-file" title="Subir un fichero" '+
                    'style="background-image:url(\''+
                    this.getCurrentPath("FileBrowser.js")+'icons/file_upload.png\');'+
                    'background-repeat: no-repeat;background-position: center"></button>');
              
               //Add the hidden file input htnl object.
              toolbarObject.append("<input id=\"inputUploadFile\" type=\"file\" style=\"display:none;\" name=\"selectedFile\">");
              $('#inputUploadFile').change(
                    function () {
                       JSLogger.getInstance().traceEnter();
                       if ($('#inputUploadFile').val().length > 0){
                          JSLogger.getInstance().debug("The file [ " + $('#inputUploadFile').val() +
                          " ] will be uploaded to the server");
                          
                          //uploadFile($('#inputUploadFile').val(),localParameters,
                          //      localGetCurrentPathM);
                          var rootDirectory = FileBrowser.prototype.getParameter(paramRootPathC,
                                FileBrowser.prototype.getParameter(paramPathC, 
                                      localParamsM));
                          var toDirectory = (rootDirectory == currentPathM ? currentPathM :
                             rootDirectory+"/"+ currentPathM );
            
                          if ( fileExistsInDirectory($('#inputUploadFile').val(),
                                toDirectory) ){
                             JSLogger.getInstance().trace("The file [ " + 
                                              $('#inputUploadFile').val() +
                                         " ] exists in the directory.");
                              MessageBox("Sobreescribir fichero", 
                                          "El fichero \"" + $('#inputUploadFile').val() +
                                       "\" ya existe. ¿Quieres sobreescribirlo? ",
                                          {Icon: MessageBox.IconsE.QUESTION,
                                           Buttons: {Buttons: MessageBox.ButtonsE.YES_NO,
                                                   Callback_Yes: uploadFile}
                                           });
                          
                          }else{
                             uploadFile();
                          }
                       }
                       JSLogger.getInstance().traceExit();
                    }
                 );
              $('#FileBrowser-upload-file').click(function(){
                 
                 $('#inputUploadFile').click();
              });
           }
           
          
           
           if ( buttons[button] == TOOLBAR_CREATE_FOLDER_C ){
              JSLogger.getInstance().trace("Show button [ " + 
                    TOOLBAR_CREATE_FOLDER_C +" ]");
              toolbarObject.append('<button type="button" '+
                    'id="FileBrowser-create-folder" title="Crear carpeta" '+
                    'style="background-image:url(\''+
                    this.getCurrentPath("FileBrowser.js")+'icons/folder_add.png\');'+
                    'background-repeat: no-repeat;background-position: center"></button>');
              $('#FileBrowser-create-folder').click(function(theEvent){
                 showEnterDirectoryName($(this), theEvent, localGetCurrentPathM, 
                                       localParameters);
              });
           }
           if ( buttons[button] == TOOLBAR_DELETE_C ){
              JSLogger.getInstance().trace("Show button [ " + 
                    TOOLBAR_DELETE_C +" ]");
              toolbarObject.append('<button type="button" '+
                    'id="FileBrowser-delete" title="Borrar" '+
                    'style="background-image:url(\''+
                    this.getCurrentPath("FileBrowser.js")+'icons/disabled_delete.png\');'+
                    'background-repeat: no-repeat;background-position: center"></button>');
              $('#FileBrowser-delete').attr("disabled", true);
              $('#FileBrowser-delete').click(function(){
                 removeFileOrDirectory(localParameters);
              });
           }
          
        }
     }
     JSLogger.getInstance().traceExit();
     
  }
  /**
   * Function that shows an image while the files and directories are loaded
   * from the server
   */
  var showLoading = function showLoading(){
     JSLogger.getInstance().traceEnter();
     $('#FilesContainer').append("<img src=\""+ localGetCurrentPathM("FileBrowser.js") +
     "/icons/load.gif\" width=\"48\" height=\"48\" style=\"position:absolute;"+
     "left:220px; top:175px\" id=\"loading\">");
     JSLogger.getInstance().traceExit();
  }
  
  /**
   * Function that hides the image while the files and directories are loaded
   */
  var hideLoading = function hideLoading(){
     JSLogger.getInstance().traceEnter();
     $('#loading').remove();
     JSLogger.getInstance().traceExit();
  }
  
  /**
   * Functions that performances a get request for take the directories and 
   * files of the directory.
   * The request is done through an Ajax class. The response is a JSON object
   * that contains the files and directories.
   * The response is save in JSON format in the stack
   */
   var getDirectoriesAndFiles = function getDirectoriesAndFiles(){
     
     JSLogger.getInstance().traceEnter();
     
     var url = FileBrowser.prototype.getCurrentPath("FileBrowser.js")+"Filebrowser.php";
     JSLogger.getInstance().trace("URL: [ " + url + " ]");
     
     var ajaxObject = new Ajax();
     ajaxObject.setUrl(url);
     ajaxObject.setPostMethod();
     ajaxObject.setSyn();
     var parameters = {};
     
     var pathParameters = FileBrowser.prototype.getParameter(paramPathC, 
                                       this.parametersM);
     parameters.rootDirectory = FileBrowser.prototype.getParameter(paramRootPathC, pathParameters);
     if (parameters.rootDirectory == null){
        parameters.rootDirectory = "./";
     }
     parameters.type = FileBrowser.prototype.getParameter(paramTypeC, 
          this.parametersM);
     if (parameters.type == null){
        parameters.type = "a";
     }
     parameters.filter = FileBrowser.prototype.getParameter(paramFilterC,
           this.parametersM);
     if (parameters.filter == null){
        parameters.filter = "*.*";
     }
     JSLogger.getInstance().debug("Parameters [ " + JSON.stringify(parameters) +" ]");
     ajaxObject.setParameters( JSON.stringify(parameters));
     ajaxObject.setCallback(null);
     JSLogger.getInstance().debug("Sending sync request ...");
     ajaxObject.send();
     JSLogger.getInstance().debug("Response [ " + ajaxObject.getResponse() +" ]");
     
     pushFilesAndDirectories(JSON.parse(ajaxObject.getResponse()));
     JSLogger.getInstance().traceExit();
     
  }
  
   
 
  

  FileBrowser.prototype = Object.create(HtmlForm.prototype);
  FileBrowser.prototype.constructor = FileBrowser;
  FileBrowser.prototype.addButtons = addButtons;
  FileBrowser.prototype.setToolbar = setToolbar;
  FileBrowser.prototype.showLoading = showLoading;
  FileBrowser.prototype.hideLoading = hideLoading;
  FileBrowser.prototype.getDirectoriesAndFiles = getDirectoriesAndFiles;
  //FileBrowser.prototype.showFilesAndDirectories = showFilesAndDirectories;

  
  //return FileBrowser;
  var show = function show(theParams){
     JSLogger.getInstance().traceEnter();
     var fileBrowser = new FileBrowser(theParams);
     
     fileBrowser.addButtons();
     fileBrowser.showLoading();
     
     typeM = fileBrowser.getParameter(paramTypeC, fileBrowser.parametersM);
     if (typeM == null){
        typeM = "a";
     }
     
     fileBrowser.getDirectoriesAndFiles();
     var rootPath = fileBrowser.getParameter(paramRootPathC, 
           fileBrowser.getParameter(paramPathC, fileBrowser.parametersM));
     currentPathM = fileBrowser.getParameter(paramCurrentPathC, 
           fileBrowser.getParameter(paramPathC, fileBrowser.parametersM));
     if (currentPathM == null){
        currentPathM = rootPath;
     }
     goToCurrentPath(rootPath, currentPathM);
     
     showFilesAndDirectories(fullPathToString());
    
     fileBrowser.hideLoading();
     
     JSLogger.getInstance().traceExit();
  }
  
  return FileBrowser;
 }();



