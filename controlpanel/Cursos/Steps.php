<?php
   /**
    * This file contains the code htlm (php) for desing the web part where
    * the curse steps are handled.
    */
?>
<div id="steps-data">

   <div id="steps-list">
      Pasos del curso
   </div>
   <div id="step-work">
      <div id="step-toolbar">
         <ul>
            <li>
               <button type="button" id="button-new-curse" title="Nuevo">
                  <img src="./icons/page_white.png">
               </button>
            </li>
            <li>
               <button type="button" id="button-save-curse" title="Guardar">
                  <img src="./icons/disk.png">
               </button>
             </li>
            <li>
               <button type="button" id="button-remove-curse" title="Borrar">
                  Borrar
               </button>
            </li>
            <li>
               <button type="button" id="button-preview-curse" title="Preview">
                  Preview
               </button>
            </li>
         </ul>
      </div>
      <div id="step">
      </div>
   </div>
</div>
<script type="text/javascript">
   JSLogger.getInstance().registerLogger("Steps.php",JSLogger.levelsE.TRACE);
   /****** Add functionality to the toolbar buttons ********/
   /*** New step button ***/
   $('#button-new-curse').click(function(){
      JSLogger.getInstance().traceEnter();
      
      $('.step-data').hide();
      //Add the div where for the step tittle
      var newStep = "<div class=\"step-data\"><div class=\"step-title\" id=\"new-title-step\">"
      newStep +="Pulsa para escribir el titulo</div>";
      newStep += "<div class=\"step-html\" id=\"new-html-step\">Pulsa para escribir las instrucciones";
      newStep += "</div></div>";
      JSLogger.getInstance().trace("Add [ " + newStep + " ]");
      $('#step').append(newStep);
      //Add the TinyMCE plugin to the elements
      tinymce.init({
         selector: "#new-title-step",
         theme: "modern",
         inline: true,
         statusbar: false,
         add_unload_trigger: false,
         schema: "html5",
         language: "es",
         plugins: "textcolor",
         menubar: false,
         toolbar: "bold italic underline | forecolor backcolor | fontselect fontsizeselect | alignleft aligncenter alignright alignjustify "
      });
      JSLogger.getInstance().traceExit();
   });
</script>
