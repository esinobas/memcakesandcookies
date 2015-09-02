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
      

      <link rel="stylesheet" type="text/css" href="style.css">
      
      <!--  Plugins -->
      <script type="text/javascript" src="../plugins/JQuery/jquery-1.9.0.js"></script>
      <script type="text/javascript" src="../plugins/JSLogger/JSLogger.js"></script>
      <script type="text/javascript" src="../plugins/VerticalTabs/VerticalTabs.js"></script>
      <link rel="stylesheet" type="text/css" href="../plugins/VerticalTabs/style.css">

      <!-- Include the php dir in php path -->
      <?php
         set_include_path(get_include_path().PATH_SEPARATOR . dirname(__FILE__) . '/../php/'); 
         
         require_once 'LoggerMgr/LoggerMgr.php';
         //Include the tables files
         require_once 'database/TB_Configuration.php';
         require_once 'database/TB_Menu.php';
         
         //Declare the global variables
         $logger = LoggerMgr::Instance()->getLogger(basename(__FILE__));
      ?>
   </head>
   <body>
      
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
                           if ($tableMenu->getId() > 1 && $tableMenu->getId() < 6){
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
                  Configuración
               </div>
               <div class="Vertical-Tab" id="Tab-Home">
                  Home
               </div>
               <?php
                  $tableMenu->rewind();
                  $logger->trace("Get the options menu for the tabs");
                  while ($tableMenu->next()){
                     if ($tableMenu->getId() > 1 && $tableMenu->getId() < 6){
                        $logger->trace("Write the menu option [ ".
                           $tableMenu->getOption() . " ] in tab");
                  ?>
               <div class="Vertical-Tab" id=<?php printf("\"Tab-%s\"",$tableMenu->getOption());?>>
                  <?php print($tableMenu->getOption());?>
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
   </body>

</html>