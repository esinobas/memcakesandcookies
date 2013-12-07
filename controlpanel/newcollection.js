var newcollection = {

    idCollectionC: 'idCollection',
    urlC: 'url',
    idCollectionM: 0,
    urlM: "",

    enableDebug: false,
    debugSetup: {
                  file: "newcollection.js"
                                              
    },
    
    debugEnter: function (theMethod) {
            if (this.enableDebug == true){
               var textToDebug = this.debugSetup['file'] + '::'+theMethod+'()::Enter';
               console.debug(textToDebug);
            }
    },
    debugExit: function (theMethod) {
            if (this.enableDebug == true){
               var textToDebug = this.debugSetup['file'] + '::'+theMethod+'()::Exit';
               console.debug(textToDebug);
            }
    },
    debug: function (theMethod, theText) {
            if (this.enableDebug == true){
               var textToDebug = this.debugSetup['file'] + '::'+theMethod+'()::'+theText;
               console.debug(textToDebug);
            }
    },
    
    refreshCombo:function(theData){
       var methodName = "insertCollection";
       
       this.debugEnter(methodName);
       
       this.debug(methodName, "The Data [ " + theData + " ]");
       var jsonParsed = JSON.parse(theData);
       $("#comboCollection").append("<option value=\"" + jsonParsed['id'] + "\">"+jsonParsed['menu']+"</option>");
       this.debugExit(methodName);
    
    },
    
    insertCollection:function(theNewCollection){
       var methodName = "insertCollection";
       
       this.debugEnter(methodName);
       this.debug(methodName, "The new submenu will be child of [ " + this.idCollectionM +" ]");
       this.debug(methodName, "Url [ " + this.urlM +" ]");
       
       var ajaxObject = new Ajax();
       ajaxObject.setUrl(this.urlM);
       ajaxObject.setPostMethod();
       ajaxObject.setSyn();
       var parametersArray = {};
       parametersArray.parent = this.idCollectionM;
       parametersArray.menu = theNewCollection;
       var parameters = JSON.stringify(parametersArray);
       this.debug(methodName, "Parameters [ " + parameters +" ]");
        
       ajaxObject.setParameters(parameters);
       ajaxObject.send();
       this.refreshCombo(ajaxObject.getResponse());
       this.debugExit(methodName);
    },

   show:function (theParameters) {
      
      var methodName = "show";
      this.debugEnter(methodName);
      
      this.idCollectionM = theParameters[this.idCollectionC];
      this.urlM = theParameters[this.urlC];
      
      this.debug(methodName, "Adding new element for the collection [ " + this.idCollectionM +" ]");
      var divBackground = $("<div id=\"background\"></div>");
      var divForm = $("<div id=\"form\"></div>");
      $('body').append(divBackground);
      $('body').append(divForm);
      
      $('#form').append("<div id=\"form_data\"></div>");
      $('#form_data').append("<div id=\"label\">Nueva colección</div>");
      $('#form_data').append("<input type=\"text\" id=\"input_data\" maxlength=\"50\"></input>");
      
      $('#form').append("<div id=\"buttons\"></div>");
      $('#buttons').append("<button id=\"close\" class=\"button\">Cancelar</button>");
      $('#close').click(function () {
            $('#background').remove();
            $('#form').remove();
      }
      );
      $('#buttons').append("<button id=\"ok\" class=\"button\">Aceptar</button>");
      $('#ok').click(function () {
            newcollection.debugEnter("btnOk::click");
            newcollection.debug("btnOk::click","New collection [ " + $("#input_data").val() +" ]");
            newcollection.insertCollection( $("#input_data").val());
            $('#background').remove();
            $('#form').remove();
            newcollection.debugExit("btnOk::click");
      }
      );
      this.debugExit(methodName);
      
   
   }


};