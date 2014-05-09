var UploadImage = {

   enableDebug: false,
   debugSetup: {
                  file: "UploadImage.js"
                                              
    },
    
   imagePathM: "./",
   imagePathC: 'image_path',
   imageTypeM: "",
   imageTypeC: 'image_type',
    
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
    * Function that upload a file to the server
    */
   uploadFile: function (theFile, thePath){
      
      var methodName = "uploadFile";
 
      this.debugEnter(methodName);
      this.debug("The file [ " + theFile + " ] will be uploaded.");
   
      this.debug("Get the selected file in the file dialog box");
      var file = $('#inputUploadFile').get(0).files[0];

      this.debug("Create Ajax object to upload the file");
      var ajaxObject = new Ajax();
      ajaxObject.setUrl("./uploadFile.php");
      ajaxObject.setPostMethod();
      ajaxObject.setCallback(null);
      var parameters = '{"path":"'+ thePath +'"}';
      ajaxObject.setParameters(parameters);
      ajaxObject.sendFile(file);
      //refresh();
      this.debugExit(methodName);
 
   },
   
   insertIntoDDBB: function (thePath, theFileName, theDesc, theType){
   
       var methodName = "insertIntoDDBB";
 
       this.debugEnter(methodName);
       this.debug(methodName, "The next image will be inserted in the data base. Path [ " +
       thePath+" ]. FileName [ " + theFileName + " ]. Description [ " + theDesc + " ] and Type [ " + theType+ " ]");
       
       this.debug(methodName, "Create Ajax objecto to insert the image");
       var ajaxObject = new Ajax();
       ajaxObject.setPostMethod();
       ajaxObject.setSyn();
       ajaxObject.setCallback(null);
       ajaxObject.setUrl("./InsertImageIntoDDBB.php");
       var parametersArray = {};
       parametersArray.path = thePath;
       parametersArray.file = theFileName;
       parametersArray.desc = theDesc;
       parametersArray.typeImage = theType;
       var parameters = JSON.stringify(parametersArray);
       this.debug(methodName, "Parameters [ " + parameters +" ]");
       ajaxObject.setParameters(parameters);
       ajaxObject.send();
       this.debugExit(methodName);
   },
   
   /**
    * Method that shows the dialogue for select an image and write its description
    */ 
    show:function (theParameters) {
    
       var methodName = "show";
       debugEnter(methodName);
       
       this.imagePathM = theParameters[this.imagePathC];
       this.imageTypeM = theParameters[this.imageTypeC];

       this.debug(methodName, "The image type is [ " + this.imageTypeM + " ] and the image will loaded in [ " + this.imagePathM + " ]");       
       
       var divBackground = $("<div id=\"background_upload_image\"></div>");
       var divForm = $("<div id=\"form_upload_image\"></div>");
       $('body').append(divBackground);
       $('body').append(divForm);
        
       $('#form_upload_image').append("<div id=\"form_data_upload_image\"></div>");
       $('#form_data_upload_image').append("<div id=\"div_image_upload_image\">Pulsa para seleccionar una foto<div>");
       $('#div_image_upload_image').append("<img src=\"\" title=\"Imagen\" alt=\"Seleccionar image\">");
       $('#form_data_upload_image').append("<div id=\"label_upload_image\">Descripción</div>");
       $('#form_data_upload_image').append("<input type=\"text\" id=\"input_data_upload_image\" maxlength=\"100\"></input>");
       
       $('#form_upload_image').append("<div id=\"buttons_upload_image\"></div>");
       
       //Add the object input object  type file. It is a hidden object
       $('#buttons_upload_image').append("<input id=\"inputUploadFile\" type=\"file\" style=\"display:none;\" name=\"selectedFile\">");
       //add click event on div image for open de dialogue box and select the image
       $('#div_image_upload_image').click(
          function () {
             $('#inputUploadFile').click();
          }
       );
       //Add the event that loads the image and shows it
        $('#inputUploadFile').change(
         function () {
            UploadImage.debugEnter("inputLoadFile");
            
            if (this.files && this.files[0]){
               var reader = new FileReader();

               reader.onload = function (e) {
                  $('#div_image_upload_image').find('img').attr('src', e.target.result);
               }

               reader.readAsDataURL(this.files[0]);
            
           }
         
            UploadImage.debugExit("inputLoadFile");
                     
         }
      );
       
       $('#buttons_upload_image').append("<button id=\"close_upload_image\" class=\"button_upload_image\">Cancelar</button>");
       $('#close_upload_image').click(function () {
            $('#background_upload_image').remove();
            $('#form_upload_image').remove();
       }
       );
       
       //Add button ok
       $('#buttons_upload_image').append("<button id=\"ok_upload_image\" class=\"button_upload_image\">Aceptar</button>");
       $('#ok_upload_image').click(function () {
          
             var methodName = "show()::ok_upload_image::click";
             UploadImage.debugEnter(methodName);
             
             var imageDesc = $('#input_data_upload_image').val();
             var fileName = $('#inputUploadFile').val(); 
             
             UploadImage.debug(methodName, "File Name [ " + fileName +" ] with Description [ " 
             + imageDesc + " ] will be loaded to [ " + UploadImage.imagePathM +" ] and store in DDBB");
             
             UploadImage.uploadFile(fileName, UploadImage.imagePathM);
             
             //Save the path, file name and file description in the data base.
             if (UploadImage.imageTypeM == "Cakes"){
                 UploadImage.debug(methodName,"Insert into [ " + UploadImage.imageTypeM +" ]");
             }
             if (UploadImage.imageTypeM == "Cookies"){
                 UploadImage.debug(methodName,"Insert into [ " + UploadImage.imageTypeM +" ]");
             }
             if (UploadImage.imageTypeM == "Modelados"){
                 UploadImage.debug(methodName,"Insert into [ " + UploadImage.imageTypeM +" ]");
             }
         
             UploadImage.insertIntoDDBB(UploadImage.imagePathM, fileName, imageDesc, UploadImage.imageTypeM);
             
             refresAllImages(UploadImage.imageTypeM);
             
            $('#background_upload_image').remove();
            $('#form_upload_image').remove();
            UploadImage.debugExit(methodName);
       }
       );
       
       debugExit(methodName);    
    
    }


};