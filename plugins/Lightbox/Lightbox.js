/**
 * Plugin lightbox that is used to show images within a container
 * with animation.
 * 
 * The image will have a max size of 1024x600
 *
 */
 
 

var Lightbox = Lightbox || {};

/***** Private properties ***/

   var lightboxM = null;
   var imageLoadSrcM = "./DefaultImageLoad.gif";
   var prevImageM = null;
   var nextImageM = null;
   

/***** Private functions ****/

   function closeLightbox(){
      JSLogger.getInstance().traceEnter();
      $('#Lightbox').remove();
      $('#Lightbox-shadow').remove();
      $('body').removeClass('No-scrollbar-Lightbox');
      JSLogger.getInstance().traceExit();
   }
   
   function addPreviousImage(){
      JSLogger.getInstance().traceEnter();
      if (prevImageM != null){
         JSLogger.getInstance().trace("Add previous image link or button");
         var button = $('<img src="plugins/Lightbox/Arrow-left.png" id="prev-image" class="Navigate-Buttons">');
         button.css('left', '0px');
         var top = ($('#Lightbox-Image').height()/2) - (button.height()/2);
         JSLogger.getInstance().trace("Top [ " + top + "px ]");
         button.css('top', top+"px");
         lightboxM.append(button);
      }
      JSLogger.getInstance().traceExit();
   }
   
   function addNextImage(){
      JSLogger.getInstance().traceEnter();
      if (nextImageM != null){
         JSLogger.getInstance().trace("Add next image link or button");
         var button = $('<img src="plugins/Lightbox/Arrow-right.png" id="prev-image" class="Navigate-Buttons">');
         button.css('right', '0px');
         var top = ($('#Lightbox-Image').height()/2) - (button.height()/2);
         button.css('top', top+"px");
         lightboxM.append(button);
      }
      JSLogger.getInstance().traceExit();
   }
   
   function resizeLightbox(theHtmlImg){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("HTML Id [ " + theHtmlImg.attr('id') + " ]");

      var height = parseInt(theHtmlImg.css('height'));
      var width = parseInt(theHtmlImg.css('width'));
      JSLogger.getInstance().trace("X,Y [ " + lightboxM.css('left') + ","
            +lightboxM.css('top') + " ]");
      JSLogger.getInstance().trace("Object size [ " + width + "x" +
               height + " ]");
      
      var maxHeight = lightboxM.css('max-height');
      var maxWidth = lightboxM.css('max-width');
      var verticalPadding = parseInt(lightboxM.css('padding-top')) + parseInt(lightboxM.css('padding-bottom'));
      var horizontalPadding = parseInt(lightboxM.css('padding-left')) + parseInt(lightboxM.css('padding-right'));
      var descVerticalPadding = parseInt($('#Lightbox-Desc').css('padding-top')) + parseInt($('#Lightbox-Desc').css('padding-bottom'));
      
      JSLogger.getInstance().trace("Max width [ " + maxWidth + " ], max height [ " +
                                 maxHeight + " ]");
      
      JSLogger.getInstance().trace("Verical padding [ " + verticalPadding + " ],Horizontal padding [ " +
            horizontalPadding + " ]");
      
      var factorX = 1;
      var factorY = 1;
      
      if (width > (parseInt(maxWidth) )){
         factorX = (parseInt(maxWidth)) /width;
      }
      JSLogger.getInstance().trace("Description Verical padding [ " + descVerticalPadding + " ]");
      
      if (height > (parseInt(maxHeight) - ($('#Lightbox-Desc').height()+ verticalPadding))){
         factorY = (parseInt(maxHeight) - ($('#Lightbox-Desc').height()+ verticalPadding))/height;
      }
      JSLogger.getInstance().trace("Factor X [ " + factorX+ " ], Factor Y [ " +
            factorY + " ]");
      
      width = width * factorX * factorY;
      lightboxM.width(width);
      height = height * factorX * factorY;        
      lightboxM.height(height + $('#Lightbox-Desc').height() + verticalPadding);
      
      JSLogger.getInstance().trace("Lightbox desc [ " + $('#Lightbox-Desc').height() + " ]");
      
      theHtmlImg.width(width);
      theHtmlImg.height(height);
      
      JSLogger.getInstance().trace("new width [ " + lightboxM.width() + " ], new height [ " +
            lightboxM.height() + " ]");
      
      lightboxM.css('margin-top', "-"+(lightboxM.height()/2)+"px");
      lightboxM.css('margin-left', "-"+(lightboxM.width()/2)+"px");
      
      var windowScrollTop = $(window).scrollTop();
      var windowHeight = $(window).height();
      JSLogger.getInstance().trace("scrollTop [ " + windowScrollTop +" ]. window height [ " + windowHeight + " ]");
      
      lightboxM.css('top',((parseInt(windowHeight)/2)+parseInt(windowScrollTop))+'px');
      
      JSLogger.getInstance().traceExit();
      
   }
   
   function addImageLoad(){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Append image [" + imageLoadSrcM +" ]");
      lightboxM.append('<img src= "' + imageLoadSrcM +'" title="Loading" id="Lightbox-Image-Load">');
      resizeLightbox($('#Lightbox-Image-Load'));
      JSLogger.getInstance().traceExit();
   }
   
   function imageLoaded(){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("The image was loaded");
      $('#Lightbox-Image-Load').addClass('Lightbox-Hidden');
      $('#Lightbox-Image').show();
      $('#Lightbox-Desc').show();
      resizeLightbox($('#Lightbox-Image'));
      addPreviousImage();
      addNextImage();
      JSLogger.getInstance().traceExit();
   }
   
   
   
/**** Public Functions ****/

Lightbox.show = function(theImageObject, theImageLoad, 
                                 thePreviousImage, theNextImage){
   
   JSLogger.getInstance().registerLogger("Lightbox", JSLogger.levelsE.TRACE);
   JSLogger.getInstance().traceEnter();
   $('body').addClass('No-scrollbar-Lightbox');
   
   $('body').append('<div id="Lightbox-shadow"></div>');
   
   lightboxM = $('<div id="Lightbox"></div>');
   $('body').append(lightboxM);
   
   
   if (typeof theImageLoad !== 'undefined'){
      imageLoadSrcM = theImageLoad;
   }
   if (typeof thePreviousImage !== 'undefined'){
      prevImageM = thePreviousImage;
   }
   if (typeof theNextImage !== 'undefined'){
      nextImageM = theNextImage;
   }
   
   JSLogger.getInstance().trace("The image load [ " + imageLoadSrcM +" ]");
   JSLogger.getInstance().trace("The image src [ " + theImageObject.src +" ] and desc [ " +
                             theImageObject.desc +" ]");
   
   addImageLoad();
   
   var image = $('<img src="' + theImageObject.src +'" id="Lightbox-Image">');
   image.hide();
   lightboxM.append(image);
   var imageDesc = $('<div id="Lightbox-Desc">'+theImageObject.desc+'</div>');
   imageDesc.hide();
   lightboxM.append(imageDesc);
   image.on('load',imageLoaded);
   
   lightboxM.append('<img src="plugins/Lightbox/Close.png" id="img-close">')
   
   $('#img-close').click(closeLightbox);
   
   $(document).keypress(function(e) {        
      
      if (e.keyCode == 27) {
           closeLightbox();
        }
     });
   
   JSLogger.getInstance().traceExit();
} 