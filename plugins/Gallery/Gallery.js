/**
 * Plugin gallery that is used to show thumbnails of images and when
 * a click is done on the thumbnails the image is showed in its original size
 *
 */

 
var Gallery = {

    currentGroupM: 1,
    numberOfGroupsM: 1,
    
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

    getHeightFromFileName: function(theFileName){
    
        var methodName = "getHeightFromFileName";
        
        this.debugEnter(methodName); 
        this.debug(methodName, "Paremeters: theFileName [ " +theFileName +" ]");
        var arraySplit = theFileName.split("/");
        var file = arraySplit[arraySplit.length-1];
        this.debug(methodName, "File [ " + file +" ]");
        arraySplit = file.split("[");
        var aux = arraySplit[arraySplit.length-1];
        this.debug(methodName, "Aux 1 [ " + aux +" ]");
        arraySplit = aux.split("]");
        aux = arraySplit[0];
        this.debug(methodName, "Aux 2 [ " + aux +" ]");
        arraySplit = aux.split("x");
        aux = arraySplit[arraySplit.length-1];
        this.debug(methodName, "Heigth [ " + aux +" ]");
        this.debugExit(methodName);
        return aux; 
    
    },
    nextGroup: function(){
       var methodName = "nextGroup";
       this.debugEnter(methodName);
       var currentGroup = "#group-image-"+this.currentGroupM;
       var nextGroup = "#group-image-"+ (this.currentGroupM + 1);
       this.debug(methodName, "The [ " + currentGroup + " ] will be hidden and the [ "
             + nextGroup + " ] will be showed");
       this.currentGroupM ++;
       $(nextGroup).show();
       $(currentGroup).hide();
       
       this.debugExit(methodName);
    },
    previousGroup: function(){
       var methodName = "previousGroup";
       this.debugEnter(methodName);
       var currentGroup = "#group-image-"+this.currentGroupM;
       var previousGroup = "#group-image-"+(this.currentGroupM - 1);
       this.debug(methodName, "The [ " + currentGroup + " ] will be hidden and the [ "
             + previousGroup + " ] will be showed");
       this.currentGroupM --;
       $(previousGroup).show();
       $(currentGroup).hide();
       this.debugExit(methodName);
       
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
       var divHeight = parseInt(((parseInt(heightGallery) - 64 - ( (rows + 1 ) * parseInt(marginVertical))) / rows)) + "px"; 
       this.debug(methodName,"Div width [ " + divWidth + " ]. Div Heigth [ " + divHeight + "]"); 
       
       var groups = 1;
       var imagesPerGroup = columns * rows;
       var imagesInGroup = 0;
       var mustAddPreviousBtn = false;
       this.numberOfGroupsM = Math.floor($("#Gallery").find("img").size()/imagesPerGroup);
       this.numberOfGroupsM = this.numberOfGroupsM + 
             ($("#Gallery").find("img").size() % imagesPerGroup > 0 ? 1 : 0);
       this.debug(methodName, "Number of groups [ " + this.numberOfGroupsM + " ]");
       this.debug(methodName, "Each group has [ " + imagesPerGroup + " ] images");
       this.debug(methodName, "Create the tb-images for each img");
       var divGroup = $('<div class="group-image" id="group-image-'+groups+'"></div>');
       var divNavigation = null;
       $("#Gallery").append(divGroup);
       var strJavaScript = "<div class=\"images-list\" style=\"height:"+
                                (parseInt(heightGallery)-64)+"px;\"></div>";
       var imagesList = $(strJavaScript);
       divGroup.append(imagesList);
       $("#Gallery").find("img").each(
          function () {
             var methodName = '"#Gallery".find("img").each';
             
             if (imagesInGroup === imagesPerGroup){
                Gallery.debug(methodName, "The number of images in the group has been reached");
               
                if (Gallery.currentGroupM !== Gallery.numberOfGroupsM){
                   
                   Gallery.debug(methodName, "The current group is not equal to the number of groups");
                   imagesInGroup = 0;
                   //Añadir el div para navegacion y en el se deben de poner los botones.
                   //El div de navegacion, debe de estar debajo del resto de las fotos
                   divNavigation = $("<div class=\"navigation\"></div>");
                   divGroup.append(divNavigation);
                   
                   if (mustAddPreviousBtn){
                      
                      Gallery.debug(methodName, "The previous button is added");
                      divNavigation.append("<img class=\"btn-previous\" src=\"plugins/Gallery/circle_arrow-back_previous.png\" title=\"Anteriores\" alt=\"Anteriores\">");
                   }
                   divNavigation.append("<img class=\"btn-next\" src=\"plugins/Gallery/circle_arrow-forward_next.png\" title=\"Siguientes\" alt=\"Siguiente\">");
                   groups ++;
                   divGroup = $('<div class="group-image" id="group-image-'+groups+'"></div>');
                   imagesList = $(strJavaScript);
                   divGroup.append(imagesList);
                   Gallery.debug(methodName, "Hide the group-image-"+groups);
                   divGroup.hide();
                   $("#Gallery").append(divGroup);
                   mustAddPreviousBtn = true;
                   
                }
             }
             imagesInGroup ++;
             Gallery.debug(methodName, "Images in the group [ " + imagesInGroup +" ]");
             var tbImg = $('<div class="tb-image"></div>');
             tbImg.css({
                  "width" : divWidth,
                  "height" : divHeight,
                  "margin-left" : marginHorizontal,
                  "margin-top" : marginVertical
                  });
             tbImg.append($(this));
             Gallery.debug(methodName, "Adding image to [ group-image-"+(groups)+" ]");
             imagesList.append(tbImg);
             //$("#Gallery").append(tbImg);
             
             var imageMarginTop = parseInt(divHeight)-parseInt(Gallery.getHeightFromFileName($(this).attr('src')));
             imageMarginTop = parseInt(imageMarginTop/2) + "px";
             Gallery.debug(methodName, ' Image margin-top [ '  + imageMarginTop + ' ]');
             $(this).css("margin-top", imageMarginTop);
          }
       );
       if (mustAddPreviousBtn){
          divNavigation = $("<div class=\"navigation\"></div>");
          divGroup.append(divNavigation);
          Gallery.debug(methodName, "The previous button must be added in the last div group");
          divNavigation.append("<img class=\"btn-previous\" src=\"plugins/Gallery/circle_arrow-back_previous.png\" title=\"Anteriores\" alt=\"Anteriores\">");
       }
       $(".btn-next").click(function(){
             var methodName = ".btn-next.click";
             Gallery.debugEnter(methodName);
             Gallery.nextGroup();
             Gallery.debugExit(methodName);
          }
       );
       $(".btn-previous").click(function(){
          var methodName = ".btn-previous.click";
          Gallery.debugEnter(methodName);
          Gallery.previousGroup();
          Gallery.debugExit(methodName);
       }
    );
       
                         
      
       this.debugExit(methodName);
    }
 
};