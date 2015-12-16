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
   var arrayImagesM = null;
   var currentIndexM = 0;
   

/***** Private functions ****/

   function closeLightbox(){
      JSLogger.getInstance().traceEnter();
      $('#Lightbox').remove();
      $('#Lightbox-shadow').remove();
      $('body').removeClass('No-scrollbar-Lightbox');
      JSLogger.getInstance().traceExit();
   }
   
   function loadPreviousImage(){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Current index [ " + currentIndexM + " ]");
      $('.Navigate-Buttons').hide();
      loadImageByIndex(--currentIndexM);
      
      JSLogger.getInstance().traceExit();
   }
   function loadNextImage(){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Current index [ " + currentIndexM + " ]");
      $('.Navigate-Buttons').hide();
      loadImageByIndex(++currentIndexM);
      JSLogger.getInstance().traceExit();
   }
   function addPreviousImage(){
      JSLogger.getInstance().traceEnter();
      if (currentIndexM > 1 ){
         
         var button = $('#prev-image');
         
         if (button.length == 0){
            button = $('<img src="plugins/Lightbox/Arrow-left.png" id="prev-image" class="Navigate-Buttons">');
            button.css('left', '0px');
            lightboxM.append(button);
            button.click(loadPreviousImage);
         }else{
            button.show();
         }
         var top = ($('#Lightbox-Image').height()/2) - (button.height()/2);
         button.css('top', top+"px");
         
         
      }
      JSLogger.getInstance().traceExit();
   }
   
   function addNextImage(){
      JSLogger.getInstance().traceEnter();
      
      if ( currentIndexM < ( arrayImagesM.length -1 )){
         JSLogger.getInstance().trace("Add next image link or button");
         var button = $('#next-image');
         
         if (button.length == 0){
            button = $('<img src="plugins/Lightbox/Arrow-right.png" id="next-image" class="Navigate-Buttons">');
            button.css('right', '0px');
            button.click(loadNextImage);
            lightboxM.append(button);
         }else{
            button.show();
         }
         var top = ($('#Lightbox-Image').height()/2) - (button.height()/2);
         button.css('top', top+"px");
         
         
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
      var imageLoad = $('#Lightbox-Image-Load');
      if (imageLoad == null){
         lightboxM.append('<img src= "' + imageLoadSrcM +'" title="Loading" id="Lightbox-Image-Load">');
      }else{
         imageLoad.show()
      }
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
   
   
   function showLightbox(theImageLoad){
      JSLogger.getInstance().traceEnter();
      if (typeof theImageLoad !== 'undefined'){
         imageLoadSrcM = theImageLoad;
      }
      $('body').addClass('No-scrollbar-Lightbox');
      
      $('body').append('<div id="Lightbox-shadow"></div>');
      
      lightboxM = $('<div id="Lightbox"></div>');
      $('body').append(lightboxM);
      
      JSLogger.getInstance().trace("The image load [ " + imageLoadSrcM +" ]");
      
      
      
      
      lightboxM.append('<img src="plugins/Lightbox/Close.png" id="img-close">')
      
      $('#img-close').click(closeLightbox);
      
      $(document).keypress(function(e) {        
         
         if (e.keyCode == 27) {
              closeLightbox();
         }
         if (e.keyCode == 39 && $('#next-image:visible').length > 0){
            loadNextImage();
         }
         if (e.keyCode == 37 && $('#prev-image:visible').length > 0){
            loadPreviousImage();
         }
      });
      
      JSLogger.getInstance().traceExit();
      
   }
   
   function loadImage(theImageObject){
      
      JSLogger.getInstance().traceEnter();
      
      addImageLoad();
      
      JSLogger.getInstance().trace("The image src [ " + theImageObject.src + 
                " ] & image description [ " + theImageObject.desc +" ]");
      
      var image = $('<img src="' + theImageObject.src +'" id="Lightbox-Image">');
      image.hide();
      lightboxM.append(image);
      var imageDesc = $('<div id="Lightbox-Desc">'+theImageObject.desc+'</div>');
      imageDesc.hide();
      lightboxM.append(imageDesc);
      image.on('load',imageLoaded);
      

      JSLogger.getInstance().traceExit();
   }
   
   function loadImageByIndex(theIndex){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Show images with index [ " + theIndex + " ]");
      //If a previous image is begin showed, hides and removes it.
      $('#Lightbox-Image').hide();
      $('#Lightbox-Image').remove();
      $('#Lightbox-Desc').hide();
      $('#Lightbox-Desc').remove();
      currentIndexM = theIndex;
      loadImage(arrayImagesM[theIndex]);
      
      JSLogger.getInstance().traceExit();
      
   }
/**** Public Functions ****/

Lightbox.show = function(theImageObject, theImageLoad){
   
   JSLogger.getInstance().registerLogger("Lightbox", JSLogger.levelsE.TRACE);
   JSLogger.getInstance().traceEnter();
   
   showLightbox(theImageLoad);
   
   if (Array.isArray(theImageObject)){
      arrayImagesM = theImageObject;
      loadImageByIndex(arrayImagesM[0]);
   }else
   {
      loadImage(theImageObject);
   }
   
   
   
   JSLogger.getInstance().traceExit();
} 

