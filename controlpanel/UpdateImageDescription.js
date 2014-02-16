var UpdateImageDescription = {
   
   enableDebug: true,
   debugSetup: {
                  file: "UpdateImageDescription.js"
                                              
    },
    
    imageIdC: "imageId",
    descriptionC: "description",
    imageIdM: "",
    
      
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
    
    //Function that shows the dialogue box with the current image description 
    // and it allows update it.
    //
    //param theParameters: array that contains a list of parameters that are
    //passed to the method. 
    show: function(theParameters){
        var methodName = "show";
        this.debugEnter(methodName);
        imageIdM = theParameters[this.imageIdC];
        var desc = theParameters[this.descriptionC];
        this.debug(methodName, "Image Id [ " + imageIdM + " ]. Description [ " + desc + " ]");
        
        var divBackground = $("<div id=\"background_update_description\"></div>");
        var divForm = $("<div id=\"form_update_description\"></div>");
        $("body").append(divBackground);
        $("body").append(divForm);

        var divWork = $("<div id=\"work_update_description\"></div>");
        $("#form_update_description").append(divWork);
        
        $("#work_update_description").append("<div id=\"label_update_description\">Descripción</div>");
        $("#work_update_description").append("<input type=\"text\" id=\"input_data_update_description\" maxlength=\"100\"></input>");
        
         $("#form_update_description").append("<div id=\"buttons_update_description\"></div>");       
        
        //Cancel button
        $("#buttons_update_description").append("<button id=\"cancel_update_description\" class=\"btn_update_description\">Cancelar</button>");  
        $("#cancel_update_description").click( function () {
           
              $("#form_update_description").remove();
              $("#background_update_description").remove();
              
           }
    
        );                 
        
        //ok button
        $("#buttons_update_description").append("<button id=\"ok_update_description\" class=\"btn_update_description\">Aceptar</button>");        
        
        //set the description in the input data
        $("#input_data_update_description").val(desc);
        
                
        this.debugExit(methodName);
    },

};