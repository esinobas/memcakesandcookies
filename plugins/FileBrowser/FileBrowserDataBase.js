/**
 * Class with the methods for handler files in a server and add information
 * about the files in a data base in the server
 * 
 * The class is a child from FileBrowserDefault
 *
 */

function FileBrowserDataBase (){
      
   /**
    * Private properties
    */
   var _debugM = true;
   
   /**
    * Constructor
    */
   this.classNameM = "FileBrowserDataBase";
   this.debugEnter("Constructor");
   
   this.debugExit("Constructor");
   
   /**
    * It inserts in the a table in the database the file information.
    * 
    * The method, first shows a window with the selected image and it gives to 
    * the user an description for the image whether it has not description.
    * When the user confirms the action, the image data is inserted in the 
    * correspondind tables.
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
      this.debug(methodName, "Cheking if file [ " + thePath+"/"+theFile + " ] now is in the database.");
      var url = this.getCurrentPath(this.classNameM+".js") + "FileBrowserDataBaseCommands.php";
      this.debug(methodName, "URL [ " + url + " ]");
      var ajaxObject = new Ajax();
      ajaxObject.setUrl(url);
      ajaxObject.setPostMethod();
      ajaxObject.setSyn();
      
      var customParamOption = theParams['option'];
      var customParamCollection = theParams['collection'];
      
      /*var parameters = '{"command":"ExistFile","FileName":"'+ theFile + 
                                   '","option":"'+customParamOption+
                                       '","collection":"'+customParamCollection+
                                       '"}';*/
      var parameters = '{"command":"ExistFile","FileName":"'+ thePath+"/"+theFile +'"}';
      this.debug(methodName, "Parameters [ " + parameters +" ]");
      ajaxObject.setParameters(parameters);
      ajaxObject.setCallback(null);
      
      ajaxObject.send();
      this.debug(methodName, "Response [ " + ajaxObject.getResponse() + " ]");
      if (ajaxObject.getResponse() === "true"){
         
         this.debug(methodName, "The file [ " + thePath+"/"+theFile + " ] exists in the database");
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
                               image_collection: customParamCollection});
         
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
      this.debug(methodName, "Trying delete the file [ " + thePathAndFile +
               " ]");
      
      this.debugExit(methodName);
   };

}

//Hierachy
FileBrowserDataBase.prototype = new FileBrowserDefault();