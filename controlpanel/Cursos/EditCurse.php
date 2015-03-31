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
         include_once 'Database/TB_Level.php';
         include_once 'Database/TB_Configuration.php';
         include_once 'Database/RequestFromWeb.php';
      ?>
      
      <!--  ******* SCRTIPS ********* -->
      <script type="text/javascript" src="./Plugins/JSLogger/JSLogger.js"></script>
      <script type="text/javascript" src="./Plugins/JQuery/jquery-1.9.0.js"></script>
      <script type="text/javascript" src="./Plugins/Tabs/Tabs.js"></script>
      <script type="text/javascript" src="./Plugins/Ajax/Ajax.js"></script>
      <script type="text/javascript" src="./Plugins/Common/HtmlObject/HtmlObject.js"></script>
      <script type="text/javascript" src="./Plugins/Common/HtmlWindow/HtmlWindow.js"></script>
      <script type="text/javascript" src="./Plugins/Common/HtmlForm/HtmlForm.js"></script>
      <script type="text/javascript" src="./Plugins/FileBrowser/FileBrowser.js"></script>
      <script type="text/javascript" src="./Plugins/MessageBox/MessageBox.js"></script>
            
      <!--  ******* STYLES ******** -->
      <link rel="stylesheet" type="text/css" href="./style/EditCurse.css">
      <link rel="stylesheet" type="text/css" href="./Plugins/Tabs/style/Tabs.css">
      <link rel="stylesheet" type="text/css" href="./Plugins/Common/HtmlWindow/HtmlWindow.css">
      <link rel="stylesheet" type="text/css" href="./Plugins/MessageBox/style/MessageBox.css">
      <link rel="stylesheet" type="text/css" href="./Plugins/FileBrowser/style/Filebrowser.css">
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
         $tbConfiguration = new TB_Configuration();
         $tbConfiguration->open();
         
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
                  <div class="data-curse">
                     <div class="data-curse-label">Nombre:</div>
                      <input type="text" id="data-curse-name" value=
                     <?php 
                        if ($tbCurseStep->getCardinality() == 0){
                           printf("\"%s\"",$tbCurse->getName());
                        }else{
                           printf("\"%s\"",$tbCurseStep->getCurseName());
                        }
                     ?>
                     >
                  </div>
                  <div class="div-return-carriage"></div>
                  <div class="data-curse">
                     <div class="data-curse-label">Descripción:</div>
                     <textarea rows=4 id="data-curse-desc"><?php 
                        if ($tbCurseStep->getCardinality() == 0){
                           printf("%s",$tbCurse->getDescription());
                        }else{
                           printf("%s",$tbCurseStep->getCurseDescription());
                        }
                     ?></textarea>
                  </div>
                  <div class="div-return-carriage"></div>
                  <div class="data-curse">
                     <div class="data-curse-label" id="duration-label">Duración:</div>
                     <input type="number" id="data-curse-duration" value=
                     <?php 
                        if ($tbCurseStep->getCardinality() == 0){
                           printf("\"%s\"",$tbCurse->getDuration());
                        }else{
                           printf("\"%s\"",$tbCurseStep->getCurseDuration());
                        }
                     ?>> 
                     <div class="data-curse-label">Días.</div>
                     
                     <div class="data-curse-label" id="price-label">Precio:</div>
                     <input type="number" id="data-curse-price" value=
                        <?php 
                           if ($tbCurseStep->getCardinality() == 0){
                              printf("\"%s\"",$tbCurse->getPrice());
                           }else{
                              printf("\"%s\"",$tbCurseStep->getCursePrice());
                           }
                        ?>>
                      <div class="data-curse-label">Euros.</div>
                     
                     
                     <div class="data-curse-label" id="level-label">Nivel:</div>
                     <?php
                        $TB_Level = new TB_Level();
                        $TB_Level->open();
                     ?>
                     <select id="data-curse-level" name="data-curse-level">
                     <?php 
                        while($TB_Level->next()){
                     ?>
                           <option value=
                           <?php
                              printf("\"".$TB_Level->getId()."\"");
                              $selectedLevel = 0;
                              if ($tbCurseStep->getCardinality() == 0){
                                 $selectedLevel = $tbCurse->getLevelId();
                              }else{
                                 $selectedLevel = $tbCurseStep->getCurseLevelId();
                              }
                              if ($TB_Level->getId() == $selectedLevel){
                                 print(" selected");
                              }
                           ?>
                           ><?php printf("%s", $TB_Level->getLevel());?></option>
                        <?php 
                           }
                        ?>
                     </select>
                     
                     <div class="data-curse-label" id="public-label">Publicado:</div>
                     <input type="checkbox" id="data-curse-public" 
                     <?php 
                        $cursePubliced = false;
                        if ($tbCurseStep->getCardinality() == 0){
                          $cursePubliced = ($tbCurse->getPublic() != 0);
                        }else{
                           $cursePubliced = ($tbCurseStep->getCursePublic() != 0);
                        }
                        if ($cursePubliced ){
                           print("checked");
                        }
                     ?>>
                  </div>

                  <div class="div-return-carriage"></div>
                  <div class="data-curse">
                     <img id ="CurseImage" title="Pincha para seleccionar una portada" alt="Portada" src=
                        <?php if ($tbCurseStep->getCardinality() == 0){
                           printf("\"%s\"",$tbCurse->getImage());
                        }else{
                           printf("\"%s\"",$tbCurseStep->getCurseImage());
                        }?>
                        >
                  </div>
                  <div class="div-return-carriage"></div>
                  <button id="btnDataCurseSave" type="button" disabled="disabled">Guardar</button>
                  
                  <!--  Declare function for enable button save when any value is changed in any input control -->
                  <script type="text/javascript">
                     
                      function enableDataCurseEnableButton(){
                         $('#btnDataCurseSave').prop('disabled', false);
                      }
                      $('#data-curse-name').keypress(enableDataCurseEnableButton);
                      $('#data-curse-desc').keypress(enableDataCurseEnableButton);
                      $('#data-curse-duration').change(enableDataCurseEnableButton);
                      $('#data-curse-price').change(enableDataCurseEnableButton);
                      $('#data-curse-level').change(enableDataCurseEnableButton);
                      $('#data-curse-public').change(enableDataCurseEnableButton);

                      /* Funtion for modify the curse data in data base */
                      function modifyCurseData(){
                         JSLogger.getInstance().traceEnter();
                         var ajaxObject = new Ajax();
                         ajaxObject.setPostMethod();
                         ajaxObject.setSyn();
                         var url = <?php
                               $tbConfiguration->rewind();
                               $tbConfiguration->searchByKey('URL');
                               printf("\"%s\"",$tbConfiguration->getValue());?>+
                                     "/controlpanel/Cursos/php/Database/RequestFromWeb.php";
                         JSLogger.getInstance().trace("url [ " + url +" ]");
                         ajaxObject.setUrl(url);

                         var paramsRequest = {};
                         paramsRequest.command = <?php print("\"".$COMMAND_UPDATE."\"");?>;
                         paramsRequest.paramsCommand = {}
                         paramsRequest.paramsCommand.Table = <?php
                                   if ($tbCurseStep->getCardinality() == 0)
                                      print("\"".TB_Curso::TB_CursoTableC."\"");
                                   else
                                      print("\"".TB_Curse_Step::TB_Curse_StepTableC."\"");?>;
                         
                         paramsRequest.paramsCommand.<?php print($PARAM_ROWS);?> = {};
                         paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_ROWS,$PARAM_ROW);?> = {};
                         paramsRequest.paramsCommand.<?php printf("%s.%s.%s",$PARAM_ROWS,$PARAM_ROW, $PARAM_KEY);?> =
                                 <?php if ($tbCurseStep->getCardinality() == 0)
                                          print $tbCurse->getId();
                                       else
                                          print $tbCurseStep->getId();
                                  ?>;
                         paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW); 
                                 if ($tbCurseStep->getCardinality() == 0)
                                    print TB_Curso::NameColumnC;
                                 else 
                                    print(TB_Curse_Step::CurseNameColumnC);?> = 
                         $('#data-curse-name').val();
                         paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW);
                                 if ($tbCurseStep->getCardinality() == 0) 
                                    print TB_Curso::DescriptionColumnC;
                                 else 
                                    print(TB_Curse_Step::CurseDescriptionColumnC);?> = 
                         $('#data-curse-desc').val();
                         paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW);
                                 if ($tbCurseStep->getCardinality() == 0) 
                                    print TB_Curso::DurationColumnC;
                                 else 
                                    print(TB_Curse_Step::CurseDurationColumnC);?> = 
                         $('#data-curse-duration').val();
                         paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW);
                                 if ($tbCurseStep->getCardinality() == 0)
                                    print TB_Curso::PriceColumnC;
                                 else 
                                    print(TB_Curse_Step::CursePriceColumnC);?> = 
                         $('#data-curse-price').val();
                         paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW);
                                if ($tbCurseStep->getCardinality() == 0)
                                    print TB_Curso::LevelIdColumnC;
                                 else
                                    print(TB_Curse_Step::CurseLevelIdColumnC);?> = 
                         $('#data-curse-level').val();
                         paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW);
                                 if ($tbCurseStep->getCardinality() == 0) 
                                    print TB_Curso::LevelColumnC;
                                 else 
                                    print(TB_Curse_Step::CurseLevelColumnC);?> =
                         $('#data-curse-level option:selected').text();
                         paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW);
                                 if ($tbCurseStep->getCardinality() == 0) 
                                    print TB_Curso::PublicColumnC;
                                 else 
                                    print(TB_Curse_Step::CursePublicColumnC);?> = 
                         ($('#data-curse-public').prop("checked") == false ? 0 : 1);
                         paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW);
                                 if ($tbCurseStep->getCardinality() == 0)
                                    print TB_Curso::ImageColumnC;
                                 else
                                    print(TB_Curse_Step::CurseImageColumnC);?> =
                         $('#CurseImage').prop("src");
                               
                         JSLogger.getInstance().debug("Trying modify data curse with theses parameters [ " +
                         JSON.stringify(paramsRequest) +" ]");

                               ajaxObject.setParameters(JSON.stringify(paramsRequest));
                         ajaxObject.send();
                         JSLogger.getInstance().trace("Response [ " + ajaxObject.getResponse() + " ]");

                         if (ajaxObject.getResponse().indexOf("404 Not Found") != -1){
                            JSLogger.getInstance().error("The script [ " + url +
                                  " ] has been found");
                            MessageBox("Error", 
                                  "El curso no se ha modificado. No se ha podido acceder al script en el servidor",
                                  {Icon: MessageBox.IconsE.ERROR});
                         }else{
                            var objResponse = JSON.parse(ajaxObject.getResponse());
                            if (parseInt(objResponse['ResultCode']) != 200){
                                     MessageBox("Error", 
                                        "No se ha podido modificar el curso. Error [ " +
                                        objResponse['ErrorMsg'] + " ]",
                                        {Icon: MessageBox.IconsE.ERROR});
                                   JSLogger.getInstance().error("The curse has been not update. [ " +
                                         objResponse['ErrorMsg'] + " ]");
                            }else{
                               $('#btnDataCurseSave').prop('disabled', true);
                            }
                         }
                         JSLogger.getInstance().traceExit();
                      }//function modifyCurseData
                      
                      
                      $('#btnDataCurseSave').click(modifyCurseData);

                      //***** Add functionality to the image 
                      $('#CurseImage').click(function(){
                        JSLogger.getInstance().traceEnter();
                        <?php
                           $tbConfiguration->rewind();
                           $tbConfiguration->searchByKey('URL');
                           $url = $tbConfiguration->getValue();
                           $tbConfiguration->rewind();
                           $tbConfiguration->searchByKey('Path');
                           $pathCurses = $tbConfiguration->getValue();
                         ?>
                         function callbackFileBrowserImage(dataCallback){

                            $('#CurseImage').prop('src',<?php printf("'%s/%s'",$url, $pathCurses);?>+'/'+dataCallback.path);
                            enableDataCurseEnableButton();
                         }
                         fileBrowserImage = new FileBrowser({path:{root_path:
                            <?php printf("\"%s/%s\"",$_SERVER['DOCUMENT_ROOT'],
                                           $pathCurses);
                            ?>,
                            },
                            type: "a", filter: "*.*",
                            Title_Params:{
                               Caption:"Selecciona una imagen ...",
                               Background_Color:"orange"},
                               callback: callbackFileBrowserImage,
                            toolbar:"upload_file|create_folder|delete"
                               });
                        JSLogger.getInstance().traceExit();
                      });
                  </script>
               
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