/**
 * Class that creates a class to handle the files from a server
*/


/**
 * Construct
 * 
 * @param theType The class type created by the factory to handle the files
 */
function FileBrowserFactory(){
   
   //private variables
   var _classNameM = "FileBrowserFactory";
   var _methodNameM = "constructor";
   var _debugM = true;
   
   /**
    * Method that writes in the console log a trace when the method starts
    * 
    * @param theMethodName The method name
    */
   this.debugEnter = function(theMethodName){
      if (_debugM){
         var log = _classNameM + "::" + theMethodName +"::Enter";
         console.debug(log);
      }
   };
   
   /**
    * Method that writes in the console log a trace when the method finishs
    * 
    * @param theMethodName The method name
    */
   this.debugExit = function(theMethodName){
      if (_debugM){
         var log = _classNameM + "::" + theMethodName +"::Exit";
         console.debug(log);
      }
   };
   
   /**
    * Method that writes in the console log a trace
    * 
    * @param theMethodName The method name
    * @param theLog The trace that is written
    */
   this.debug = function(theMethodName, theLog){
      if (_debugM){
         var log = _classNameM + "::" + theMethodName +"::"+theLog;
         console.debug(log);
      }
   };
   
   this.getFileBrowser = function(theType){
      
      var methodName = "getFileBrowser";
      this.debugEnter(methodName);
      this.debug(methodName, "Type [ " + theType + " ]");
      var returnObject = null;
      switch (theType){  
      case "Directory":
         returnObject = new FileBrowserDefault();
         break;
      }
   
      this.debugExit(methodName);
      return returnObject;
   };
   
};

//Static Method
FileBrowserFactory.getFileBrowser = function(theType){
   
   var _classNameM = "FileBrowserFactory";
   var _methodNameM = "getFileBrowser";
   
   var factory = new FileBrowserFactory();
   
   return factory.getFileBrowser(theType);
   
}