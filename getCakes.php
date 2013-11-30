<?php

 require_once(dirname(__FILE__).'/php/ddbb/DBIterator.php');
 require_once(dirname(__FILE__)."/php/localDB/TB_CAKES.php");
 require_once(dirname(__FILE__)."/php/localConfiguration/configuration.php");
 require_once(dirname(__FILE__)."/php/image/ImageLibrary.php");
 
 if ($collection == 0){

    //get all cakes
    $cakes = TB_CAKES::getAll();
    
    while ($cakes->next()){
       
       $fileName = $cakes->getRow()->getPath().'/'.$cakes->getRow()->getNameFile();
       $imageSize = getimagesize($fileName);
       $imageWidth = $imageSize[0];
       $imageHeight = $imageSize[1];
    ?>
       <img src=<?php printf("\"%s\"",createThumbnail($cakes->getRow()->getPath()
                                                    ,$cakes->getRow()->getNameFile()
                                                    ,150  //width
                                                    ,112  //Height
                                                    ,$cakes->getRow()->getPath().thumbnailsPath 
                                                    ,"Thumb_"));?> title=<?php printf("\"%s\"", 
                                                    $cakes->getRow()->getDescription());?> 
                                                    onclick=<?php 
                                                    printf("\"Lightbox.show({image:'%s',width:%d,height:%d,label:{position:'down',text:'%s'}});\"",
                                                    $fileName, $imageWidth, $imageHeight, $cakes->getRow()->getDescription());?> >
                                                    
                                                               
    <?php
    
    }
     
 }
?>