/**
 * File with functions that are used for handler the control panel
 */

var fileNameC = "ControlPanelFunctions.js";
var enableDebugM = false;
var selectedImageM = "";
var selectedImageDescM ="";


 
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
   * Function that extracts from the image id, the database image id for it be used
   * in database operations
   *
   * @param theId: The image id
   * @return The database image id. 
   */
  function getDatabaseImageId(theId){
     
     var methodName = "getDatabaseImageId";
     debugEnter(methodName);
     debug(methodName, "The Img Id [ " + theId + " ]");
     var id = theId.substring(theId.indexOf("-")+1, theId.length);
     debug(methodName, "The DDBB Id [ " + id + " ]");
     debugExit(methodName);  
     return id;
  }
  
 /**
 * Function that shows a dialogue box where it is asked whether the user wants to remove a
 * image of the system
 *  
 * @param theId The image object id that is used to search the image to remove
 * @param theOption The image selection
 */
 function removeImage(theId, theOption){

    var methodName = "removeImage";
    debugEnter(methodName);
    debug(methodName, "The img Id [ " + theId + " ]");
    var id = theId.substring(theId.indexOf("-")+1, theId.length);
    debug(methodName, "The DDBB Id [ " + id + " ]");
    debug(methodName, "The Option is [ " + theOption + " ]");
    
    var ajaxObject = new Ajax();
    ajaxObject.setSyn();
    ajaxObject.setPostMethod();
    ajaxObject.setCallback(null);
    ajaxObject.setUrl('./DeleteImage.php');
    var arrayParameters =  {};
    arrayParameters.id = id;
    var parameters = JSON.stringify(arrayParameters);
    debug(methodName, "Parameteres [ " + parameters + " ]");
    ajaxObject.setParameters(parameters);
    ajaxObject.send();
    refresAllImages(theOption);
    debugExit(methodName); 
 }

  
  
 /**
  * Function that sets the functions to the object
  *
  * @paramter theOption The option selected to management 
  */
function setFunctionsToObjects(theOption){
     
     var methodName = "setFunctionsToObjects";
     debugEnter(methodName);
     
     debug(methodName,"The selected option is [ " + theOption + " ]");     
     
     debug(methodName, "Set event onchange to combobox");
     $('#comboCollection').change(function () { 
                                 showSelectedCollection();
                              }
     );
     
     //Add function to button for upload an image
     $('#btn_all_images_add').click(
        function () {
           var path = "";
           
           if (theOption == "Cakes"){
              path = "images/cakes";
           }
           if (theOption == "Cookies"){
              path = "images/cookies";
           }
           if (theOption == "Modelados"){
              path = "images/models";
           }
           UploadImage.show({image_path: path, image_type: theOption});     
        }
     );
     
     //Add function to the button for remove a image
     $('#btn_all_images_delete').click( function () {
         
          if ( confirm("¿Quieres borrar la foto?")){

             removeImage(selectedImageM,theOption); 
          }
            
     
         }      
      );
      //Add function to the button for update the image description
      $('#btn_all_images_edit').click( function (){
           
            UpdateImageDescription.show({imageId: getDatabaseImageId(selectedImageM), description: selectedImageDescM});
      
         }
      );
      
     
     debugExit(methodName);
     
}



/**
 * Function that refreshes the all images of the a container
 */
 function refresAllImages(theType){
    
    var methodName = "refresAllImages";
    debugEnter(methodName);
    
    $('#gallery_all_image').children().each(function () {
       
          $(this).remove();
       }
   );
    
  
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
    
       var id = jsonParsed[idx]['id'];       
       var path = jsonParsed[idx]['path'];
       var desc = jsonParsed[idx]['description'];
       this.debug(methodName, "Image Path [ " + path + " ]. Image Desc [ " + desc+ " ]");
       var newDiv = $("<div class=\"gallery_item\"></div>");
       newDiv.append("<img id=\"gallery_img-" + id + "\" src=\"../"+path+ "\" alt=\""+desc+"\" title=\""+desc+"\"/><br>");
       newDiv.append(desc);
       $('#gallery_all_image').append(newDiv);
       if (items < 3){
          items ++;       
       }else{
          items = 0;
          
          $('#gallery_all_image').append("<div class=\"div_new_row\"></div>");
       }
    }    
    
   
    $('.gallery_item').click(function () {
        //clear the background of all divs
        $('.gallery_item').css("background-color", "white");
        $('.gallery_item').css("color", "#ff6600");
        $(this).css("background-color", "#ff6600");
        $(this).css("color", "white");
        $('#btn_all_images_edit').attr("disabled", false);
        $('#btn_all_images_delete').attr("disabled", false);
        selectedImageM = $(this).find('img').attr("id");
        selectedImageDescM =  $(this).find('img').attr("title");
        
        }
    );
    $('#btn_all_images_edit').attr("disabled", "disabled");
    $('#btn_all_images_delete').attr("disabled", "disabled");
    debugExit(methodName);
     
     
 
 }
