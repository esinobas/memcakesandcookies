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
   //Global variables
   var stepSavedM = true;
   var stepModifiedM = false;
   /****** Add functionality to the toolbar buttons ********/
   
   /**
    * It saves the step data in the data base
    */
   function saveStepInDDBB(){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().traceExit();
   }
   /**
    * It sets up the new step data and it shows then by screeen
    */  
   function setUpTheNewStep(){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().traceExit();
   }
    
   /*** New step button ***/
   $('#button-new-curse').click(function(){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Step saved [ " + (stepSavedM ? "TRUE":"FALSE") +" ]. Step modified [ " + (stepModifiedM ? "TRUE":"FALSE") +" ]");
      if (!stepSavedM && stepModifiedM){
         MessageBox("Advertencia", 
               "El paso no se ha guardado, ¿quieres guardarlo ahora?",
               {Icon: MessageBox.IconsE.QUESTION,
                Buttons: {Buttons: MessageBox.ButtonsE.YES_NO, 
                          Callback_Yes: saveStepInDDBB,
                          Callback_No: setUpTheNewStep}
                });
          
      }
      if (!stepSavedM && !stepModifiedM){
         JSLogger.getInstance().traceExit();
         return 0;
      }
      stepSavedM = false;
      stepModifiedM = false;
      $('.step-data').hide();
      //Remove the news object if these exist
      $('#new-title-step, #new-html-step').remove();
      //Add the div where for the step tittle
      var newStep = "<div class=\"step-data\"><div class=\"step-title\" id=\"new-title-step\">"
      newStep +="Pulsa para escribir el titulo</div>";
      newStep += "<div class=\"step-html\" id=\"new-html-step\">Pulsa para escribir las instrucciones";
      newStep += "</div></div>";
      //JSLogger.getInstance().trace("Add [ " + newStep + " ]");
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
         toolbar: "bold italic underline | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify "
      });
      tinymce.init({
         selector: "#new-html-step",
         theme: "modern",
         inline: true,
         statusbar: false,
         add_unload_trigger: false,
         schema: "html5",
         language: "es",
         plugins: "textcolor advlist image link lists",
         menubar: false,
         toolbar1: "formatselect | undo redo | bold italic underline | fontselect fontsizeselect | forecolor backcolor",
         toolbar2: "alignleft aligncenter alignright alignjustify | outdent indent | bullist numlist | cut copy paste | image link",
         file_browser_callback: function (field_name, url, type, win) {
            /*** function callback that show a file browser where the user select a image ***/
            JSLogger.getInstance().traceEnter();
            JSLogger.getInstance().trace("field name [ " + field_name + " ] url [ " + url + " ]. type [ " + type + " ]");

            function callbackTinyMCEFileBrowser(dataCallback){
               JSLogger.getInstance().traceEnter();
               JSLogger.getInstance().trace("Path in callback [ " + dataCallback.path +" ]");
               JSLogger.getInstance().trace("Complete url [ " + <?php printf("'%s/%s'",$url, $pathCurses);?>+'/'+dataCallback.path +" ]");
               //win.document.getElementById(field_name).value = 'my browser value';
               $('#'+field_name).val(<?php printf("'%s/%s'",$url, $pathCurses);?>+'/'+dataCallback.path);
               JSLogger.getInstance().traceExit(); 
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
                  callback: callbackTinyMCEFileBrowser,
                  toolbar:"upload_file|create_folder|delete"
                  });
            
            JSLogger.getInstance().traceExit();
         }
      });

      /** Add the onchange event **/
      $('#new-html-step, #new-title-step').keypress(function(){
         //JSLogger.getInstance().traceEnter();
         stepSavedM = false;
         stepModifiedM = true;
         //JSLogger.getInstance().traceExit();
      });
      
      JSLogger.getInstance().traceExit();
   });
   /*** Add functionality to the save curse ***/
   $('#button-save-curse').click(function(){
      JSLogger.getInstance().traceEnter();
      stepSavedM = false;
      stepModifiedM = false;
      JSLogger.getInstance().traceExit();
   });
</script>
