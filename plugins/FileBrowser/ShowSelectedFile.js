var ShowSelectedFile = {

   enableDebug: true,
   debugSetup: {
                  file: "ShowSelectedFile.js"
                                              
    },
    classNameM: "ShowSelectedFile",
    
   imagePathM: "./",
   imagePathC: 'image_path',
   imageTypeM: "",
   imageTypeC: 'image_type',
   imageNameM: "",
   imageNameC: "image_name",
   imageCollectionC: "image_collection",
   imageCollectionM: "",
   callbackM: null,
    
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


   
   insertIntoDDBB: function (thePath, theFileName, theDesc, theType, theCollection){
   
       var methodName = "insertIntoDDBB";
 
       this.debugEnter(methodName);
       this.debug(methodName, "The next image will be inserted in the data base. Path [ " +
       thePath+" ]. FileName [ " + theFileName + " ]. Description [ " + theDesc +
       " ] and Type [ " + theType+ " ] and within the collection [ " + theCollection +" ]");
       
       this.debug(methodName, "Create Ajax object to insert the image");
       var ajaxObject = new Ajax();
       ajaxObject.setPostMethod();
       ajaxObject.setSyn();
       ajaxObject.setCallback(null);
       var url = this.getCurrentPath(this.classNameM+".js") + "FileBrowserDataBaseCommands.php";
       this.debug(methodName, "URL [ " + url + " ]");
       ajaxObject.setUrl(url);
       var parametersArray = {};
       parametersArray.command = "Insert new Image";
       parametersArray.path = thePath;
       parametersArray.file = theFileName;
       parametersArray.desc = theDesc;
       parametersArray.typeImage = theType;
       parametersArray.collection = theCollection;
       var parameters = JSON.stringify(parametersArray);
       this.debug(methodName, "Parameters [ " + parameters +" ]");
       ajaxObject.setParameters(parameters);
       ajaxObject.send();
       var result = ajaxObject.getResponse();
       this.debug(methodName, "Result [ " + result + " ]");
       this.debugExit(methodName);
       //return result;
   },
   
   /**
    * Method that shows the dialogue for select an image and write its description
    */ 
    show:function (theParameters, theCallback) {
    
       var methodName = "show";
       debugEnter(methodName);
       
       this.callbackM = theCallback;
       
       this.imagePathM = theParameters[this.imagePathC];
       this.imageTypeM = theParameters[this.imageTypeC];
       this.imageNameM = theParameters[this.imageNameC];
       this.imageCollectionM = theParameters[this.imageCollectionC];

       this.debug(methodName, "The image type is [ " + this.imageTypeM + 
                 " ].\nThe image will loaded in [ " + this.imagePathM + " ].\n"+
                 "The image name is [ " + this.imageNameM + " ].\n"+
                 "The image collection is [ " + this.imageCollectionM +" ].");       
       
       var divBackground = $("<div id=\"background_show_selected_image\"></div>");
       var divForm = $("<div id=\"form_show_selected_image\"></div>");
       $('body').append(divBackground);
       $('body').append(divForm);
        
       $('#form_show_selected_image').append("<div id=\"form_data_show_selected_image\"></div>");
       $('#form_data_show_selected_image').append("<div id=\"div_image_show_selected_image\"><div>");
       var url = window.location.protocol + "//" + window.location.hostname;
       var urlImage = url + "/" + this.imagePathM + "/" +this.imageNameM;
       this.debug(methodName, "Get & show image [ " + urlImage + " ]");
       
       $('#div_image_show_selected_image').append("<img src=\""+urlImage+"\" title=\""+this.imageNameM+"\">");
       $('#form_data_show_selected_image').append("<div id=\"label_show_selected_image\">Descripción</div>");
       $('#form_data_show_selected_image').append("<input type=\"text\" id=\"input_data_show_selected_image\" maxlength=\"100\"></input>");
       
       //Div with the buttons
       $('#form_show_selected_image').append("<div id=\"buttons_show_selected_image\"></div>");
       
       //Button close
       $('#buttons_show_selected_image').append("<button id=\"close_show_selected_image\" class=\"button_upload_image\">Cancelar</button>");
       $('#close_show_selected_image').click(function () {
            $('#background_show_selected_image').remove();
            $('#form_show_selected_image').remove();
       }
       );
       
       //Add button ok
       var localCallback = this.callbackM;
       $('#buttons_show_selected_image').append("<button id=\"ok_show_selected_image\" class=\"button_show_selected_image\">Aceptar</button>");
       $('#ok_show_selected_image').click(function () {
          
             var methodName = "show()::ok_show_selected_image::click";
             ShowSelectedFile.debugEnter(methodName);
             
             var imageDesc = $('#input_data_show_selected_image').val();
              
             
             ShowSelectedFile.debug(methodName, "File Name [ " + 
                   ShowSelectedFile.imagePathM+"/"+
                   ShowSelectedFile.imageNameM +" ] with Description [ " 
             + imageDesc + " ] will be save in DDBB");
             
             
             
             //Save the path, file name and file description in the data base.
             if (ShowSelectedFile.imageTypeM == "Cakes"){
                ShowSelectedFile.debug(methodName,
                      "Insert into [ " + ShowSelectedFile.imageTypeM +" ] "+
                      "and collection [ " + ShowSelectedFile.imageCollectionM +" ]");
             }
             if (ShowSelectedFile.imageTypeM == "Cookies"){
                ShowSelectedFile.debug(methodName,
                      "Insert into [ " + ShowSelectedFile.imageTypeM +" ]"+
                      "and collection [ " + ShowSelectedFile.imageCollectionM +" ]");
             }
             if (ShowSelectedFile.imageTypeM == "Modelados"){
                ShowSelectedFile.debug(methodName,
                      "Insert into [ " + ShowSelectedFile.imageTypeM +" ]"+
                      "and collection [ " + ShowSelectedFile.imageCollectionM +" ]");
             }
         
             ShowSelectedFile.insertIntoDDBB(ShowSelectedFile.imagePathM, 
                   ShowSelectedFile.imageNameM, 
                   imageDesc, ShowSelectedFile.imageTypeM,
                   ShowSelectedFile.imageCollectionM);
             
            //Debe ser llamada una funcion de callback, para mostrar las imagenes
             
             
             if (ShowSelectedFile.callbackM != null){
                ShowSelectedFile.debug(methodName,"Calling the callback");
                ShowSelectedFile.callbackM();
                
             }
             
             
            $('#background_show_selected_image').remove();
            $('#form_show_selected_image').remove();
            ShowSelectedFile.debugExit(methodName);
       }
       );
       
       debugExit(methodName);    
    
    },
    
    getCurrentPath : function(theFileName){
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

    }


};