<div id="toolbar_images">
   
   <button id="BtnFileBrowser">Seleccionar Imagen</button>
              <script type="text/javascript" >
                 $('#BtnFileBrowser').click(function(){

                    callbackFunction = function (){

                       refresAllImages($('#comboCollection').val(),<?php printf("'%s'", $_GET['option']);?>);
                    };
                    
                    var path = "images/" + <?php printf("\"%s\"",strtolower($_GET['option']));?>;
                    FileBrowser.init({title: <?php printf("\"%s\"",$_GET['option']);?>+" / "+$('#comboCollection>option:selected').text(),
                        buttons: "upload|select|delete",
                        pathUploadFile: path,
                        color_selected_file: "orange",
                        server_type: "Database",
                        custom_params: {option:<?php printf("\"%s\"",$_GET['option']);?>,
                                        collection:$('#comboCollection>option:selected').text(),
                                        collectionId: $('#comboCollection>option:selected').val()},
                                        callback: callbackFunction});
                    FileBrowser.show();
                 }
                 );
              </script>
   
   <!--   <button id="btn_all_images_add">Subir foto</button> -->
   <button id="btn_all_images_edit">Modificar Descripcion</button>
   <button id="btn_all_images_delete">Borrar</button>
   
   <script type="text/javascript" >
      
      if(parseInt($('#comboCollection').val()) == 0){
         $('#BtnFileBrowser').hide();
      }
   </script>
</div>

<div id="images_list">

</div>
<script type="text/javascript" >
   refresAllImages($('#comboCollection').val(),<?php printf("'%s'", $_GET['option']);?>);
</script>