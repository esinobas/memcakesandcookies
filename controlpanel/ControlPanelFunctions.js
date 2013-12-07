/**
 * File with functions that are used for handler the control panel
 */

var fileNameC = "ControlPanelFunctions.js";
var enableDebugM = true;
 
/**
 * Function that prints in the console a log
 *
 *@param theFunction. The function name
 *@param theTrace. The trace to be printed 
*/  
function debug( theFunction, theTrace){
   if (enableDebugM){
      var trace = fileNameC+"::"+theFunction+"()::"+theTrace;
      console.debug(trace);
   }
}
/**
 * Function that prints in the console a log the entry in the method
 *
 *@param theFunction. The function name
*/  
function debugEnter( theFunction){
   if (enableDebugM){
      var trace = fileNameC+"::"+theFunction+"()::Enter";
      console.debug(trace);
   }
}
/**
 * Function that prints in the console a log the exist of the method
 *
 *@param theFunction. The function name

*/  
function debugExit( theFunction){
   if (enableDebugM){
      var trace = fileNameC+"::"+theFunction+"()::Exit";
      console.debug(trace);
   }
}



 
 /**
  * Function that shows and hides the div with the images and its corresponding
  * toolbar
  */ 
  function showSelectedCollection(){
     
     var methodName = "showSelectedCollection";
     debugEnter(methodName);
     
     var optionSelected = $('#comboCollection').val();
     debug(methodName, "Option selected [ " + optionSelected + " ]");
     
     if (parseInt(optionSelected) == 0){
         debug(methodName, "It has been selected all images.");  
         $('#All_images').show();
         $('#Collection_images').hide();  
     }else{
         debug(methodName, "It has been selected images collection.");
         $('#All_images').hide();
         $('#Collection_images').show();
     }
     
     debugExit(methodName);
   
  }
  
  
  
  
  /**
 * Function that sets the functions to the object
 */
function setFunctionsToObjects(){
     
     var methodName = "setFunctionsToObjects";
     debugEnter(methodName);
     
     debug(methodName, "Set event onchange to combobox");
     $('#comboCollection').change(function () { 
                                 showSelectedCollection();
                              }
     );
     
     //Add function to button for upload an image
     $('#btn_all_images_add').click(
        function () {
           UploadImage.show();        
        }
     );
     
     debugEnter(methodName);
     
}


/**
 * Function that refreshes the all images of the a container
 */
 function refresAllImages(theType){
    
    var methodName = "refresAllImages";
    debugEnter(methodName);
  
    debug(methodName, "Type [ " + theType + " ]");
     
    var ajaxObject = new Ajax();
    ajaxObject.setUrl("./getAllImages.php");
    ajaxObject.setGetMethod();
    ajaxObject.setSyn();
    var arrayParameters = {};
    arrayParameters.typeImage=theType.toUpperCase();
    ajaxObject.setParameters(JSON.stringify(arrayParameters));
    debug(methodName, "parameters [ " + JSON.stringify(arrayParameters) +" ]");
    ajaxObject.send();
    var response = ajaxObject.getResponse();
    debug(methodName, "Response [ " + response + " ]");
    var jsonParsed = JSON.parse(response);
    
    var items = 0;
    for (var idx = 0; idx < jsonParsed.length; idx ++){
    
       var path = jsonParsed[idx]['path'];
       var desc = jsonParsed[idx]['description'];
       debug(methodName, "Image Path [ " + path + " ]. Image Desc [ " + desc+ " ]");
       var newDiv = $("<div class=\"gallery_item\"></div>");
       newDiv.append("<img src=\"../"+path+ "\" alt=\""+desc+"\" title=\""+desc+"\"/><br>");
       newDiv.append(desc);
       $('#gallery_all_image').append(newDiv);
       if (items < 3){
          items ++;       
       }else{
          items = 0;
          
          $('#gallery_all_image').append("<div class=\"div_new_row\"></div>");
       }
    }    
    
    /*$('.gallery_item').hover(
         function () {
            $(this).css("border-width","2px");
         },
         function () {
            $(this).css("border-width","1px");
         }
    );*/
    $('.gallery_item').click(function () {
        //clear the background of all divs
        $('.gallery_item').css("background-color", "white");
        $('.gallery_item').css("color", "#ff6600");
        $(this).css("background-color", "#ff6600");
        $(this).css("color", "white");
        $('#btn_all_images_edit').attr("disabled", false);
        $('#btn_all_images_delete').attr("disabled", false);
        }
    );
    $('#btn_all_images_edit').attr("disabled", "disabled");
    $('#btn_all_images_delete').attr("disabled", "disabled");
    debugExit(methodName);
     
     
 
 }
