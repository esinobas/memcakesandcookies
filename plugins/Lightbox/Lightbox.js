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
    
    enableDebug: true,
    debugSetup: {
                  file: "Lightbox.js"
                                              
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
    closeLightbox: function(){
         var methodName = "closeLightbox";
         this.debugEnter(methodName);
         
         this.debug(methodName,"Remove div lightbox and its contain");
         $('#lightbox').remove();
         this.debug(methodName,"Remove div shadow");
         $('#shadow').remove();
         this.debug(methodName,"Remove image close");
         $('#img_close').remove();
         
         this.debugExit(methodName);
         
    },
    show: function (theParameters){
       var methodName = "show";
       
       this.debugEnter(methodName);
       
       imageM = theParameters['image'];
       imageWidthM = theParameters['width'];
       imageHeightM = theParameters['height'];
       labelM = theParameters['label'];
          
                     
       this.debug(methodName, 'image [ ' + imageM + ' ]. width [ ' +imageWidthM  + 
                                          'px ]. height [ ' + imageHeightM + 'px ]');
                                          
         
       if (labelM != null){
       
          positionTextM = labelM['position'];
          textM = labelM['text'];
          this.debug(methodName, "Label position [ " + positionTextM + " ]");
          this.debug(methodName, "Text[ " + textM + " ]");
       } 
       
       this.debug(methodName, "Create and add the shadow");       
       var shadow = $("<div id=\"shadow\"></div>");
       $('body').append(shadow);
       
       
       
       this.debug(methodName, "Show the shadow");
            
       $('#shadow').show();
       
       var windowScrollTop = $(window).scrollTop();
       var windowHeight = $(window).height();
       this.debug(methodName,"scrollTop [ " + windowScrollTop +" ]. window height [ " + windowHeight + " ]");
       
        if (labelM != null){

         this.debug(methodName, "Create the label in lightbox.");
         var label = $('<div id="div_label">'+textM+'</div>');
       }
   
       
       
       var lightbox = $("<div id=\"lightbox\"</div>");
       
       this.debug(methodName, "Create lightbox");
      
       this.debug(methodName, "Show the lightbox");
       $('body').append(lightbox);

       var topLightbox = $('#lightbox').offset().top;

        
       this.debug(methodName,"lightbox Top [ " + topLightbox +" ]. New top [ "+ ((parseInt(windowHeight)/2)+parseInt(windowScrollTop)) +" ]");
       $('#lightbox').show();
       
                           
       
                           
       topLightbox = $('#lightbox').offset().top;
       this.debug(methodName,"NEW lightbox Top [ " + topLightbox +" ]");
       
       
       if (labelM != null){

         if (positionTextM == "up"){
              this.debug(methodName, "Add in up the label in lightbox."); 
             $('#lightbox').append(label);          
         }       
       }
   
                           
       this.debug(methodName,"Create the image");
       var image = $("<img src=\""+imageM+"\" width=\""+imageWidthM+"\" height=\""+
                imageHeightM+"\" />");
       
       this.debug(methodName,"Add the image to the lightbox");
       
       $('#lightbox').append(image);
       
       if (labelM != null){

         
         if (positionTextM == "down"){
              this.debug(methodName, "Add in down the label in lightbox."); 
             $('#lightbox').append(label);          
         }       
       }
   
       var heightLabel = 0;
       
       if (labelM != null){
          heightLabel = parseInt($('#div_label').css('height'));       
       }
   
   var heightLightbox = parseInt(heightLabel) + parseInt(imageHeightM);
       
       this.debug(methodName, "Height Image [ " +imageHeightM+" ] +  Height Label [ " + heightLabel +" ] =  Height LightBox [ " + heightLightbox + " ]" );
      
       
       $('#lightbox').css({'width':imageWidthM+'px',
                           'height': heightLightbox+'px',
                           'top': ((parseInt(windowHeight)/2)+parseInt(windowScrollTop))+'px',
                           'margin-top':'-'+(parseInt(heightLightbox)/2)+'px', 
                           'margin-left':'-'+(parseInt(imageWidthM)/2)+'px'});
                           
                           
        //img close
       var imgClose = $('<img id="img_close" src="./plugins/Lightbox/Close.png" />');
       $('body').append(imgClose);  
       $('#img_close').css('top',((parseInt(windowHeight)/2)+parseInt(windowScrollTop))-
                                   (parseInt(heightLightbox)/2)-
                                   parseInt($('#img_close').css('width')) +'px' ); 
       $('#img_close').css('left', (parseInt(imageWidthM)/2)+
                                    parseInt($('#lightbox').css('left'))+'px');     
                                    
         $('#img_close').click(function () {Lightbox.closeLightbox()});
       
       this.debugExit(methodName);
    }
};