<div id="rotateImages">
</div>
         
<script type="text/javascript">
            
   <?php
      $loggerStart =  LoggerMgr::Instance()->getLogger("start.php");
      $loggerStart->trace("start.php. Enter");
 
      require_once 'database/TB_SlideImagesHome.php';
   
      $loggerStart->trace("Get the rotate images");
      $tableHomeImages = new TB_SlideImagesHome();
      $tableHomeImages->open();
         
   ?>
   var arrayImages = new Array();
   <?php     
      $idx = 0;
      while($tableHomeImages->next()) {
                  
      /*get the image info and save it in the array*/
      $imageData = getimagesize($tableHomeImages->getPath());
      $imageWidth = $imageData[0];
      $imageHeight = $imageData[1];
   ?>    
   arrayImages[<?php printf("%d",$idx); ?>] = <?php printf("\"%s;%d;%d\"", 
         $tableHomeImages->getPath(),$imageWidth,$imageHeight);?>;
   var img = new Image();
   img.src =<?php printf("\"%s\"", $tableHomeImages->getPath());?>;
    
   <?php    
      $idx ++;               
      }
      $loggerMenu->trace("start.php. Exit");
   ?>
                
slideImages($('#rotateImages'), 2, 2);
 
</script>