/**
 * Class with the methods for handler files in a server and add information
 * about the files in a data base in the server
 * 
 * The class is a child from FileBrowserDefault
 *
 */

function FileBrowserDataBase (theCallback){
      
   /**
    * Private properties
    */
   var _debugM = false;
   
   
   /**
    * Constructor
    */
   this.classNameM = "FileBrowserDataBase";
   this.callbackM = theCallback;
   this.debugEnter("Constructor");
   
   this.debugExit("Constructor");
   
   this.existFile = function(thePathAndFile){
      
      var methodName = "existFile";
      this.debugEnter(methodName);
      
      this.debug(methodName, "Cheking if file [ " + thePathAndFile + " ] now is in the database.");
      var url = this.getCurrentPath(this.classNameM+".js") + "FileBrowserDataBaseCommands.php";
      this.debug(methodName, "URL [ " + url + " ]");
      var ajaxObject = new Ajax();
      ajaxObject.setUrl(url);
      ajaxObject.setPostMethod();
      ajaxObject.setSyn();
      var parametersArray = {};
      parametersArray.command = "ExistFile";
      parametersArray.FileName = thePathAndFile;
      
      this.debug(methodName, "Parameters [ " + JSON.stringify( parametersArray ) +" ]");
      ajaxObject.setParameters(JSON.stringify( parametersArray ));
      ajaxObject.setCallback(null);
      
      ajaxObject.send();
      this.debug(methodName, "Response [ " + ajaxObject.getResponse() + " ]");
      
      this.debugExit(methodName);
      
      return (ajaxObject.getResponse() === "true" ? true : false);
   }
   
   /**
    * It inserts in the a table in the database the file information.
    * 
    * The method, first shows a window with the selected image and it gives to 
    * the user an description for the image whether it has not description.
    * When the user confirms the action, the image data is inserted in the 
    * corresponding tables.
    * 
    * @param thePath
    * @param theFile
    * @param theParams. The custom params. It is a optional parameter.
    */
   this.selectFile = function(thePath, theFile, theParams){
          
      var methodName = "selectFile";
      this.debugEnter(methodName);
      this.debug(methodName, "The file [ " + thePath+"/"+theFile +
            " ] has been selected.");
      var customParamOption = theParams['option'];
      var customParamCollection = theParams['collection'];
     
      if (this.existFile(thePath+"/"+theFile)){
         this.debug(methodName, "The file [ " + thePath+"/"+theFile + " ] exists in the database");
         var paramsArray = {};
         paramsArray.command = "Insert image in collection";
         paramsArray.path = thePath;
         paramsArray.file = theFile;
         paramsArray.collection = customParamCollection;
         this.debug(methodName, "Insert image in collection with following parameters [ " + 
               JSON.stringify(paramsArray) + " ]");
         var url = this.getCurrentPath(this.classNameM+".js") + "FileBrowserDataBaseCommands.php";
         this.debug(methodName, "URL [ " + url + " ]");
         var ajaxObject = new Ajax();
         ajaxObject.setUrl(url);
         ajaxObject.setPostMethod();
         ajaxObject.setSyn();
         ajaxObject.setParameters(JSON.stringify(paramsArray));
         ajaxObject.setCallback(null);
         
         ajaxObject.send();
         this.debug(methodName, "Response [ " + ajaxObject.getResponse() + " ]");
         this.callbackM();
         
      }else{
         
         this.debug(methodName, "The file [ " + thePath+"/"+theFile + " ] doesn't exist in the database");
         var paramsArray = {};
         paramsArray.image_path = thePath;
         paramsArray.image_file = theFile;
         paramsArray.image_type = customParamOption;
         paramsArray.image_collection = customParamCollection;
         this.debug(methodName, "Insert new image with following parameters [ " + 
               JSON.stringify(paramsArray) + " ]");
         ShowSelectedFile.show({image_path:thePath, image_name:theFile, 
                               image_type: customParamOption,
                               image_collection: customParamCollection},
                               this.callbackM);
         
      }
      this.debugExit(methodName);
   };
   
   /**
    * It remove an file from the server only when the file doesn't belong to a 
    * any table or the file is not any table. 
    */
   this.deleteFile = function (thePathAndFile){
      
      var methodName = "deleteFile";
      this.debugEnter(methodName);
      var result = "OK";
      this.debug(methodName, "Trying delete the file [ " + thePathAndFile +
               " ]");
      
      //check if the image is within the table where the images are saved.
      if (this.existFile(thePathAndFile)){
         
         this.debug(methodName, "The file [ " +thePathAndFile + " ] can be removed because it is in a table");
         alert('The file [ ' + thePathAndFile + ' ] no se puede borrar porque esta en la base de datos. Borralo primero de la base de datos');
         result = "NO OK";
      }else{
         this.debug(methodName, "The file [ " +thePathAndFile + " ] can be removed.");
         result = FileBrowserDataBase.prototype.deleteFile(thePathAndFile);
      }
      
      this.debugExit(methodName);
      return result;
   };

}

//Hierachy
FileBrowserDataBase.prototype = new FileBrowserDefault(FileBrowserDataBase.prototype.callbackM);