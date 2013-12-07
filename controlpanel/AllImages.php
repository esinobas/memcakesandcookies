<div id="toolbar_all_images">
   <button id="btn_all_images_add">Subir foto</button>
   <button id="btn_all_images_edit">Modificar Descripcion</button>
   <button id="btn_all_images_delete">Borrar</button>
</div>

<div id="gallery_all_image">

</div>
<script type="text/javascript" >
   refresAllImages(<?php printf("'%s'", $_GET['option']);?>);
</script>