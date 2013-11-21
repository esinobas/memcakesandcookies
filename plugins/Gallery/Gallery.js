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
       var divHeigth = parseInt(((parseInt(heightGallery) - ( (rows + 1 ) * parseInt(marginVertical))) / rows)) + "px"; 
       this.debug(methodName,"Div width [ " + divWidth + " ]. Div Heigth [ " + divHeigth + "]"); 
       
       this.debug(methodName, "Create the tb-images for each img");
       $("#Gallery").find("img").each(
          function () {
             var tbImg = $('<div class="tb-image"></div>');
             tbImg.css({
                  "width" : divWidth,
                  "height" : divHeigth,
                  "margin-left" : marginHorizontal,
                  "margin-top" : marginVertical
                  });
             tbImg.append($(this));
             $("#Gallery").append(tbImg);
          }       
       );
              
      /* this.debug(methodName,"Get all object images and change per its thumbnail");
       $("#Gallery").find('img').each(
          function () {
             var src = $(this).attr("src");
             var arraySrc = src.split("/");
             var newSrc = "";
             for (var idx = 0; idx < arraySrc.length -1; idx++ ){
                newSrc = newSrc +"/"+ arraySrc[idx];             
             }
             newSrc = newSrc +"/thumbnails/"+arraySrc[arraySrc.length-1];
             Gallery.debug("show::#Gallery::img::each","New image source [ "+newSrc+ " ]");
             var src = $(this).attr("src", newSrc);
          }
       );*/       
              
       this.debugExit(methodName);
    }
 
};