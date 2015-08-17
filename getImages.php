<?php
   $loggerGetImages =  LoggerMgr::Instance()->getLogger("getImages.php");
   $loggerGetImages->trace("getImages.php. Enter");
   
   require_once 'database/TB_ImagesAndCollection.php';
   require_once 'php/image/ImageLibrary.php';
   
   $menu = $_GET["pageId"];
   $collection = $_GET["collection"];

   $loggerGetImages->debug("Get images from : Menu [ $menu ]. Collection [ $collection ]");
 
   $tableImagesAndCollection = new TB_ImagesAndCollection();
   $tableImagesAndCollection->open();
   
   $tableImagesAndCollection->searchByColumn(
                  TB_ImagesAndCollection::CollectionIdColumnC, $collection);
  
  $loggerGetImages->debug("The menu [ $menu ] and the collection[ $collection ] has ".
            "[ ".$tableImagesAndCollection->getCardinality() ." ] images");
  
  $tableConfiguration->searchByColumn(TB_CONFIGURATION::PropertyColumnC, 
                                      "thumbnailsPath");
  $thumbnailsPath = $tableConfiguration->getValue();
  
  while ($tableImagesAndCollection->next()){
     $loggerGetImages->debug("FILE NAME: ".$tableImagesAndCollection->getImageDescription());
       $fileName = $tableImagesAndCollection->getImagePath().'/'.
                      $tableImagesAndCollection->getImageName();
       $imageSize = getimagesize($fileName);
       $imageWidth = $imageSize[0];
       $imageHeight = $imageSize[1];
       $loggerGetImages->trace("Create thumbanils to fileName [ $fileName ] \nWidth [ ".
             $imageWidth . " ]px\nHeight [ $imageHeight ]px");
       
    ?>
    <img src=<?php printf("\"%s\"",createThumbnail(  $tableImagesAndCollection->getImagePath()
                                                    ,$tableImagesAndCollection->getImageName()
                                                    ,150  //width
                                                    ,112  //Height
                                                    ,$tableImagesAndCollection->getImagePath().$thumbnailsPath 
                                                    ,"Thumb_",$logger));?> title=<?php printf("\"%s\"", 
                                                    $tableImagesAndCollection->getImageDescription());?> 
                                                    onclick=<?php 
                                                    printf("\"Lightbox.show({image:'%s',width:%d,height:%d,label:{position:'down',text:'%s'}});\"",
                                                    $fileName, $imageWidth, $imageHeight, $tableImagesAndCollection->getImageDescription());?> >
    <?php
    
    }
     
    
 
 $loggerGetImages->trace("getImages.php. Exit");
?>