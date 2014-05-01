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
    * @param theFile
    */
   this.selectFile = function(theFile){
          
      var methodName = "selectFile";
      this.debugEnter(methodName);
      this.debug(methodName, "The file [ " + theFile + " ] has been selected.");
      this.debug(methodName, "Cheking if file [ " + theFile + " ] now is in the database.");
      var url = this.getCurrentPath(this.classNameM+".js") + "FileBrowserDataBaseCommands.php";
      this.debug(methodName, "URL [ " + url + " ]");
      var ajaxObject = new Ajax();
      ajaxObject.setUrl(url);
      ajaxObject.setPostMethod();
      ajaxObject.setSyn();
      
      var parameters = '{"command":"ExistFile","FileName":"'+ theFile + '"}';
      this.debug(methodName, "Parameters [ " + parameters +" ]");
      ajaxObject.setParameters(parameters);
      ajaxObject.setCallback(null);
      
      ajaxObject.send();
      this.debug(methodName, "Response [ " + ajaxObject.getResponse() + " ]");
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