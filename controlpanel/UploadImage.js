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
       debugExit(methodName);    
    
    }


};