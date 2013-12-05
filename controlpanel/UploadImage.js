var UploadImage = {

   enableDebug: true,
    debugSetup: {
                  file: "UploadImage.js"
                                              
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

   /**
    * Method that shows the dialogue for select an image and write its description
    */ 
    show:function () {
    
       var methodName = "show";
       debugEnter(methodName);
       debugExit(methodName);    
    
    }


};