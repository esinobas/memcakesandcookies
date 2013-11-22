/**
 * Plugin gallery that is used to show thumbnails of images and when
 * a click is done on the thumbnails the image is showed in its original size
 *
 */

 
var Gallery = {

    enableDebug: true,
    debugSetup: {
                  file: "Gallery.js"
                                              
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

    getHeightFromFileName: function(theFileName){
    
        var methodName = "getHeightFromFileName";
        
        this.debugEnter(methodName); 
        this.debug(methodName, "Paremeters: theFileName [ " +theFileName +" ]");
        var arraySplit = theFileName.split("/");
        var file = arraySplit[arraySplit.length-1];
        this.debug(methodName, "File [ " + file +" ]");
        arraySplit = file.split("[");
        var aux = arraySplit[arraySplit.length-1];
        this.debug(methodName, "Aux 1 [ " + aux +" ]");
        arraySplit = aux.split("]");
        aux = arraySplit[0];
        this.debug(methodName, "Aux 2 [ " + aux +" ]");
        arraySplit = aux.split("x");
        aux = arraySplit[arraySplit.length-1];
        this.debug(methodName, "Heigth [ " + aux +" ]");
        this.debugExit(methodName);
        return aux; 
    
    },
  
    /**
     * Method that shows the gallery.
     * parameters The parameters used for configure the gallery
     * @param size: width & height
     * @param colums: The number of columns
     * @param rows: The number of rows
     * @param paddin: The padding horizontal & vertical
     */   
    show: function (theParameters){
       
       var methodName = "show";
        
       this.debugEnter(methodName);
       
       widthGallery = theParameters['size']['width']+"px";       
       heightGallery = theParameters['size']['height']+"px";
       columns = theParameters['columns'];
       rows = theParameters['rows'];
       marginHorizontal = null;
       marginVertical = null;
       
       if (theParameters['margin'] != null){
          marginHorizontal = theParameters['margin']['horizontal'];
          marginVertical = theParameters['margin']['vertical'];
       }
       
       if (marginHorizontal == null){
          marginHorizontal = "5px";
          this.debug(methodName, "Margin Horizontal is not present in the parameters");
       }else{
          marginHorizontal = marginHorizontal+"px"
       }
       if (marginVertical == null){
          marginVertical = "5px";
          this.debug(methodName, "Margin Vertical is not present in the parameters");
       }else{
          marginVertical = marginVertical+"px"
       }
       
       this.debug(methodName, "Width [ " + widthGallery +" ]. Height [ " + heightGallery +
              " ]. columns [ " + columns + " ]. rows [ " + rows +" ]. Margin Horizontal [ " +
              marginHorizontal + " ]. Margin Vertical [ " + marginVertical +" ]");
              
       $("#Gallery").css({
          "width" : widthGallery,
          "height" : heightGallery
       });
              
       this.debug(methodName, "Calculate width and height of the div where the images are showed");
       
       var divWidth = parseInt(((parseInt(widthGallery) - ( (columns+1 ) * parseInt(marginHorizontal))) / columns)) + "px";
       var divHeight = parseInt(((parseInt(heightGallery) - ( (rows + 1 ) * parseInt(marginVertical))) / rows)) + "px"; 
       this.debug(methodName,"Div width [ " + divWidth + " ]. Div Heigth [ " + divHeight + "]"); 
       
       this.debug(methodName, "Create the tb-images for each img");
       $("#Gallery").find("img").each(
          function () {
             var methodName = '"#Gallery").find("img").each';
             var tbImg = $('<div class="tb-image"></div>');
             tbImg.css({
                  "width" : divWidth,
                  "height" : divHeight,
                  "margin-left" : marginHorizontal,
                  "margin-top" : marginVertical
                  });
             tbImg.append($(this));
             $("#Gallery").append(tbImg);
             
             var imageMarginTop = parseInt(divHeight)-parseInt(Gallery.getHeightFromFileName($(this).attr('src')));
             imageMarginTop = parseInt(imageMarginTop/2) + "px";
             Gallery.debug(methodName, ' Image margin-top [ '  + imageMarginTop + ' ]');
             $(this).css("margin-top", imageMarginTop);
          }       
       );
              
      
       this.debugExit(methodName);
    }
 
};