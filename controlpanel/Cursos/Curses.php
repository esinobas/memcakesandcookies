<?php 
   include_once 'Database/TB_Curso.php';
   include_once 'Database/TB_Level.php'
?>
<script type="text/javascript">
<!--

//-->

JSLogger.getInstance().registerLogger("Curses.php",JSLogger.levelsE.TRACE);
</script>
<div class="data-container">
   <div class="toolbar">
      <div class="toolbar-bottom" id="btnNew">
         <img src="./icons/page_add.png">Nuevo
      </div>
      <div class="toolbar-bottom" id="btnEdit">
         <img src="./icons/page_edit.png">Abrir
      </div>
      <div class="toolbar-bottom" id="btnRemove">
         <img src="./icons/page_delete.png">Borrar
      </div>
   </div>
   <div id="div-cursos">
      <div class="class-grid" id="grid-cursos">
         <div class="class-grid-header">
            <div>Nombre del Curso</div>
            <div>Dificultad</div>
            <div>Precio</div>
         </div>
         <div class="new-row"></div>
         
         <?php
            $tableCurses = new TB_Curso(); 
            $tableCurses->open();
            while ($tableCurses->next()){
         ?>
         <div class="class-grid-row">
            <div class="class-grid-row-key"><?php print($tableCurses->getId());?></div>
            <div class="class-grid-row-data"><?php print($tableCurses->getName());?></div>
            <div class="class-grid-row-data"><?php print($tableCurses->getLevel());?></div>
            <div class="class-grid-row-data"><?php print($tableCurses->getPrice());?></div>
            <div class="class-grid-row-hidden-data"><?php print($tableCurses->getDescription());?></div>
            <div class="class-grid-row-hidden-data"><?php print($tableCurses->getImage());?></div>
         </div>
         <!--  <div class="new-row"></div> -->
         <?php
            }
         ?>
      </div>
      
   </div>
   <div id="div-image-cursos">
   </div>
   <div id="div-description-cursos">
   </div>
   <script type="text/javascript">
         function getRow(theRowNumber){
            JSLogger.getInstance().trace("Getting the row [ " +theRowNumber +
            " ] from grid");
            var row = null;
            var rows =$('.class-grid-row').each(function(index, object){
               if (index == theRowNumber){
                  row = object;
                  return;
               }
               
            });
            return row;
         };
         
         var gridOnClick = function (theIndex){
            JSLogger.getInstance().trace("The selected row is [ " +theIndex +
                  "  ]");
            var row = getRow(theIndex);
            var description = $(row).find('.class-grid-row-hidden-data')[0];
            
            $('#div-description-cursos').empty();
            $('#div-description-cursos').append('<p>'+ $(description).text()+
                       '</p>');
            var divImage = $(row).find('.class-grid-row-hidden-data')[1];
            $('#div-image-cursos').empty();
            $('#div-image-cursos').append('<img src="' + $(divImage).text()+'">');
            
         };
         var gridOnDoubleClick = function (theIndex){
            
         };
         function formatDataGrid(){
            DataGrid.show($('#grid-cursos'),{Size:{Width: 490, Height: 490},
                                    columns_size:{0:300,1:94,2:65},
                     header_background_color: "#7D5F3F",
                     header_font_color: "white",
                     row_background_color: "white",
                     row_font_color: "#7D5F3F",
                     selected_row_background_color: "orange",
                     selected_row_font_color: "white",
                     show_lines:"vertical",
                     click_callback: gridOnClick,
                     double_click_callback: gridOnDoubleClick});
         }
         formatDataGrid();
        
         
      </script>
     <!--  The next div must be hidden. It is showed by in plugin -->
<div id="frmCurse" class="Data-Entry-Form">
   <div class="Data-Entry-Form-Data">
      <div class="Data-Entry-Form-Data-Label">Nombre:</div>
      <div class="Data-Entry-Form-Data-Value">
         <input type="text" id="input-curse-name" maxlength="50">
      </div>
   </div>
   <div class="Data-Entry-Form-Data">
      <div class="Data-Entry-Form-Data-Label">Descripción:</div>
      <div class="Data-Entry-Form-Data-Value">
         <textarea id="textarea-curse-description" rows="4"></textarea>
      </div>
   </div>
   <div class="Data-Entry-Form-Data">
      <div class="Data-Entry-Form-Data-Label">Dificultad:</div>
      <div class="Data-Entry-Form-Data-Value">
         <?php 
            $tbLevel = new TB_Level();
            $tbLevel->open();
         ?>
         <select id="frmDificultad" name="Dificultad">
            <?php
               while($tbLevel->next()){
            ?>
               <option value=<?php print("\"".$tbLevel->getId()."\"");?>>
                        <?php print($tbLevel->getLevel());?>
               </option>
            <?php       
               } 
            ?>
         </select>
      </div>
  <!--  </div>
   <div class="Data-Entry-Form-Data"> --> 
      <div class="Data-Entry-Form-Data-Label">Precio:</div>
      <div class="Data-Entry-Form-Data-Value">
         <input type="number" id="input-price" >
      </div>
      <div class="Data-Entry-Form-Data-Label">Euros</div>
   </div>
   <div class="Data-Entry-Form-Data">
      <div class="Data-Entry-Form-Data-Label">Duracion:</div>
         <div class="Data-Entry-Form-Data-Value">
            <input type="number" id="input-duration" >
         </div>
      <div class="Data-Entry-Form-Data-Label">Días</div>
   </div>
   <div class="Data-Entry-Form-Data">
      <div class="Data-Entry-Form-Data-Label">Portada:</div>
   </div>
   <div class="Data-Entry-Form-Data">
      <div class="Data-Entry-Form-Data-Value" id="image-preview">
         <div>
         Pulsa para selecionar una imagen
         </div>
      </div>
     
   </div>
</div>
<div id="Test">Test</div>
</div> <!-- div #data-container -->
         


<!-- Add click event to the bottons -->
<script type="text/javascript">

   /**
   * Function that is ised like callback for create a new curse in the ddbb
   */
   function createCurse(){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Check is all data have been entered");
      //To do, check if all were inserted
      
      var nameCurse = $('#input-curse-name').val();
      var descCurse = $('#textarea-curse-description').val();
      var dificultadCurseId = $('#frmDificultad').val();
      var dificultadCurse = $.trim($('#frmDificultad option:selected').text());
      var priceCurse = $('#input-price').val();
      var durationCurse = $('#input-duration').val();
      var imageUrl = $('#image-preview img').attr('src');
      
      JSLogger.getInstance().trace("Create a new curse with the following data:\n"+
            "Name [ " + nameCurse +" ]\n"+
            "Description [ " + descCurse +" ]\n"+
            "Dificultad [ " + dificultadCurseId +" ]->[ "+ dificultadCurse + "]\n"+
            "Price [ " + priceCurse +" ] Euros\n"+
            "Duration [ " + durationCurse +" ] days\n"+
            "Image URL [ " + imageUrl +" ]");

      var objAjax = new Ajax();
      objAjax.setSyn();
      objAjax.setPostMethod();
      objAjax.setUrl("http://memcakesandcookies/controlpanel/Cursos/php/Database/RequestFromWeb.php");
      var paramsRequest = {};
      paramsRequest.command = <?php print("\"".$COMMAND_INSERT."\"");?>;
      paramsRequest.paramsCommand = {};
      paramsRequest.paramsCommand.Table = <?php print("\"".TB_Curso::TB_CursoTableC."\"");?>;
      paramsRequest.paramsCommand.<?php print($PARAM_DATA);?> = {};
      paramsRequest.paramsCommand.<?php print($PARAM_DATA);?>.
                           <?php print TB_Curso::NameColumnC?> = nameCurse;
      paramsRequest.paramsCommand.<?php print($PARAM_DATA);?>.
                           <?php print TB_Curso::DescriptionColumnC?> = descCurse;
      paramsRequest.paramsCommand.<?php print($PARAM_DATA);?>.
                           <?php print TB_Curso::ImageColumnC?> = imageUrl;
      paramsRequest.paramsCommand.<?php print($PARAM_DATA);?>.
                           <?php print TB_Curso::DurationColumnC?> = durationCurse;   
      paramsRequest.paramsCommand.<?php print($PARAM_DATA);?>.
                           <?php print TB_Curso::PriceColumnC?> = priceCurse;                           
      paramsRequest.paramsCommand.<?php print($PARAM_DATA);?>.
                           <?php print TB_Curso::LevelIdColumnC?> = dificultadCurseId;                           
      paramsRequest.paramsCommand.<?php print($PARAM_DATA);?>.
                           <?php print TB_Curso::LevelColumnC?> = dificultadCurse;                           
            

      JSLogger.getInstance().debug("Trying create curse with theses parameters [ " +
            JSON.stringify(paramsRequest) +" ]");

      objAjax.setParameters(JSON.stringify(paramsRequest));
      objAjax.send();
      JSLogger.getInstance().trace("Response [ " + objAjax.getResponse() + " ]");
      var objResponse = JSON.parse(objAjax.getResponse());
      if (parseInt(objResponse['ResultCode']) != 200){
          MessageBox("Error", 
                     "No se ha podido crear el curso. Error [ " +
                     objResponse['ErrorMsg'] + " ]",
                     {Icon: MessageBox.IconsE.ERROR});
      }else{
         //Refresh the grid with the new data
         var newGridRow = $('<div class="class-grid-row"></div>');
         
         var newId = parseInt(objResponse['lastID']);
         newGridRow.append('<div class="class-grid-row-key">'+newId+'</div>');
         newGridRow.append('<div class="class-grid-row-data">'+nameCurse+'</div>');
         newGridRow.append('<div class="class-grid-row-data">'+dificultadCurse+'</div>');
         newGridRow.append('<div class="class-grid-row-data">'+priceCurse+'</div>');
         newGridRow.append('<div class="class-grid-row-hidden-data">'+descCurse+'</div>');
         newGridRow.append('<div class="class-grid-row-hidden-data">'+imageUrl+'</div>');
         $('#grid-cursos').append(newGridRow);
         formatDataGrid();
      }
      JSLogger.getInstance().traceExit();
   }
            
   $('#btnNew').click(function(){
       
       DataEntryForm.show({html_Id:"frmCurse",
                          Appearance:{Title_Params:{Title:"Nuevo Curso",
                                             Background_Color:"orange"}
                                       ,Size:{Width: 520}
                                       ,Window_Params:{Background_Color:"white",
                                                       Label_Font_Color: "#ce5c00",
                                                       Input_Font_Color: "#7D5F3F"}
                                       ,Buttons:{Background_Color:"orange"}
                                       ,Callbacks: {Callback_OK: createCurse}
                                     }
                           });
      
   });

   $('#btnEdit').click(function(){
         MessageBox("¿Borrar fichero?", 
               "¿Borrar el fichero?",
               {Buttons: {Buttons: MessageBox.ButtonsE.YES_NO_CANCEL,
                  Callback_Yes: function(){alert('YES');},
                  Callback_No: function(){alert('NO');}},
                Icon: MessageBox.IconsE.QUESTION});
   });

    

   $('#image-preview').click(function(){
      <?php 
      $url = $tbConfiguration->getValue();
      $tbConfiguration->rewind();
      $tbConfiguration->searchByKey('Path');
      ?>
      function callbackFileBrowserImage(dataCallback){
         $('#image-preview').empty();
         $('#image-preview').append('<img src="<?php printf("%s/%s",$url, $tbConfiguration->getValue());?>/'+dataCallback.path+'">');
         //console.debug('<img src="<?php printf("%s/%s",$url,$tbConfiguration->getValue());?>/'+dataCallback.path+'">');
      }
      fileBrowserImage = new FileBrowser({path:{root_path:
               <?php printf("\"%s/%s\"",$_SERVER['DOCUMENT_ROOT'],
                              $tbConfiguration->getValue());
               ?>,
               },
               type: "a", filter: "*.*",
               Title_Params:{
                  Caption:"Selecciona una imagen ...",
                  Background_Color:"orange"},
               callback:callbackFileBrowserImage,
               toolbar:"upload_file|create_folder|delete"
                  });
      //ileBrowserImage.show();
     
                  

   });
     
      
   
</script>