

function Ajax(){

   console.debug("Ajax()::Enter");
   
   this.urlM = "";
   this.parametersM = "";
   this.methodM = "GET";
   this.modeM = "asyn";
   this.callbackM = null;
   this.isFileM = false;
   this.responseM = "";
   
   console.debug("Ajax()::Exit");


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
   console.debug("Ajax::setSyn()::Enter-Exit");
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
   
      console.debug("Ajax::send()::Enter");
      
      var xmlHttpRequest = new XMLHttpRequest();
      
      var mode = true;
      if (this.modeM !== "asyn"){
      
         console.debug("Ajax::send()::It is a synchronous request");
         mode = false;
      }
      console.debug("Ajax::send()::Send request [ " + this.methodM + " ] to [ " +this.urlM + "] with these parameters [ " + this.parametersM + " ].");
      
      //if (this.methodM == "POST"){
         
        var callback = this.callbackM;
        var modeComm = this.modeM;
             
        xmlHttpRequest.onreadystatechange = function () {
            
        
              if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200){
                 console.debug("Ajax::onreadystatechange()::The request finished");
                                  
                 if ((modeComm === "asyn") && (callback !== null)){
              
                    console.debug("Ajax::onreadystatechange()::The response has been received.");
                    console.debug("Ajax::onreadystatechange()::[ " + xmlHttpRequest.responseText +" ]");

                 
                    console.debug("Ajax::onreadystatechange()::Call callback");
                    callback(xmlHttpRequest.responseText); 
                    console.debug("Ajax::onreadystatechange()::The callback function has been called");
                 }
              }        
                  
        };   
         
      //}
  
      console.debug("Ajax::send()::The method is [ " + this.methodM +" ]");
      
      if (this.methodM == "GET"){
         console.debug("Ajax::send()::GET request with parameters");
         console.debug("Ajax::send()::Parameters [ " + this.parametersM + " ]");
         var parameters = JSON.parse(this.parametersM);  
         var parameterString = ""; 
         var firstParameter = true;
         for (var key in parameters){
            console.debug("Ajax::send()::[ " + key +" ][ " + parameters[key] + " ]");
            if (!firstParameter){
               parameterString = parameterString + "&";
                          
            }else{
               firstParameter = false;            
            }
            parameterString = parameterString + key + "="+parameters[key];
         }
         this.urlM = this.urlM+"?"+parameterString;
         console.debug("Ajax::send()::New url: [ " + this.urlM + " ]");
            
      }
      xmlHttpRequest.open(this.methodM, this.urlM, mode);
      
      if (this.methodM == "POST"){
         
         
         console.debug("Ajax::send()::Method POST, adding header");
         xmlHttpRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");         
         
      }
      
      if (this.methodM == "POST"){
         if(this.parametersM.length > 0){
         
         console.debug("Ajax::send()::Send request with parameters");
         console.debug("Ajax::send()::Parameters [ " + this.parametersM + " ]");
         var parameters = JSON.parse(this.parametersM);  
         var parameterString = ""; 
         var firstParameter = true;
         for (var key in parameters){
            console.debug("Ajax::send()::[ " + key +" ][ " + parameters[key] + " ]");
            if (!firstParameter){
               parameterString = parameterString + "&";
                          
            }else{
               firstParameter = false;            
            }
            parameterString = parameterString + key + "="+parameters[key];
         }
         console.debug("Ajax::send()::Parameters String [ " + parameterString + " ]");
         xmlHttpRequest.send(parameterString);
        }else{
         console.debug("Ajax::send()::Send request without parameters");
         xmlHttpRequest.send();
        }
      }else{
         console.debug("Ajax::send()::GET request without parameters");
         xmlHttpRequest.send();
      }
            
      console.debug("Ajax::send()::Request sent");
      if (this.modeM !== "asyn"){
         this.responseM = xmlHttpRequest.responseText;
         console.debug("Ajax:.send()::reponse [ "+ this.responseM +" ]");
      }
      console.debug("Ajax::send()::Exit");
   
   };
   
   Ajax.prototype.sendFile = function (theFile){
     
      console.debug("Ajax::sendFile()::Enter");
      
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
     
      console.debug("Ajax::sendFile()::Exit");
   
   };