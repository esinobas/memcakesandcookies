<?php

 require_once(dirname(__FILE__).'/php/ddbb/DBIterator.php');
 require_once(dirname(__FILE__)."/php/localDB/TB_IMAGE_COLLECTION.php");
 require_once(dirname(__FILE__)."/php/localConfiguration/configuration.php");
 require_once(dirname(__FILE__)."/php/image/ImageLibrary.php");

 include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
 
 Logger::configure($_SERVER['DOCUMENT_ROOT'].'/log/LogConfig.xml');
 
 $logger = Logger::getLogger("Index");
 $logger->trace("Enter");
 
 $menu = $_GET["pageId"];
 $collection = $_GET["collection"];

 $logger->debug("Get images from : Menu [ $menu ]. Collection [ $collection ]");
 
 $images = TB_IMAGE_COLLECTION::getImagesfromCollectionID($collection);
  
  $logger->debug("The menu [ $menu ] and the collection[ $collection ] has ".
            " [ ".$images->getNumRows() ." ] images");
  
  while ($images->next()){
       
       $fileName = $images->getRow()->getImagePath().'/'.$images->getRow()->getImageName();
       $imageSize = getimagesize($fileName);
       $imageWidth = $imageSize[0];
       $imageHeight = $imageSize[1];
       $logger->trace("Create thumbanils to fileName [ $fileName ] \nWidth [ ".
             $imageWidth . " ]px\nHeight [ $imageHeight ]px");
       
    ?>
    <img src=<?php printf("\"%s\"",createThumbnail($images->getRow()->getImagePath()
                                                    ,$images->getRow()->getImageName()
                                                    ,150  //width
                                                    ,112  //Height
                                                    ,$images->getRow()->getImagePath().thumbnailsPath 
                                                    ,"Thumb_",$logger));?> title=<?php printf("\"%s\"", 
                                                    $images->getRow()->getDescription());?> 
                                                    onclick=<?php 
                                                    printf("\"Lightbox.show({image:'%s',width:%d,height:%d,label:{position:'down',text:'%s'}});\"",
                                                    $fileName, $imageWidth, $imageHeight, $images->getRow()->getDescription());?> >
    <?php
    
    }
     

 $logger->trace("Exit");
?>