<?php 
   include_once 'Database/TB_Curso.php';
   include_once 'Database/TB_Level.php'
?>
<div class="data-container">
   <div class="toolbar">
      <div class="toolbar-bottom" id="btnNew">
         <img src="./icons/page_add.png">Nuevo
      </div>
      <div class="toolbar-bottom">
         <img src="./icons/page_edit.png">Abrir
      </div>
      <div class="toolbar-bottom">
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
         <div class="new-row"></div>
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
         }
         
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
            
         }
         var gridOnDoubleClick = function (theIndex){
            
         }
         DataGrid({divId: "grid-cursos",size:{width: 490, height: 490},
                                    columns_size:{0:300,1:94,2:65},
                     show_lines:"vertical",
                     click_callback: gridOnClick,
                     double_click_callback: gridOnDoubleClick});
           
        
         
      </script>
</div> <!-- div #data-container -->
         
<form id="frmEntryData" action="" >
<!--  The next div must be hidden. It is showed by in plugin -->
<div id="frmCurse" class="Data-Entry-Form">
   <div class="Data-Entry-Form-Data">
      <div class="Data-Entry-Form-Data-Label">Nombre:</div>
      <div class="Data-Entry-Form-Data-Value">
         <input type="text" id="input-curse-name" form="frmEntryData" maxlength="50">
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
         <select id="frmDificultad" name="Dificultad" form="frmEntryData">
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
   </div>
   <div class="Data-Entry-Form-Data">
      <div class="Data-Entry-Form-Data-Label">Precio:</div>
      <div class="Data-Entry-Form-Data-Value">
         <input type="number" id="input-price" >
      </div>
      
   </div>
   <div class="Data-Entry-Form-Data">
      <div class="Data-Entry-Form-Data-Label">Portada:</div>
      <div class="Data-Entry-Form-Data_Value" id="image-preview">
         <div>
         Pulsa para selecionar una imagen
         </div>
      </div>
     
   </div>
</div>
</form>