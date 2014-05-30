/**
 * Class with the default operations to handle the files in a server directory
 */

function FileBrowserDefault (theCallback){
   
   //declare private properties
   
   var _debugM = false;
   
   FileBrowserDefault.prototype.classNameM = "FileBrowserDefault";
   FileBrowserDefault.prototype.callbackM = theCallback;
   
   
   //Methods to debug
   FileBrowserDefault.prototype.debugEnter = function (theMethodName){
      if (_debugM){
         var log = this.classNameM + "::" + theMethodName +"::Enter";
         console.debug(log);
      }
   };
   
   FileBrowserDefault.prototype.debugExit = function (theMethodName){
      if (_debugM){
         var log = this.classNameM + "::" + theMethodName +"::Exit";
         console.debug(log);
      }
   };
   
   FileBrowserDefault.prototype.debug = function (theMethodName, theMsg){
      if (_debugM){
         var log = this.classNameM + "::" + theMethodName +"::"+ theMsg;
         console.debug(log);
      }
   };
   
  
   
   /**
    * Abstract method that  must be overwritten in the childs class 
    * with commands that are executed when a file is selected
    * 
    * @param thePath The path of the file
    * @param the File
    * @param The custom params. It is a optional parameter.
    */
   FileBrowserDefault.prototype.selectFile = function(thePath, theFile,
                  theParams){
      var methodName = "selectFile";
      this.debugEnter(methodName);
      
      this.debugExit(methodName);
   };
   
   /**
    * Abstract method that must be overwritten in the childs class 
    * with commands that are executed when a file is removed.
    * 
    * @param thePathAndFile. Full path and file of the file that is deleted
    * 
    * @return A string indicanding the operation result
    */
   FileBrowserDefault.prototype.deleteFile = function(thePathAndFile){
      var methodName = "deleteFile";
      this.debugEnter(methodName);
      
      this.debug(methodName, "Create Ajax object to remove file");
      var url = this.getCurrentPath(this.classNameM+".js") + "DeleteFile.php";
      this.debug(methodName, "The url is [ " + url + " ]");
      var ajaxObject = new Ajax();
      ajaxObject.setUrl(url);
      ajaxObject.setPostMethod();
      ajaxObject.setSyn();
      var parameters = '{"type":"Directory", "file":"'+thePathAndFile+'"}';
      this.debug(methodName, "Parameters [ " + parameters + " ]");
      ajaxObject.setParameters(parameters);
      ajaxObject.setCallback(null);
      
      ajaxObject.send();
      this.debug(methodName, "Response [ " + ajaxObject.getResponse() + " ]");
      
      this.debugExit(methodName);
      return ajaxObject.getResponse();
   };
   
   /**
    * Funtcion that uploads a file to the server
    * 
    * @param theFile. The file that is uploaded to the server
    * @param thePath. Path where the file is uploaded
    */
   FileBrowserDefault.prototype.uploadFile = function(theFile, thePath){
      
      var methodName = "uploadFile";
      this.debugEnter(methodName);
      
      this.debug(methodName, "The file [ " + theFile + " ] will be uploaded "+
                     " to the [ " + thePath + " ] directory.");
      
      this.debug(methodName, "Get the selected file in the file dialog box");
      var file = $('#inputUploadFile').get(0).files[0];

      this.debug(methodName, "Create Ajax object to upload the file");
      var ajaxObject = new Ajax();
      var url = this.getCurrentPath(this.classNameM+".js") + "uploadFile.php";
      this.debug(methodName, "The file will be uploaded using the  [ " + url + " ]");
      ajaxObject.setUrl(url);
      ajaxObject.setPostMethod();
      ajaxObject.setCallback(null);
      var parameters = '{"path":"'+ thePath +'"}';
      this.debug(methodName, "Parameters  [ " + parameters + " ]");
      ajaxObject.setParameters(parameters);
      ajaxObject.sendFile(file);
      this.debugExit(methodName);
      
   };
   
   /**
    * Function that returns the current path
    * 
    * @return the current script path
    */
   FileBrowserDefault.prototype.getCurrentPath = function(theFileName){
      var methodName = "getCurrentPath";
      this.debugEnter(methodName);
      
      this.debug(methodName, theFileName);
     
      var path = "";
      var scripts = document.getElementsByTagName('script');
      if (scripts && scripts.length > 0) {
          
          
           for (var i in scripts) {
            if (scripts[i].src && scripts[i].src.match(/.js$/)){
               
               //this.debug(methodName,"Path Script[ " + scripts[i].src + " ]");
               
               if (scripts[i].src.match(new RegExp(theFileName+'$'))){
                  this.debug(methodName,"Current Script [ " + scripts[i].src + " ]");
                  path = scripts[i].src.substr(0, scripts[i].src.indexOf(theFileName));
                  
                  break;
               }
               
                
            }
               
               
           }
       }
      
       this.debug(methodName, "path [ " + path +" ]");
       this.debugExit(methodName);
       return path;

   };
   
   /**
    * It returns the server url
    * 
    * @returns the server url
    */
   FileBrowserDefault.prototype.getServerUrl = function(){
      
      var methodName = "getServerUrl";
      this.debugEnter(methodName);
      this.debug(methodName, "Server URL [ " + window.location.protocol + "//" +
                                        window.location.hostname +" ]");
      this.debugExit(methodName);
      return window.location.protocol + "//" + window.location.hostname;
   }
}
 