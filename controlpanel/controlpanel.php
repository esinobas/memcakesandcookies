<?php 
   session_start();
?>
<html>
   <head>
      <title>
         Administracion MEM Cakes & Cookies
      </title>
      
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
            
      
      <!--  Plugins -->
      <script type="text/javascript" src="../plugins/JQuery/jquery-1.9.0.js"></script>
      <script type="text/javascript" src="../plugins/JSLogger/JSLogger.js"></script>
      <script type="text/javascript" src="../plugins/VerticalTabs/VerticalTabs.js"></script>
      <script type="text/javascript" src="../plugins/DataGrid/DataGrid.js"></script>
      
      <script type="text/javascript" src="../plugins/Common/HtmlObject/HtmlObject.js"></script>
      <script type="text/javascript" src="../plugins/Common/HtmlWindow/HtmlWindow.js"></script>
      <script type="text/javascript" src="../plugins/Common/HtmlForm/HtmlForm.js"></script>
      
      <script type="text/javascript" src="../plugins/Ajax/Ajax.js"></script>
      <script type="text/javascript" src="../plugins/MessageBox/MessageBox.js"></script>
      <script type="text/javascript" src="../plugins/FileBrowser/FileBrowser.js"></script>
      <script type="text/javascript" src="../plugins/DataEntry/DataEntryWindow.js"></script>
      <script type="text/javascript" src="../plugins/DataEntry/DataEntryFunctions.js"></script>
      <script type="text/javascript" src="../plugins/ListBox/ListBoxInit.js"></script>
      
      
      
      <link rel="stylesheet" type="text/css" href="../plugins/VerticalTabs/style.css">
      <link rel="stylesheet" type="text/css" href="../plugins/DataGrid/DataGrid.css">
      <link rel="stylesheet" type="text/css" href="../plugins/Styles/ButtonsStyles.css">
      <link rel="stylesheet" type="text/css" href="../plugins/Common/HtmlWindow/HtmlWindow.css">
      <link rel="stylesheet" type="text/css" href="../plugins/MessageBox/style/MessageBox.css">
      <link rel="stylesheet" type="text/css" href="../plugins/FileBrowser/style/Filebrowser.css">
      <link rel="stylesheet" type="text/css" href="../plugins/DataEntry/DataEntry.css">
      <link rel="stylesheet" type="text/css" href="../plugins/ListBox/ListBox.css">
      <link rel="stylesheet" type="text/css" href="../plugins/Grid/Grid.css">
      
      <link rel="stylesheet" type="text/css" href="style.css">

      <!-- Include the php dir in php path -->
      <?php
         set_include_path(get_include_path().PATH_SEPARATOR . dirname(__FILE__) . '/../php/'); 
         
         include_once 'LoggerMgr/LoggerMgr.php';
         
         require_once 'ControlpanelFunctions.php';
         //Include the tables files
         require_once 'Database/TB_Configuration.php';
         require_once 'Database/TB_Menu.php';
         require_once 'Database/TB_SlideImagesHome.php';
         require_once 'Database/RequestFromWeb.php';
         require_once 'Database/TB_TypeCollectionImage.php';
         require_once 'Database/TB_MenuCollection.php';
         require_once 'Database/TB_ImageType.php';
         require_once 'Database/TB_News.php';
         
         //Declare the global variables
         $logger = LoggerMgr::Instance()->getLogger(basename(__FILE__));
      ?>
   </head>
   <body>
   
      <script type="text/javascript">
         JSLogger.getInstance().registerLogger("ControlPanel", JSLogger.levelsE.DEBUG);
      </script>
      
      <div id="main">
         <div id="header">      
            
            <div id="logo">
               <img src="../images/logoCMYKwithoutBorder.jpg" alt="MEM Cakes & Cookies" title="MEM Cakes & Cookies"/>
            </div>
            <div id="centerHeader">
               <h1>Panel de Administracion</h1>
            </div>
            <div id="rightHeader">
               <div id="usuario">               
                  Usuario:
               </div>
               <div id="user">
                  <?php
                     $user = $_SESSION['user'];
                     printf("%s\n", $user);
                  ?>
                  </div>
                  <div id="exit">
                     <a href="./logout.php">Salir</a>
                  </div>
            </div>
         </div> <!-- header -->
     
         <div id="data">
            <div class="Vertical-Tabs" id="MainTab">
               <div class="Title-Tabs">
                  <ul>
                     <li><a href="#Tab-Configuration">Configuracion</a></li>
                     <li><a href="#Tab-Home">Home</a></li>
                     <?php
                        // Include the options menu
                        $tableMenu = new TB_Menu();
                        $tableMenu->open();
                        $logger->trace("Get the options menu for the tabs tittle");
                        while ($tableMenu->next()){
                           if ($tableMenu->getId() > 1 && $tableMenu->getId() < 4){
                              $logger->trace("Write the menu option [ ". 
                                   $tableMenu->getOption() . " ] in tab title");
                     ?>
                     <li><a href=<?php printf("\"#Tab-%s\"",$tableMenu->getOption());?>><?php print($tableMenu->getOption());?></a>
                     <?php 
                           }
                        }
                     ?>
                     <li><a href="#Tab-Subcription">Subcripciones</a></li>
                  </ul>
               </div>
               <div class="Vertical-Tab" id="Tab-Configuration">
                  
                  <?php ControlpanelFunctions::getConfiguration(); ?>
               </div>
               <div class="Vertical-Tab" id="Tab-Home">
                  <?php 
                     ControlpanelFunctions::getHome();
                  ?>
               </div>
               <?php
                  $tableMenu->rewind();
                  $tableMenuCollection = new TB_MenuCollection();
                  $tableTypeCollectionImage = new TB_TypeCollectionImage();
                  $tableMenuCollection->open();
                  $tableTypeCollectionImage->open();
                  $logger->trace("Get the options menu for the tabs");
                  while ($tableMenu->next()){
                     if ($tableMenu->getId() > 1 && $tableMenu->getId() < 4){
                        $logger->trace("Write the menu option [ ".
                           $tableMenu->getOption() . " ] in tab");
                  ?>
               <div class="Vertical-Tab" id=<?php printf("\"Tab-%s\"",$tableMenu->getOption());?>>
                  <?php 
                        if ($tableMenu->getId() > 1 && $tableMenu->getId() < 4){
                           ControlpanelFunctions::getImagesByType($tableMenu->getId(), $tableMenuCollection, $tableTypeCollectionImage);
                        }
                  ?>
               </div>
                  <?php 
                        
                     }
                  }
               ?>
               <div class="Vertical-Tab" id="Tab-Subcription">
                  Subscriptores
               </div>
            </div>
         </div> <!-- data   -->
      </div> <!-- main -->
      
      <?php 
      $logger->trace("Add the window for add a new collections");
   ?>
      <div id="WindowAddCollection" class="DataEntryWindow DataEntryWindow-Hide">
         <div class="DataEntryWindow-Tittle">
            Nueva Colección
         </div>
         <div class="DataEntryFrm">
            <div class="DataEntryContainer">
               <div class="DataEntryRow">
                  <div class="DataEntryLabel" id="NewCollectionLabel">
                     Nombre de la colección: 
                  </div>
                  <div class="DataEntryValue" id="NewCollectionValue">
                     <input type="text">
                  </div>
                  
               </div>
            </div>
            <div class="DataEntryButtonsContainer">
               <div class="Round-Corners-Button DataEntryWindowButtonOk">Aceptar</div>
               <div class="Round-Corners-Button DataEntryWindowButtonCancel">Cancelar</div>
            </div>
         </div>
      </div>
      <div id="WindowAddImageDesc" class="DataEntryWindow DataEntryWindow-Hide">
         <div class="DataEntryWindow-Tittle">   
            Añade una descripción a la imagen
         </div>
         <div class="DataEntryFrm">
            <div class="DataEntryContainer">
               <div class="DataEntryRow">
                  <div class="DataEntryLabel" id="Image">
                     <img src="">
                  </div>
                  <div class="DataEntryValue">
                     <input type="text" id="ImageDesc">
                  </div>
               </div>
            </div>
            <div class="DataEntryButtonsContainer">
               <div id="btnAddImageOk" class="Round-Corners-Button DataEntryWindowButtonOk">Aceptar</div>
               <div id="btnCancelImageOk" class="Round-Corners-Button DataEntryWindowButtonCancel">Cancelar</div>
            </div>
         </div>
      </div>
      <script type="text/javascript">
         ListBoxInit.execute(true);
      </script>
      <?php 
         ControlpanelFunctions::addAddPictureClickEvent();
         ControlpanelFunctions::writeJSFunctionAddImageToCollection();
         ControlpanelFunctions::writeJSFuncionAddNewCollection();
         ControlpanelFunctions::writeJSFunctionAddNewImage();
         ControlpanelFunctions::writeJSFunctionAddImageCallback();
         ControlpanelFunctions::writeJSFuncionInsertImageIntoCollection();
         ControlpanelFunctions::writeJSFunctionOpenFileBrowser();
         ControlpanelFunctions::writeJSFunctionInsertNewCollection();
      ?>
   </body>

</html>