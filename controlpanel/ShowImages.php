<div id="toolbar_images">
   <!--   <button id="btn_all_images_add">Subir foto</button> -->
   <button id="btn_all_images_edit">Modificar Descripcion</button>
   <button id="btn_all_images_delete">Borrar</button>
</div>

<div id="images_list">

</div>
<script type="text/javascript" >
   refresAllImages($('#comboCollection').val(),<?php printf("'%s'", $_GET['option']);?>);
</script>