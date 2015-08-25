/**
 * Plugin lightbox that is used to show images within a container
 * with animation
 *
 */
 
 
var Lightbox = {
 
    shadowColorM: "black",
    opacityM: 0.75,
    imageM: "",
    imageWidthM: "0px",
    imageHeightM: "0px",
    paddingTopM: "10px",    
    paddingLeftM: "10px",
    paddingBottomM: "10px",
    paddingRigthM: "10px",
    textM:"",
    positionTextM: "down", // allowed values: up/down
    
    maxWidthM: "800px",
    maxHeightM: "600px",
    
       
    closeLightbox: function(){
         
         
        //JSLogger.getInstance().traceEnter();
         //this.debug(methodName,"Remove div lightbox and its contain");
         $('#lightbox').remove();
         //this.debug(methodName,"Remove div shadow");
         $('#shadow').remove();
         //this.debug(methodName,"Remove image close");
         $('#img_close').remove();
         
         //JSLogger.getInstance().traceExit();
         
    },
    show: function (theParameters){
       JSLogger.getInstance().registerLogger("Lightbox", JSLogger.levelsE.TRACE);
       
      
       JSLogger.getInstance().traceEnter();
       
       
       imageM = theParameters['image'];
       imageWidthM = theParameters['width'];
       imageHeightM = theParameters['height'];
       labelM = theParameters['label'];
          
                     
       JSLogger.getInstance().trace('image [ ' + imageM + ' ]. width [ ' +imageWidthM  + 
                                          'px ]. height [ ' + imageHeightM + 'px ]');

       var heightLabel = 0;
       
       if (labelM != null){
          heightLabel = parseInt($('<div id="div_label"/>').css('height')); 
          $('#div_label').remove();
       }
       var closeImgHeight = 0;
       closeImgHeight = parseInt($('<img id="img_close">').css('height'));
       $('#img_close').remove();
       
       JSLogger.getInstance().trace("Label Height is [ " + heightLabel +" ] px. Close Height [ "+
                                  closeImgHeight + " ] px");
       
       
       imageHeightM = parseInt(imageHeightM) - heightLabel - closeImgHeight;
       JSLogger.getInstance().trace("New imageHeight [ " + imageHeightM +" ] px")
       
       var windowWidth = $(window).width();
       var pageWidth = $(document).width();
       var windowHeight = $(window).height();
       JSLogger.getInstance().trace('W: ' + windowWidth + 'H: '+ windowHeight);
       
       var widthRatio = 1;
       var heightRatio = 1;
       
       if (parseInt(windowWidth) < parseInt(imageWidthM)){
          
          widthRatio = parseInt(windowWidth)/parseInt(imageWidthM);    
       }  
       
       if (parseInt(windowHeight) < parseInt(imageHeightM)){
          heightRatio = parseInt(windowHeight- heightLabel - closeImgHeight)/parseInt(imageHeightM);    
       }       
       
       
       JSLogger.getInstance().trace("Width ratio [ " + widthRatio + " ]. Height ratio [ " + heightRatio + " ]");
       
       imageWidthM = imageWidthM * widthRatio * heightRatio;
       imageHeightM = imageHeightM * widthRatio * heightRatio;
   
       JSLogger.getInstance().trace('image [ ' + imageM + ' ]. New width [ ' +imageWidthM  + 
                                          'px ]. New height [ ' + imageHeightM + 'px ]');
       
       if (labelM != null){
       
          positionTextM = labelM['position'];
          textM = labelM['text'];
          JSLogger.getInstance().trace("Label position [ " + positionTextM + " ]");
          JSLogger.getInstance().trace("Text[ " + textM + " ]");
       } 
       
       JSLogger.getInstance().trace("Create and add the shadow");       
       var shadow = $("<div id=\"shadow\"></div>");
       $('body').append(shadow);
       
       
       
       JSLogger.getInstance().trace("Show the shadow");
            
       $('#shadow').show();
       
       var windowScrollTop = $(window).scrollTop();
       var windowHeight = $(window).height();
       JSLogger.getInstance().trace("scrollTop [ " + windowScrollTop +" ]. window height [ " + windowHeight + " ]");
       
        if (labelM != null){

           JSLogger.getInstance().trace("Create the label in lightbox.");
           var label = $('<div id="div_label">'+textM+'</div>');
       }
   
       
       
       var lightbox = $("<div id=\"lightbox\"></div>");
       
       JSLogger.getInstance().trace("Create lightbox");
      
       JSLogger.getInstance().trace("Show the lightbox");
       $('body').append(lightbox);

       var topLightbox = $('#lightbox').offset().top;

        
       JSLogger.getInstance().trace("lightbox Top [ " + topLightbox +" ]. New top [ "+ ((parseInt(windowHeight)/2)+parseInt(windowScrollTop)) +" ]");
       $('#lightbox').show();
       
                           
       
                           
       topLightbox = $('#lightbox').offset().top;
       JSLogger.getInstance().trace("NEW lightbox Top [ " + topLightbox +" ]");
       
              
       if (labelM != null){

         if (positionTextM == "up"){
            JSLogger.getInstance().trace("Add in up the label in lightbox."); 
             $('#lightbox').append(label);          
         }       
       }
   
                           
       JSLogger.getInstance().trace("Create the image");
       var image = $("<img src=\""+imageM+"\" width=\""+imageWidthM+"\" height=\""+
                imageHeightM +"\" />");
       
       JSLogger.getInstance().trace("Add the image to the lightbox");
       
       $('#lightbox').append(image);
       
       if (labelM != null){

         
         if (positionTextM == "down"){
            JSLogger.getInstance().trace("Add in down the label in lightbox."); 
             $('#lightbox').append(label);          
         }       
       }
   
       
   
   var heightLightbox = parseInt(imageHeightM + heightLabel);
       
   JSLogger.getInstance().trace("Height Image [ " +imageHeightM+" ] -  Height Label [ " + heightLabel +" ] =  Height LightBox [ " + heightLightbox + " ]" );
      
       
       $('#lightbox').css({'width':imageWidthM+'px',
                           'height': heightLightbox+'px',
                           'top': ((parseInt(windowHeight)/2)+parseInt(windowScrollTop))+'px',
                           'margin-top':'-'+(parseInt(heightLightbox)/2)+'px', 
                           'margin-left':'-'+(parseInt(imageWidthM)/2)+'px'});
                           
                           
        //img close
       var imgClose = $('<img id="img_close" src="./plugins/Lightbox/Close.png" />');
       $('body').append(imgClose);  
       /*$('#img_close').css('top',((parseInt(windowHeight)/2)+parseInt(windowScrollTop))-
                                   (parseInt(heightLightbox)/2)/*-
                                   parseInt($('#img_close').css('height'))+'px' ); 
        */
       /*$('#img_close').css('left', (parseInt(imageWidthM)/2)+
                                    parseInt($('#lightbox').css('left'))+'px');     
         */
         $('#img_close').css('top', ((parseInt(windowHeight)/2)+parseInt(windowScrollTop))+'px');
         $('#img_close').css('margin-top', '-'+(parseInt(heightLightbox)/2) -
                         (parseInt($('#img_close').css('height'))/2) +'px');
         $('#img_close').css('margin-left', parseInt($('#lightbox').css('left'))
                          +(parseInt(imageWidthM))/2+'px');
         $('#img_close').click(function () {Lightbox.closeLightbox()});
       
         
         $(document).keydown(function(e) {        
            if (e.keyCode == 27) {
               Lightbox.closeLightbox();
            }
         });
         JSLogger.getInstance().traceExit();
       
    }
};