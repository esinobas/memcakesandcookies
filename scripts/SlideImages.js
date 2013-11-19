
const idDivImageC = 'div_image_';
const idImageC = 'div_image_';
const numberOfImagesC = 2;

var showedImgM = 0;
 
   function slideImage(theIdx, theElement, theSleepTime, theFadeTime){
      
      try{      
         var sleepTime = 1000 * theSleepTime;
         var fadeTime = 1000 * theFadeTime;
        
         /* It is the first slide, create the div and img */
         if (showedImgM == 0 ){
            
              
            
            for (var i=1 ; i <= numberOfImagesC; i++){
               
               var element = '#'+ idDivImageC + i;
               
               /*The div image doesn't in the document. Create it.*/
               var divImage = $('<div id="'+idDivImageC + i +'"></div>');
               
               /*Add the css style*/
               divImage.css('position', 'absolute');
               divImage.css('top','0');
               divImage.css('left','0');
               divImage.css('width', theElement.css('width'));
               divImage.css('height', theElement.css('height'));
               divImage.css('background-color','inherit');
               
               /* Properties to centre vertically the image */
               divImage.css('margin','auto');
	              divImage.css('text-align', 'center');
	              divImage.css('display', 'table');
               divImage.css('line-height',theElement.css('height'))          
              
               
               /* Order the images divs. The showed div is the first. */           
               if (  i == 1 ){
                  divImage.css('z-index', 1);             
               }else{
                   divImage.css('z-index', 0);                      
               }               
               /* Create the img object */               
               var image = $('<img id="' + idImageC + i + '" src="" />');
               
               /* To centre vertically the image*/
               image.css('vertical-align', 'middle');
               
               divImage.append(image);
               theElement.append(divImage);
               
            }                      
         }
         
         /* Get the images div */
       
         var idShowedDiv = '#'+idDivImageC + (((showedImgM == 0) || (showedImgM == 1)) ? 1 : 2);
         var idHidedDiv = '#'+idDivImageC + (((showedImgM == 0) || (showedImgM == 1)) ? 2 : 1);
       
           
       
         var showedDiv = $(idShowedDiv);
         var hidedDiv = $(idHidedDiv);
       
        
         
         /* Calculate the ratios for resize the image*/
         var ratioHeight = 1;
         var ratioWidth = 1;
         
         /* get the image info (file;width;height) */
         var dataImage =  arrayImages[theIdx];   
         var splited = dataImage.split(";");
         var pathFileImage = splited[0];
         var widthImage = parseInt(splited[1]);
         var heightImage = parseInt(splited[2]);
          
         if (widthImage > parseInt(theElement.css("width"))){
            ratioWidth = parseInt(theElement.css("width")) / widthImage ;
         }

         if ((ratioWidth * heightImage) > parseInt(theElement.css("height"))){
            ratioHeight =  parseInt(theElement.css("height")) / (ratioWidth * heightImage);
         }
         
         /* Resize the image that will be showed */
         widthImage = parseInt(widthImage * ratioWidth * ratioHeight);
         heightImage =  parseInt(heightImage * ratioWidth * ratioHeight);
         
         hidedDiv.find("img").attr("width",widthImage);
         hidedDiv.find("img").attr("height",heightImage);
         hidedDiv.find("img").attr("src",pathFileImage);
        
                
         
         /* Show the div with the image */
         hidedDiv.show();
         
         if (theIdx < (arrayImages.length -1) ){
            theIdx ++;
         }else{
            theIdx = 0;
         }
         
         var fadeOut = (showedImgM != 0 ? true : false);
         
         showedImgM = (((showedImgM == 0) || (showedImgM == 1)) ? 2 : 1);
         
        /* Hide the previous div img object */
        if (fadeOut){
           
           showedDiv.fadeOut(fadeTime, function(){
                setTimeout("slideImage(" + theIdx + ",$('"+theElement.selector+"'),"+theSleepTime+ ","+theFadeTime+")",sleepTime);
                $(showedDiv).css("z-index", 0);
                $(hidedDiv).css("z-index", 1);
           });
        }else{
           
           setTimeout("slideImage(" + theIdx + ",$('"+theElement.selector+"'),"+theSleepTime+ ","+theFadeTime+")",sleepTime);
           $(showedDiv).css("z-index", 0);
           $(hidedDiv).css("z-index", 1);
        }
       
       
      }catch(error){
         alert('slideImage::slideImage [ ' + error + ' ]');      
      }
       
   }
   
function slideImages(theElement, theSleepTime, theFadeTime){
   
        var d = new Date();
        var timeStamp = d.getTime();         
        var initImage = timeStamp % arrayImages.length;
        slideImage(initImage, theElement, theSleepTime, theFadeTime);
}
   
   