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
   fileNameC: "FileBrowser.js",
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
   
   selectedFileColorC: "color_selected_file",
   selectedFileColorM: "blue",
   
   imageBorderColorPreviousM: "",
   
   fileSelectedM: "",
   serverTypeC: "server_type",
   serverTypeM: "Directory",
   
   customParamsC : "custom_params",
   customParamsM : "",
      
   
   
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
    * Functions that uploads a file to the server.
    * 
    * @param theFile: The file name that will be upload to the server
    */
   uploadFile: function (theFile){
	   
	   var methodName = "uploadFile";
	   this.debugEnter(methodName);
	   
	   this.debug(methodName, "The file [ " + theFile + " ] will be uploaded");
	   var fileBrowser = FileBrowserFactory.getFileBrowser(FileBrowser.serverTypeM, null);
      fileBrowser.uploadFile(theFile, this.pathUploadFileM);
      
	   this.refresh();
	   this.debugExit(methodName);
	 
	 },
	 
	 /**
	  * Method that shows the files in the file browser
	  * 
	  * @param theJSONFiles String in JSON format
	  *  where are saved the files that will be showed
	  */
   showFiles: function( theJSONFiles){
      var methodName = "showFiles";
      this.debugEnter(methodName);
      
      this.debug(methodName, "Remove the files that are within #FileBrowserFiles");
      $('#FileBrowserFiles').empty();
      
      var jsonParsed = JSON.parse(theJSONFiles);
      
      var imagePerRow = 0;
      var url = window.location.protocol + "//" + window.location.hostname;
      this.debug(methodName,"URL [ " + url + " ]");
      for (var idx = 0; idx < jsonParsed.length; idx++){
         
         var div = $("<div class=\"div_image\"></div>");
         
         this.debug(methodName, "Add file [ " + jsonParsed[idx] +" ]");
         
         var img="<img src=\""+url+"/" + jsonParsed[idx] +"\">";
         div.append(img);
         
         $('#FileBrowserFiles').append(div);
         
         if (imagePerRow < 3 ){
            
            imagePerRow++;
         }else{
            imagePerRow = 0;
              
            $('#FileBrowserFiles').append("<div class=\"div_new_row\"></div>");    
         }
         
      }
      //Add the method hover to all images loaded. This method changes the 
      //border color of the selectec image
      $('.div_image').hover(
           
            function(){
               var methodName = ".div_image::hover::In";
               //FileBrowser.debugEnter(methodName);
               FileBrowser.imageBorderColorPreviousM = $(this).css('border-top-color');
               //FileBrowser.debug(methodName, "Border Color [ " + imageBorderColorPreviousM + " ]");
               $(this).css({"border-color":FileBrowser.selectedFileColorM,
                  "border-width":"1px","border-style":"solid"});
               //FileBrowser.debugExit(methodName);
            },
            function(){
               var methodName = ".div_image::hover::Out";
               //FileBrowser.debugEnter(methodName);
               
               //FileBrowser.debug(methodName, "Previous Border Color [ " + imageBorderColorPreviousM + " ]");
               $(this).css({"border-color":FileBrowser.imageBorderColorPreviousM,
                  "border-width":"1px","border-style":"solid"});
               //FileBrowser.debugExit(methodName);
               
            }
       );
      
      //Add the event click for all showed images in the file browser
      $('.div_image').click(
          function(){
             //Clear the background of the all images
             $('.div_image').css("background-color", "white");
             //Set the configured color in the selected file background
             $(this).css("background-color", FileBrowser.selectedFileColorM);
             //Enable the delete button and seletec button
             $('#btn_select').attr("disabled", false);
             $('#btn_delete').attr("disabled", false);
             //Hay que guardar el fichero seleccionado, quitando la url, solo
             //dejando el path que se pasa por parametro
             FileBrowser.fileSelectedM = $(this).find("img").attr("src");
          }
       );
      this.debugExit(methodName);
      
   },
   /**
    * Method that shows the files that are stored in the server
    */
	 refresh: function(){
	    
	    var methodName = "Refresh";
	    this.debugEnter(methodName);
	    
	    this.debug(methodName, "Create Ajax object to refresh the file list");
	    var url = this.getCurrentPath(this.fileNameC) + "FileBrowser.php";
	    this.debug(methodName, "The url is [ " + url + " ]");
	    var ajaxObject = new Ajax();
	    ajaxObject.setUrl(url);
	    ajaxObject.setPostMethod();
	    ajaxObject.setSyn();
	    var parameters = {};
	    parameters.type = FileBrowser.serverTypeM;
	    parameters.params = {};
	    parameters.params.path = this.pathUploadFileM;
	    parameters.params.filter = "jpg,png,gif,bmp,tif";
	    parameters.params.custom_params = this.customParamsM;
	    this.debug(methodName,  "Parameters [ " +JSON.stringify(parameters) + " ]");
	    ajaxObject.setParameters( JSON.stringify(parameters));
	    ajaxObject.setCallback(null);
	    
	    ajaxObject.send();
	    this.debug(methodName, "Response [ " + ajaxObject.getResponse() + " ]");
	    FileBrowser.showFiles(ajaxObject.getResponse());
	    this.debugExit(methodName);
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
      if (theParameters[this.selectedFileColorC] != null){
         this.selectedFileColorM = theParameters[this.selectedFileColorC];
         
      }
      this.debug(methodName, "The color selected file is [ " + 
            this.selectedFileColorM + " ]");
      
     
      if (theParameters[this.serverTypeC] != null){
         this.debug(methodName, "The parameter [ " + this.serverTypeC + 
                     " ]  is present in the parameters");
         this.serverTypeM = theParameters[this.serverTypeC];
      }
      this.debug(methodName, "The server type is [ " + this.serverTypeM + " ]");
      
      if (theParameters[this.customParamsC] != null ){
         
         this.customParamsM = theParameters[this.customParamsC];
         this.debug(methodName, "Custom params [ " + this.customParamsM +
                    " ]");
      }
  
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
   
   /**
    * Function that adds an input file object, it is hidden, in the file 
    * browser. With this object the user can select a local file and it 
    * will be uploaded to the server.
    */
   addInputFile: function(){
	   var methodName = "addInputFile";
	   this.debugEnter(methodName);
	   
	   this.debug(methodName, "Create and add the input object type file. It is a hidden object");
	   
	   $('#FileBrowserBarButtons').append("<input id=\"inputUploadFile\" type=\"file\" style=\"display:none;\" name=\"selectedFile\">");
	                  
	   $('#inputUploadFile').change(
	         function () {
	            var methodName = "#inputUploadFile::change";
	            FileBrowser.debugEnter(methodName);
	            if ($('#inputUploadFile').val().length > 0){
	               FileBrowser.debug(methodName, "The file [ " + $('#inputUploadFile').val() +
	               " ] will be uploaded");
	            	
	            	FileBrowser.uploadFile($('#inputUploadFile').val());
	            }
	            FileBrowser.debugExit(methodName);
	         }
	      );
	   this.debugExit(methodName);
   },
   
   callback: function(){
      
      var methodName = "callback";
      this.debugEnter(methodName);
      
      FileBrowser.refresh();
      this.debugExit(methodName);
   },
   
   
   
   /**
    * Funtion that adds the buttons to the filebrowser to handle the files
    */
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
			 
			 $('#btn_select').click(
			       function(){
			          var methodName = "#btn_select::click";
			          FileBrowser.debugEnter(methodName);
			          var initPath = 
                      FileBrowser.fileSelectedM.indexOf(FileBrowser.pathUploadFileM);
                   var selectedFile = FileBrowser.fileSelectedM.substr(initPath,
                         FileBrowser.fileSelectedM.length - initPath);
                   selectedFile = selectedFile.substr(selectedFile.lastIndexOf("/") + 1 ,
                         selectedFile.length - selectedFile.lastIndexOf("/"));
			          FileBrowser.debug(methodName, "Selected File [ " + 
			                selectedFile + " ]");
			          FileBrowser.debug("## "+methodName, FileBrowser.callback);
			          var fileBrowser = FileBrowserFactory.getFileBrowser(FileBrowser.serverTypeM, FileBrowser.callback);
			          fileBrowser.selectFile(FileBrowser.pathUploadFileM,
			                 selectedFile, 
			                 FileBrowser.customParamsM);
			          
			          
			          FileBrowser.debugExit(methodName);
			          
			       }
			 );
		   }
		//Check if the upload button must be showed
		  if (arrayButtons[x-1].toUpperCase().indexOf(this.btnUploadC) > -1){
	         this.debug(methodName, "Add the button " + this.btnUploadC);
			 $("#FileBrowserBarButtons").append("<button id=\"btn_upload\" class=\"button\">\nSubir Imagen\n</button>\n");
			 //Add the click event in the upload file button
             $('#btn_upload').click(function(){
             
                var methodName = "#btn_upload::click";
                FileBrowser.debugEnter(methodName);
                
                $('#inputUploadFile').click();
                
                FileBrowser.debugExit(methodName);
             }
             );
		   }
		//Check if the delete button must be showed
		  if (arrayButtons[x-1].toUpperCase().indexOf(this.btnDeleteC) > -1){
	         this.debug(methodName, "Add the button " + this.btnDeleteC);
			 $("#FileBrowserBarButtons").append("<button id=\"btn_delete\" class=\"button\">\nBorrar\n</button>\n");
			 $('#btn_delete').attr("disabled", "disabled");
			 //Add the functionality to the delete button
			 $('#btn_delete').click(
			    function(){
			       var methodName = "#btn_delete::click";
			       FileBrowser.debugEnter(methodName);
			       var confirmacion = confirm('¿Borrar fichero "'+FileBrowser.fileSelectedM+'"?');
	               if (confirmacion == true){
	                  FileBrowser.debug(methodName, "The file [ " + 
	                        FileBrowser.fileSelectedM + " ] will be removed.");
	                  
	                  var initPath = 
	                     FileBrowser.fileSelectedM.indexOf(FileBrowser.pathUploadFileM);
	                  var fileToRemove = FileBrowser.fileSelectedM.substr(initPath,
	                        FileBrowser.fileSelectedM.length - initPath);
	                  FileBrowser.debug(methodName, "File to remove [ " + 
	                                        fileToRemove +" ]");
	                  
	                  var fileBrowser = FileBrowserFactory.getFileBrowser(FileBrowser.serverTypeM);
	                  var result = fileBrowser.deleteFile(fileToRemove);
	                  
	                  /*
	                  FileBrowser.debug(methodName, "Create Ajax object to remove file");
	                  var url = FileBrowser.getCurrentPath(FileBrowser.fileNameC) + "DeleteFile.php";
	                  FileBrowser.debug(methodName, "The url is [ " + url + " ]");
	                  var ajaxObject = new Ajax();
	                  ajaxObject.setUrl(url);
	                  ajaxObject.setPostMethod();
	                  ajaxObject.setSyn();
	                  var parameters = '{"type":"Directory", "file":"'+fileToRemove+'"}';
	                  FileBrowser.debug(methodName, parameters);
	                  ajaxObject.setParameters(parameters);
	                  ajaxObject.setCallback(null);
	                  
	                  ajaxObject.send();
	                  FileBrowser.debug(methodName, "Response [ " + ajaxObject.getResponse() + " ]");
	                  */
	                  
	                  if (result != "OK"){
	                     alert('El fichero ' + FileBrowser.fileSelectedM 
	                           + ' no se ha podido borrar.');
	                  }else{
	                     $('#btn_select').attr("disabled", "disabled");
	                     $('#btn_delete').attr("disabled", "disabled");
	                     FileBrowser.refresh();
	                  }
	               }
			       
			       FileBrowser.debugExit(methodName);
			    }
			 );
		  }
	   }
	   
	   
	   
	   this.debugExit(methodName);
   },
   
   /**
    * Funtions that returns the current path
    * 
    * @return the current script path
    */
   getCurrentPath: function(theFileName){
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
	   
	   
   },
   
   /**
    * Show the file browser
    */
   show: function(){
      var methodName = "show";
      this.debugEnter(methodName);
      $('body').append("<div id=\"FileBrowserBackground\"></div>");
      $('body').append(this.fileBrowserM);
      this.addInputFile();
      this.addButtons();
      this.refresh();
      
      this.debugExit(methodName);   
   }, 
 
 };
   