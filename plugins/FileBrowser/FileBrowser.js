/**
 * Plugin that shows the files, in the first version only it shows the images,
 * that are stored in the server.
 */
 
 var FileBrowser = {
 
   enableDebug: true,
   debugSetup: {
      file: "FileBrowser.js"
                                              
   },
   
   //Definition of the global variables 
   titleM: "",
   titleC: "title",
   buttonsM: "",
   buttonsC: "buttons",
   btnSelectC: "SELECT",
   btnUploadC: "UPLOAD",
   btnDeleteC: "DELETE",
   
   fileBrowserM: null,
   
   pathUploadFileC: "pathUploadFile",
   pathUploadFileM: "",
      
   
   
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
    * Initialize the file browser before it is showed.
    *
    * @param theParameters: The parameters that are used to configure the 
    * file browser
    */
   init: function(theParameters){

      var methodName = "init";
      this.debugEnter(methodName);
      
      
      if ( theParameters[this.titleC] != null){      
         this.titleM = theParameters[this.titleC];
      
         this.debug(methodName, "File browser title [ " + this.titleM + " ]");
      }
      if (theParameters[this.buttonsC] != null){
         
         this.buttonsM = theParameters[this.buttonsC];
         this.debug(methodName, "Butttons to add [ " + this.buttonsM + " ]");      
      }
      this.pathUploadFileM = theParameters[this.pathUploadFileC];
      this.debug(methodName, "Directory where the files will be uploaded [ " + 
                             this.pathUploadFileM + " ]");
  
      //Create the div that contains the file browser and the buttons
      this.debug(methodName, "Create the file browser");
      this.fileBrowserM = $("<div id=\"FileBrowser\"></div>");
      
      this.debug(methodName,"Create the div where the title is showed");
      this.fileBrowserM.append("<div id=\"FileBrowserTitle\">"+this.titleM+"</div>");
      
      this.debug(methodName,"Create the div where the files are showed");
      this.fileBrowserM.append("<div id=\"FileBrowserFiles\"></div>");
       
      this.debug(methodName,"Create the div where the buttons is showed");
      this.fileBrowserM.append("<div id=\"FileBrowserBarButtons\"></div>");
      
      
      this.debugExit(methodName);
         
   },
   
   
   addButtons: function(){
	   
	   var methodName = "addButtons";
	   this.debugEnter(methodName);
	   
	   //the close button allways must be added
	   this.debug(methodName, "Add the close button");
	   $("#FileBrowserBarButtons").append("<button id=\"btn_close\" class=\"button\">\nCerrar\n</button>\n");
	   //Add the click event to the close button
	   $('#btn_close').click( 
	      function(){
	         FileBrowser.debugEnter("#btn_close::click");
	         $('#FileBrowser').remove();
		     $('#FileBrowserBackground').remove();
		     FileBrowser.debugExit("#btn_close::click");
	      }
	   );
	   
	   
	   //Slipt the parameters buttons, and show the buttons in order
	   var arrayButtons = this.buttonsM.split('|');
	   for (var x = arrayButtons.length; x > 0 ; x--){
		   
	      //Check if the select button must be showed
		  if (arrayButtons[x-1].toUpperCase().indexOf(this.btnSelectC) > -1){
	         this.debug(methodName, "Add the button " + this.btnSelectC);
			 $("#FileBrowserBarButtons").append("<button id=\"btn_select\" class=\"button\">\nSeleccionar\n</button>\n");
			 $('#btn_select').attr("disabled", "disabled");
		   }
		//Check if the upload button must be showed
		  if (arrayButtons[x-1].toUpperCase().indexOf(this.btnUploadC) > -1){
	         this.debug(methodName, "Add the button " + this.btnUploadC);
			 $("#FileBrowserBarButtons").append("<button id=\"btn_upload\" class=\"button\">\nSubir Imagen\n</button>\n");
			 
		   }
		//Check if the delete button must be showed
		  if (arrayButtons[x-1].toUpperCase().indexOf(this.btnDeleteC) > -1){
	         this.debug(methodName, "Add the button " + this.btnDeleteC);
			 $("#FileBrowserBarButtons").append("<button id=\"btn_delete\" class=\"button\">\nBorrar\n</button>\n");
			 $('#btn_delete').attr("disabled", "disabled");
		  }
	   }
	   
	   
	   
	   this.debugExit(methodName);
   },
   
   /**
    * Show the file browser
    */
   show: function(){
      var methodName = "show";
      this.debugEnter(methodName);
      $('body').append("<div id=\"FileBrowserBackground\"></div>");
      $('body').append(this.fileBrowserM);
      
      this.addButtons();
      
      this.debugExit(methodName);   
   }, 
 
 };
   