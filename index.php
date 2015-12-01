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
      <link rel="stylesheet" href="./plugins/ImagesSlide/style.css">
      <link rel="stylesheet" href="./plugins/Instagram/style.css">
      
      <!--  Style  -->
      <!-- Include the php dir in php path -->
      <?php
         set_include_path(get_include_path().PATH_SEPARATOR . dirname(__FILE__) . '/php/'); 
         set_include_path(get_include_path().PATH_SEPARATOR . dirname(__FILE__) . '/plugins/');
         
         require_once 'LoggerMgr/LoggerMgr.php';
         require_once 'tools/SingletonHolder/SingletonHolder.php';
         require_once './PageFunctions.php';
         require_once 'Instagram/Instagram.php';
         require_once 'image/ImageLibrary.php';
         
         //Include the tables files
         require_once 'Database/TB_Configuration.php';
         require_once 'Database/TB_SlideImagesHome.php';
         require_once 'Database/TB_MenuCollection.php';
         require_once 'Database/TB_TypeCollectionImage.php';
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
      <?php PageFunctions::getHeader();?>
      <?php PageFunctions::getImagesSlide();?>
      <div id="Main-Div">
         <?php PageFunctions::getMainSection();?>
         <?php PageFunctions::getAside();?>
      </div>
      <?php PageFunctions::getFooter();?>
   </body>
</html>