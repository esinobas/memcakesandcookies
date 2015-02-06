<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Gestion de Cursos</title>
      
     <script type="text/javascript" src="./Plugins/JSLogger/JSLogger.js"></script>
     <script type="text/javascript" src="./Plugins/JQuery/jquery-1.9.0.js"></script>
     <script type="text/javascript" src="./Plugins/Common/HtmlObject/HtmlObject.js"></script>
     <script type="text/javascript" src="./Plugins/Common/HtmlWindow/HtmlWindow.js"></script>
     <script type="text/javascript" src="./Plugins/Common/HtmlForm/HtmlForm.js"></script>
     <script type="text/javascript" src="./Plugins/FileBrowser/FileBrowser.js"></script>
     <script type="text/javascript" src="./Plugins/DataGrid/DataGrid.js"></script>
     <script type="text/javascript" src="./Plugins/Ajax/Ajax.js"></script>
     <script type="text/javascript" src="./Plugins/DataEntryForm/DataEntryForm.js"></script>
     
     <link rel="stylesheet" type="text/css" href="./Plugins/FileBrowser/style/Filebrowser.css">
     <link rel="stylesheet" type="text/css" href="./Plugins/DataGrid/style/DataGrid.css">
     <link rel="stylesheet" type="text/css" href="./Plugins/DataEntryForm/style/DataEntryForm.css">
     <link rel="stylesheet" type="text/css" href="./style/CursesManagement.css">
     <link rel="stylesheet" type="text/css" href="./Plugins/Common/HtmlWindow/HtmlWindow.css">
   </head>
   <body>
      
      <script type="text/javascript">
         function showData(theIdElement){

            $('.div_data').hide();
            
            $('#'+theIdElement).show();
         }
      </script>
      <?php
         set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] );
         set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']. '/controlpanel/Cursos/php');
     
         include_once 'LoggerMgr/LoggerMgr.php';
         include_once 'Database/TB_Configuration.php';
         include_once 'Database/RequestFromWeb.php';
         
         $logger = LoggerMgr::Instance()->getLogger("CursesManagement.php");
      ?>
      <div id="container">
         <div id="header">
            Gestion de cursos
         </div>
         <div id="central">
            <div id="menu" class="horizontal_menu">
               <ul id="menu_list">
                  <li><a href="#" onclick="showData('div_cursos')">Cursos</a></li>
                  <li><a href="#" onclick="showData('div_clientes')">Clientes</a></li>
                  <li><a href="#" onclick="showData('div_configuracion')">Configuración</a></li>
               </ul>
            </div>
            <div id="div_configuracion" class="div_data">
               <div class="data_title">
                  <h1>Configuracion</h1>
               </div>
               <div id="grid_config" class="grid">
               <?php
                  $logger->trace("Get the configuration data");
                  $tbConfiguration = new TB_Configuration();
                  $tbConfiguration->open();
                  while ($tbConfiguration->next()){
                     ?>
                     <div id=<?php printf("\"%s\"",$tbConfiguration->getProperty());?> class="data_configuration">
                        <div class="label-grid-colum">
                         
                           <div class="label">
                              <?php print($tbConfiguration->getLabel()."\n");?>
                           </div>
                        </div>
                     
                        <div class="value-grid-column">
                           <div class="config_value">
                              <input type=<?php if (strcmp($tbConfiguration->getProperty(), "Path") == 0){print("\"text\"");}else{print("\"number\" min=\"0\" max=\"300\" step=\"1\"");}?>
                                  class= "input_grid" id=<?php printf("\"Data_%s\"", $tbConfiguration->getProperty());?>
                                        value=<?php printf("\"%s\"",$tbConfiguration->getValue());?>
                                        title=<?php printf("\"%s\"",$tbConfiguration->getDescription());?>
                                        <?php if (strcmp($tbConfiguration->getProperty(), "Path") == 0){print(" readonly");}?>>
                           </div>
                        </div>
                        <div class="desc-grid-column">
                           <?php 
                              if (strcmp($tbConfiguration->getProperty(), "Path") == 0){
                           ?>
                              <input type="button" value="Seleccionar" id="btnSelectDir">
                           <?php 
                              }else if (strcmp($tbConfiguration->getProperty(), 
                                  "Time_between_steps") == 0){
                           ?>
                               <div class="label">
                                 Segundos
                              </div>
                           <?php }else{
                              ?>
                              <div class="label">
                              <?php print($tbConfiguration->getDescription()); ?>
                              </div>
                              <?php 
                              }
                           
                           ?>
                        </div>
                      </div>
                  <?php 
                  } //While next 
               ?>
               <div class="newLine">
                  <input type="button" id ="btnsave" value="Guardar">
               </div>
               </div> <!-- div grid -->
               
            </div>
            <div id="div_cursos" class="div_data">
               <div class="data_title">
                  <h1>Cursos</h1>
               </div>
               <?php include_once 'Curses.php'?>
               
            </div>
            <div id="div_clientes" class="div_data">
                  <h1>Clientes</h1>
               </div>
            </div>
            
         </div>
         <div id="footer">
            footer
         </div>
      
     
      <script type="text/javascript">
         JSLogger.getInstance().registerLogger("CursesManagement", JSLogger.levelsE.TRACE);
         JSLogger.getInstance().debug("Mi primer log");

          mostrarDatos = function(theData){

                
                var message = "Data: " + theData.path + ". Type: "+ (theData.file?"File":"Directory");;
                JSLogger.getInstance().debug("Callback : " + message);
                $('#Data_Path').val(theData.path);
                JSLogger.getInstance().debug("VALOR:" +$('#Data_Path_Cursos').val());
            }
         $('#btnSelectDir').click(function(){
               fileBrowser = new FileBrowser(
                     {path:{
                           root_path:<?php printf("\"%s\"",$_SERVER['DOCUMENT_ROOT']);?>,
                           current_path: $('#Data_Path').val()},
                           type: "d", filter: "*.*", 
                           callback:mostrarDatos,
                           Title_Params:{
                              Caption:"Selecciona un directorio donde se guardara los cursos...",
                              Background_Color:"orange"},});
               
            }
         );
         $('#btnsave').click(function(){
            var objAjax = new Ajax();
            objAjax.setSyn();
            objAjax.setPostMethod();
            objAjax.setUrl("http://memcakesandcookies/controlpanel/Cursos/php/Database/RequestFromWeb.php");
            var paramsRequest = {};
            paramsRequest.command = <?php print("\"".$COMMAND_UPDATE."\"");?>;
            paramsRequest.paramsCommand = {};
            paramsRequest.paramsCommand.Table = <?php print("\"".TB_Configuration::TB_ConfigurationTableC."\"");?>;
            JSLogger.getInstance().trace("Get all data configuration");
            var rows = {};
            $('.data_configuration').each(function(index){

                  var property = $(this).attr('id');
                  var value = $(this).find('input').val();
                  var row = {};
                  row.<?php print($PARAM_KEY);?> = property;
                  row.<?php print(TB_Configuration::ValueColumnC);?> = value;
                  JSLogger.getInstance().trace("Property [ " + property +" ] -> [ " + value +" ]");
                  rows[index] = row;
               }
            );
            paramsRequest.paramsCommand.<?php print($PARAM_ROWS);?> = rows;
            objAjax.setParameters(JSON.stringify(paramsRequest));
            objAjax.send();
            
           
         });
      </script>
   </body>
    

</html>