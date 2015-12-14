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
Gallery.init = function(theHtmlObjectId){

   JSLogger.getInstance().registerLogger("Gallery", JSLogger.levelsE.TRACE);
   JSLogger.getInstance().traceEnter();
   JSLogger.getInstance().trace("Init gallery for the object [ " + theHtmlObjectId + " ]");
   var numGalleryImages = $('#'+theHtmlObjectId+' img').length;
   
   JSLogger.getInstance().trace("Number of images [ " + numGalleryImages + " ]");
   $('#'+theHtmlObjectId+' img').each(function(idx){
         
         //Check if the image info is in the attributes html data-*
         var imageSrc = $(this).data('image_source');
         var imageDesc = $(this).data('image_desc');
      
         if (typeof imageSrc === 'undefined'){
            JSLogger.getInstance().trace("The image source is not in attr data-*, it will be taken from src");
            imageSrc = $(this).attr('src');
         }
         if (typeof imageDesc === 'undefined'){
            JSLogger.getInstance().trace("The image description is not in attr data-*, it will be taken from title");
            imageDesc = $(this).attr('title');
         }
         JSLogger.getInstance().trace("Image src [ "+ imageSrc + " ] and image desc [ " +
              imageDesc + " ]");
     
         var objImage = {};
         objImage.src = imageSrc;
         objImage.desc = imageDesc;
     
         var prevImage = (idx > 0);
         var nextImage = (idx < numGalleryImages -1 );
     
         $(this).addClass('Gallery-Item');
         $(this).click(function(){alert(idx)});
      });
   
   
   JSLogger.getInstance().traceExit();
   
}