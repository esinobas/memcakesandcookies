<!DOCTYPE html>
<html lang="es">
   <head>
      <title>MEM Cakes & Cookies</title>
      <meta charset="utf-8">
      <meta name="author" content="Esteban Sinobas Carpio">
      <meta name="description" content="Página web de MEM Cakes & Cookies">
      <meta name="keywords" content="cakes, tartas, cookies, galletas">
      <meta name="application-name" content="MEM Cakes & Cookies">
      
      <!-- Styles -->
      <link rel="stylesheet" href="./style/style.css">
      
      <!--  Plugins -->
      <script type="text/javascript" src="./plugins/JQuery/jquery-1.9.0.js"></script>
      <script type="text/javascript" src="./plugins/JSLogger/JSLogger.js"></script>
      <script type="text/javascript" src="./plugins/Ajax/Ajax.js"></script>
      <script type="text/javascript" src="./plugins/ImagesSlide/ImagesSlide.js"></script>
      
      <!--  Plugins styles -->
      <link rel="stylesheet" href="./style/GridStyle.css">
      <link rel="stylesheet" href="./plugins/ImagesSlide/style.css">
      <link rel="stylesheet" href="./plugins/Instagram/style.css">
      
      <!--  Style  -->
      <!-- Include the php dir in php path -->
      <?php
         set_include_path(get_include_path().PATH_SEPARATOR . dirname(__FILE__) . '/php/'); 
         set_include_path(get_include_path().PATH_SEPARATOR . dirname(__FILE__) . '/plugins/');
         
         /** Get the  get parameters is if necesary **/
         $postId = $_GET['post'];
         $collectionId = $_GET['collectionId'];
         
         require_once 'LoggerMgr/LoggerMgr.php';
         require_once 'tools/SingletonHolder/SingletonHolder.php';
         require_once './PageFunctions.php';
         require_once 'Instagram/Instagram.php';
         require_once 'image/ImageLibrary.php';
         require_once 'image/ImageFunctions.php';
         
         //Include the tables files
         require_once 'Database/TB_Configuration.php';
         require_once 'Database/TB_SlideImagesHome.php';
         require_once 'Database/TB_MenuCollection.php';
         require_once 'Database/TB_TypeCollectionImage.php';
         require_once 'Database/TB_News.php';
         require_once 'Database/RequestFromWeb.php';

         
         //Declare the global variables
         
         
         //Create objects and add in the singleton holder
         SingletonHolder::getInstance()->setObject('Logger', LoggerMgr::Instance()->getLogger(basename(__FILE__)));
         SingletonHolder::getInstance()->setObject(
                       TB_Configuration::TB_ConfigurationTableC, new TB_Configuration());
         
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->open();
      ?>
      
   </head>
   <body>
      <?php
          if (isset($postId)){
            SingletonHolder::getInstance()->getObject('Logger')->trace("The parameter post is present [ $postId ]");
          }
          
          if (! isset($postId)){
            $tbConfiguration = SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC);
            $tbConfiguration->searchByKey('thumbnailsPath');
            $thumbDir = $tbConfiguration->getValue();
            $tbConfiguration->rewind();
            $tbConfiguration->searchByKey('cakesImagesPath');
          
            createThumbnailsFromDirectory($tbConfiguration->getValue(),
                                       array("jpg"),
                                       $tbConfiguration->getValue().$thumbDir,150, 150);
          
            $tbConfiguration->rewind();
            $tbConfiguration->searchByKey('cookiesImagesPath');
            createThumbnailsFromDirectory($tbConfiguration->getValue(),
                  array("jpg"),
                  $tbConfiguration->getValue().$thumbDir,150, 150);
            PageFunctions::writeJavascriptFunctions();
          }   
         PageFunctions::getHeader();
         
         if (!isset($postId) && !isset($collectionId)){
            PageFunctions::getImagesSlide();
         }
      ?>
      <div id="Main-Div">
    <?php 
       
         if (!isset($collectionId)){
            PageFunctions::getMainSection($postId);
         }else{
          
            PageFunctions::getCollectionImages($collectionId);
         }
         PageFunctions::getAside($postId);
       
       ?>
      </div>
      <?php PageFunctions::getFooter();?>
   </body>
</html>