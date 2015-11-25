/**
 * Plugin that slides a images set
 * 
 * Parameters: the div with the images set
 *             the time out time
 *             the transaction time
 *             the transaction type (only fade by now)
 *             
 * JQuery is neccesary
 */

var ImagesSlide = ImagesSlide || {};


/** Private functions **/
var fade = function(theHtmlId, theTimeOut, theTransactionTime){
   
   JSLogger.getInstance().traceEnter();
   
   var numImages = $('#' +theHtmlId +' .Images-Slide-Item').length;
   JSLogger.getInstance().trace("The slider has [ " + numImages +" ] images");
   
   var visibleDiv = $('#'+theHtmlId+' .Images-Slide-Item:visible');
   var divIdx = $('#'+theHtmlId+' .Images-Slide-Item').index(visibleDiv);
   JSLogger.getInstance().trace("The visible div Idx is [ " + divIdx +" ]");
     
   (++divIdx == numImages ? divIdx = 0: null);
   
   JSLogger.getInstance().trace("The Next div Idx is [ " + divIdx +" ]");
   
   visibleDiv.css('z-index', 1);
   var nextDiv = $('#'+theHtmlId+' .Images-Slide-Item').eq(divIdx);
   nextDiv.css('z-index', 0);
   nextDiv.show();
   
   visibleDiv.fadeOut(theTransactionTime, function(){
      setTimeout("fade(\""+theHtmlId+"\","+theTimeOut+","+theTransactionTime+")", theTimeOut);
   });
   
   JSLogger.getInstance().traceExit();
}


/** Public functions **/
ImagesSlide.init = function (theHtmlId, theTimeOut, theTransactionTime, theType){
   JSLogger.getInstance().registerLogger("ImagesSlide", JSLogger.levelsE.WARN);
   JSLogger.getInstance().traceEnter();
   
   var type = typeof theType !== 'undefined' ? theType : "fade";
   
   JSLogger.getInstance().trace("Init ImagesSlide plugin with the following parameters.\n" +
         "Html Id [ " + theHtmlId + " ]. Time out [ " + theTimeOut + 
         " ] seconds. Transaction time [ " + theTransactionTime + 
         " ] seconds. Type [ " + type + " ]");
   
   theTimeOut = theTimeOut * 1000;
   theTransactionTime = theTransactionTime * 1000;
   
   $('#' + theHtmlId + ' .Images-Slide-Item:hidden:first').show();
   
   if (type.toUpperCase() == "FADE"){
      fade(theHtmlId, theTimeOut, theTransactionTime);
   }
   JSLogger.getInstance().traceExit();
   
}

