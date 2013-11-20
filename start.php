<div id="rotateImages">
</div>
         
<script type="text/javascript">
            
<?php

         
 require_once(dirname(__FILE__).'/php/ddbb/DBIterator.php');
 include(dirname(__FILE__)."/php/localDB/TB_SLIDES_HOME.php");
 
 $images = TB_SLIDES_HOME::getAll();
 ?>
 var arrayImages = new Array();
 <?php     
 $idx = 0;
 while($images->next()) {
                  
    $row = $images->getRow();
    /*get the image info and save it in the array*/
    $imageData = getimagesize($row->getPath());
    $imageWidth = $imageData[0];
    $imageHeight = $imageData[1];
?>    
    arrayImages[<?php printf("%d",$idx); ?>] = <?php printf("\"%s;%d;%d\"", $row->getPath(),$imageWidth,$imageHeight);?>;
    var img = new Image();
    img.src =<?php printf("\"%s\"", $row->getPath());?>;
    
<?php    
    $idx ++;               
 }
?>
                
slideImages($('#rotateImages'), 2, 2);
 
</script>