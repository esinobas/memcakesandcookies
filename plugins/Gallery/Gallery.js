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
       paddingHorizontal = null;
       paddingVertical = null;
       
       if (theParameters['padding'] != null){
          paddingHorizontal = theParameters['padding']['horizontal'];
          paddingVertical = theParameters['padding']['vertical'];
       }
       
       if (paddingHorizontal == null){
          paddingHorizontal = "0";
       }else{
          paddingHorizontal = paddingHorizontal+"px"
       }
       if (paddingVertical == null){
          paddingVertical = "0";
       }else{
          paddingVertical = paddingVertical+"px"
       }
       
       this.debug(methodName, "Width [ " + widthGallery +" ]. Height [ " + heightGallery +
              " ]. columns [ " + columns + " ]. rows [ " + rows +" ].");
              
       this.debug(methodName,"Get all object images and change per its thumbnail");
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
       );       
              
       this.debugExit(methodName);
    }
 
};