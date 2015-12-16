/**
 * Plugin gallery that is used to show thumbnails of images and when
 * a click is done on the thumbnails the image is showed in its original size
 *
 */

 
var Gallery = Gallery || {};

/****** Private functions ******/

/****** Public functions *******/

/**
 * Initialize the Gallery
 */
Gallery.init = function(theHtmlObjectId, theLoadImage){

   JSLogger.getInstance().registerLogger("Gallery", JSLogger.levelsE.TRACE);
   JSLogger.getInstance().traceEnter();
   JSLogger.getInstance().trace("Init gallery for the object [ " + theHtmlObjectId + " ]");
   var numGalleryImages = $('#'+theHtmlObjectId+' img').length;
   var arrayImagesInfo = new Array();
   var arrayImages =  jQuery.makeArray($('#'+theHtmlObjectId+' img'));
   //Save the images info in an array which will be passed like argument to the
   //lightbox. The position 0 is reserved to the selected images idx
   for (var idx = 0; idx<arrayImages.length; idx++){
      
    
      arrayImagesInfo[idx+1] = {};
      
      if (typeof $(arrayImages[idx]).attr('data-image_source') !== 'undefined'){
         arrayImagesInfo[idx+1].src = $(arrayImages[idx]).attr('data-image_source');
      }else{
         arrayImagesInfo[idx+1].src = $(arrayImages[idx]).attr('src');
      }
      if (typeof $(arrayImages[idx]).attr('data-image_desc') !== 'undefined'){
         arrayImagesInfo[idx+1].desc = $(arrayImages[idx]).attr('data-image_desc');
      }else{
         arrayImagesInfo[idx+1].desc = $(arrayImages[idx]).attr('title');
      }
      JSLogger.getInstance().trace("Add image info: src[ " +
            arrayImagesInfo[idx+1].src  + 
            " ] & desc [ " + arrayImagesInfo[idx+1].desc + " ] in array images info");
      
   }
   
   JSLogger.getInstance().trace("Number of images [ " + arrayImagesInfo.length + " ]");
   
   $('#'+theHtmlObjectId+' img').each(function(idx){
         
      $(this).addClass('Gallery-Item');
         
         $(this).click(function(){
            //Save in the array images info the image selected idx +1 
            arrayImagesInfo[0] = idx + 1;
            Lightbox.show(arrayImagesInfo, theLoadImage);
         });
      });
   
   
   JSLogger.getInstance().traceExit();
   
}