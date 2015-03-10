<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>Insert title here</title>
      
      <?php
      
         /***** INCLUDES *****/
         set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] );
         set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']. '/controlpanel/Cursos/php');
         include_once 'Database/TB_Curse_Step.php';
         include_once 'Database/TB_Curso.php';
      ?>
      
      <!--  ******* SCRTIPS ********* -->
      <script type="text/javascript" src="./Plugins/JSLogger/JSLogger.js"></script>
      <script type="text/javascript" src="./Plugins/JQuery/jquery-1.9.0.js"></script>
      <script type="text/javascript" src="./Plugins/Tabs/Tabs.js"></script>
      
      <!--  ******* STYLES ******** -->
      <link rel="stylesheet" type="text/css" href="./style/EditCurse.css">
      <link rel="stylesheet" type="text/css" href="./Plugins/Tabs/style/Tabs.css">
   </head>
   <body>
      <script type="text/javascript">
         JSLogger.getInstance().registerLogger("EditCurse.php",JSLogger.levelsE.TRACE);
      </script>
      <script>
         /*** Modify the page title name with the name of the curse ***/
         function modifyPageTitleName(theCurseName){
            $('title').html("Editar [ " + theCurseName + " ]");
         }
      </script>
      <?php
      
         $curseKey = $_GET["key"];
         $tbCurseStep = new TB_Curse_Step();
         $tbCurse = null;
         $tbCurseStep->open();
         $tbCurseStep->searchByColumn(TB_Curse_Step::Curse_IdColumnC, $curseKey);
         if ($tbCurseStep->getCardinality() == 0){
            $tbCurse = new TB_Curso();
            $tbCurse->open();
            $tbCurse->searchByColumn(TB_Curso::IdColumnC, $curseKey);
            while ($tbCurse->next()){
               //printf("<p>%s</p>\n", $tbCurse->getName());
               ?>
               <script>
                  modifyPageTitleName(<?php printf("\"%s\"",$tbCurse->getName())?>);
               </script>
               <?php 
            }
         }
         while ($tbCurseStep->next()){
            //printf("%s\n", $tbCurseStep->getCurseName());
            ?>
               <script>
                  modifyPageTitleName(<?php printf("\"%s\"",$tbCurseStep->getCurseName())?>);
               </script>
            <?php 
         }
      ?>

      <header>
         Edición del curso: <span>
         <?php 
         if ($tbCurseStep->getCardinality() == 0){
            printf("%s\n",$tbCurse->getName());
         }else{
            printf("%s\n",$tbCurseStep->getCurseName());
         }
         ?>
         </span>
      </header>
      <section>
         <div id="edit-curse-main">
            <div id="main-tabs" class="class-tabs">
               <ul class="title-tab">
                  <li><a href="#tab-data">Datos del curso</a></li>
                  <li><a href="#tab-steps">Pasos del curso</a></li>
                  <li><a href="#tab-customers">Clientes inscritos al curso</a></li>
               </ul>
               <div class="tab-RC"></div>
               <div id="tab-data" class="class-tab">
                  Nombre: <?php printf("%s\n",$tbCurse->getName());?>
               </div>
               <div id="tab-steps" class="class-tab">
                  Pasos
               </div>
               <div id="tab-customers" class="class-tab">
                  Clientes
               </div>
            </div>
         </div>
      </section>
      <footer>
      </footer>
   </body>

</html>