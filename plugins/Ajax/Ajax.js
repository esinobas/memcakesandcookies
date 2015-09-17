

function Ajax(){

   JSLogger.getInstance().registerLogger(arguments.callee.name, JSLogger.levelsE.ERROR);
   JSLogger.getInstance().traceEnter();
   
   this.urlM = "";
   this.parametersM = "";
   this.methodM = "GET";
   this.modeM = "asyn";
   this.callbackM = null;
   this.isFileM = false;
   this.responseM = "";
   
   JSLogger.getInstance().traceExit();


}
Ajax.prototype.setUrl = function(theUrl){

   //console.debug("Ajax::setUrl()::Enter");
   this.urlM = theUrl;
   //console.debug("Ajax::setUrl()::Exit");
}

Ajax.prototype.setGetMethod = function () {
   this.methodM = "GET";
}

Ajax.prototype.setPostMethod = function () {
   this.methodM = "POST";
}

Ajax.prototype.setAsyn = function () {
   this.modeM = "asyn";
}
Ajax.prototype.setSyn = function () {
   JSLogger.getInstance().trace("Enter-Exit");
   this.modeM = "syn";
}
Ajax.prototype.setParameters = function (theParameters){
   this.parametersM = theParameters;
}

Ajax.prototype.setCallback = function(theCallback){
   this.callbackM = theCallback;
   //console.debug("Ajax::setCallback()::"+this.callbackM);
}

Ajax.prototype.setFile = function () {
   this.isFileM = true;
  
}

Ajax.prototype.getResponse = function(){
   return this.responseM;
}

Ajax.prototype.send = function(){
   
      JSLogger.getInstance().traceEnter();
      
      var xmlHttpRequest = new XMLHttpRequest();
      
      var mode = true;
      if (this.modeM !== "asyn"){
      
         JSLogger.getInstance().trace("Ajax::send()::It is a synchronous request");
         mode = false;
      }
      JSLogger.getInstance().debug("Send request [ " + this.methodM + " ] to [ " +this.urlM + "] with these parameters [ " + this.parametersM + " ].");
      
      //if (this.methodM == "POST"){
         
        var callback = this.callbackM;
        var modeComm = this.modeM;
             
        xmlHttpRequest.onreadystatechange = function onreadystatechange() {
            
        
              if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200){
                 JSLogger.getInstance().debug("The request finished");
                                  
                 if ((modeComm === "asyn") && (callback !== null)){
              
                    JSLogger.getInstance().trace("The response has been received.");
                    JSLogger.getInstance().trace("Response[ " + xmlHttpRequest.responseText +" ]");

                 
                    JSLogger.getInstance().trace("Call callback");
                    callback(xmlHttpRequest.responseText); 
                    JSLogger.getInstance().trace("The callback function has been called");
                 }
              }        
                  
        };   
         
      //}
  
        JSLogger.getInstance().trace("The method is [ " + this.methodM +" ]");
      
      if (this.methodM == "GET"){
         JSLogger.getInstance().trace("GET request with parameters");
         JSLogger.getInstance().trace("Parameters [ " + this.parametersM + " ]");
         var parameters = JSON.parse(this.parametersM);  
         var parameterString = ""; 
         var firstParameter = true;
         for (var key in parameters){
            JSLogger.getInstance().trace("[ " + key +" ][ " + parameters[key] + " ]");
            if (!firstParameter){
               parameterString = parameterString + "&";
                          
            }else{
               firstParameter = false;            
            }
            parameterString = parameterString + key + "="+parameters[key];
         }
         this.urlM = this.urlM+"?"+parameterString;
         JSLogger.getInstance().debug("New url: [ " + this.urlM + " ]");
            
      }
      xmlHttpRequest.open(this.methodM, this.urlM, mode);
      
      if (this.methodM == "POST"){
         
         
         JSLogger.getInstance().trace("Method POST, adding header");
         xmlHttpRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");         
         
      }
      
      if (this.methodM == "POST"){
         if(this.parametersM.length > 0){
         
            JSLogger.getInstance().trace("Send request with parameters");
            JSLogger.getInstance().trace("Parameters [ " + this.parametersM + " ]");
            var parameters = JSON.parse(this.parametersM);  
            var parameterString = ""; 
            var firstParameter = true;

            for (var key in parameters){
            
               if (typeof(parameters[key])==="object"){
                  JSLogger.getInstance().trace("[ " + key +" ][ " +
                        JSON.stringify(parameters[key]) + " ]");
               }else{
                  JSLogger.getInstance().trace("[ " + key +" ][ " + parameters[key] + " ]");
               }
               
               if (!firstParameter){
                  parameterString = parameterString + "&";
                          
               }else{
                  firstParameter = false;            
               }
            
               if (typeof(parameters[key])==="object"){
                  parameterString = parameterString + key + "="+JSON.stringify(parameters[key]);
               }else{
                  parameterString = parameterString + key + "="+parameters[key];
               }
         }
            
            JSLogger.getInstance().trace("Parameters String [ " + parameterString + " ]");
         xmlHttpRequest.send(parameterString);
        }else{
           JSLogger.getInstance().debug("Send request without parameters");
           xmlHttpRequest.send();
        }
      }else{
         JSLogger.getInstance().debug("GET request without parameters");
         xmlHttpRequest.send();
      }
            
      JSLogger.getInstance().debug("Request sent");
      if (this.modeM !== "asyn"){
         this.responseM = xmlHttpRequest.responseText;
         JSLogger.getInstance().debug("reponse [ "+ this.responseM +" ]");
      }
      JSLogger.getInstance().traceExit();
   
   };
   
   Ajax.prototype.sendFile = function (theFile){
     
      JSLogger.getInstance().traceEnter();
      
      var xmlHttpRequest = new XMLHttpRequest();
      var formData = new FormData();
      
      this.methodM = "POST";
      this.modeM =" syn";
      var mode = true;

      if (this.modeM !== "asyn"){
      
         console.debug("Ajax::sendFile()::It is a synchronous request");
         mode = false;
      }
      var callback = this.callbackM;
     xmlHttpRequest.onreadystatechange = function () {
            
              
              
              if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200){
                 
                 if ((this.modeM === "asyn") && (callback !== null)){
                    console.debug("Ajax::sendFile()::onreadystatechange::The file has been uploaded with successfully");
                    console.debug("Ajax::sendFile()::onreadystatechange::Resultado: " +  xmlHttpRequest.responseText);
                 
                 
                    callback(xmlHttpRequest.responseText); 
                 }
              }
      };
  
      console.debug("Ajax::sendFile()::Send or Upload file [ " + theFile.name + " ] to [ " +this.urlM + "] with size [ " + theFile.size + " ]");
      xmlHttpRequest.open(this.methodM, this.urlM, mode);
      formData.append("fileNameToSend", theFile);
      
      if (this.parametersM.length > 0){
         console.debug("Ajax::sendFile()::There are parameters: [ " + this.parametersM + " ].");
         var variable = JSON.parse(this.parametersM);
         for (var key in variable){
            console.debug("Ajax::sendFile()::[ " + key +" ][ " + variable[key] + " ]");
            formData.append(key, variable[key]);         
         }
         
      }
      xmlHttpRequest.send(formData);
      if (this.modeM !== "asyn"){
         this.responseM = xmlHttpRequest.responseText;
         console.debug("Ajax::sendFile()::response [ " + this.responseM +" ]");
      }
      console.debug("Ajax::sendFile()::The file was sent.");
     
      JSLogger.getInstance().traceExit();
   
   };