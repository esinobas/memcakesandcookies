<?php 
   include_once 'Database/TB_Curso.php';
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
            <div class="class-grid-row-hidden-data"><?php print($tableCurses->getDescription());?></div>
            <div class="class-grid-row-hidden-data"><?php print($tableCurses->getPrice());?></div>
         </div>
         <div class="new-row"></div>
         <?php
            }
         ?>
      </div>
      <script type="text/javascript">
           var gridOnClick = function (theIndex){
              
           }
           var gridOnDoubleClick = function (theIndex){
              
           }
           DataGrid({divId: "grid-cursos",size:{width: 490, height: 490},
                                      columns_size:{0:355,1:110},
                     show_lines:"vertical",
                     click_callback: gridOnClick,
                     double_click_callback: gridOnDoubleClick});
           
        
         
      </script>
   </div>
   <div id="div-description-cursos">
   </div>
</div>