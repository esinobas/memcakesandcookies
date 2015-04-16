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
   var newStepM = true;
   /****** Add functionality to the toolbar buttons ********/
   /*********************************************************/
   /**
    * It saves the step data in the data base
    */
   function saveStepInDDBB(){
      JSLogger.getInstance().traceEnter();
      
      JSLogger.getInstance().trace("Trying " + (newStepM?"INSERT":"UPDATE") +
                    " in the data base the step with the following data: "+
                    "Curse key [ " + <?php print ($curseKey);?> + " ] " +
                    (newStepM?"":"Step key [ TEMPORAL ] ")+ 
                    "Title [ " + (newStepM?$('#new-title-step').html():"TEMPORAL") +
                     " ]. Step [ " + (newStepM?$('#new-html-step').html():"TEMPORAL")+
                      " ]");

      //Create the ajax object to send the step data to the server with the data base
      var ajaxObject = new Ajax()
      ajaxObject.setSyn();
      ajaxObject.setPostMethod();
      ajaxObject.setUrl(<?php printf("\"%s\"",$tbConfiguration->getValue());?>+"/controlpanel/Cursos/php/Database/RequestFromWeb.php");
      var paramsRequest = {};
      paramsRequest.command = (newStepM?<?php print("\"".$COMMAND_INSERT."\"");?>:<?php print("\"".$COMMAND_UPDATE."\"");?>);
      paramsRequest.paramsCommand = {};
      paramsRequest.paramsCommand.Table = <?php print("\"".TB_Curse_Step::TB_Curse_StepTableC."\"");?>;
      paramsRequest.paramsCommand.<?php print($PARAM_ROWS);?> = {};
      paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_ROWS,$PARAM_ROW);?> = {};
      if (!newStepM){
         paramsRequest.paramsCommand.<?php printf("%s.%s.%s",$PARAM_ROWS,$PARAM_ROW, $PARAM_KEY);?> = "Por definir";
      }
      paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW).
                  print(TB_Curse_Step::TitleColumnC);?> = (newStepM?$('#new-title-step').html():"TEMPORAL");
      paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW).
                  print(TB_Curse_Step::HtmlColumnC);?> = (newStepM?$('#new-html-step').html():"TEMPORAL");
      paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW).
                 print(TB_Curse_Step::Curse_IdColumnC);?> = <?php print ($curseKey);?>; 
      paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW).
                  print(TB_Curse_Step::CurseNameColumnC);?> = $('#data-curse-name').val();
      paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW).
                  print(TB_Curse_Step::CurseDescriptionColumnC);?>= $('#data-curse-desc').val();
      paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW).
                  print(TB_Curse_Step::CurseDurationColumnC);?> = $('#data-curse-duration').val();
      paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW).
                  print(TB_Curse_Step::CursePriceColumnC);?> = $('#data-curse-price').val();
      paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW).
                  print(TB_Curse_Step::CurseLevelIdColumnC);?> = $('#data-curse-level').val();
      paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW).
                  print(TB_Curse_Step::CurseLevelColumnC);?> =
                             $('#data-curse-level option:selected').text();
      paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW).
                   print(TB_Curse_Step::CursePublicColumnC);?> =
                               ($('#data-curse-public').prop("checked") == false ? 0 : 1);
      paramsRequest.paramsCommand.<?php printf("%s.%s.",$PARAM_ROWS,$PARAM_ROW).
                   print(TB_Curse_Step::CurseImageColumnC);?> =
                               $('#CurseImage').prop("src");
      JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(paramsRequest) +" ]");
      JSLogger.getInstance().traceExit();
   }
   /**************************************************************************/
   /**
    * It sets up the new step data and it shows then by screeen
    */  
   function setUpTheNewStep(){
      JSLogger.getInstance().traceEnter();
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
      /**********************************************************************/
      /**
       * Keypress event that is launched when a key is pressed in the new html step
       * or in the step tittle.
       */
      /** Add the onchange event **/
      $('#new-html-step, #new-title-step').keypress(function(){
         //JSLogger.getInstance().traceEnter();
         stepSavedM = false;
         stepModifiedM = true;
         //JSLogger.getInstance().traceExit();
      });
      
      JSLogger.getInstance().traceExit();
   }
   /*******************************************************************/ 
   /*** New step button ***/
   /**
    * Click event that is triggered when the new step button is pressed.
    */
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
          
      }else{
         setUpTheNewStep();
      }
      if (!stepSavedM && !stepModifiedM){
         JSLogger.getInstance().traceExit();
         return 0;
      }
            
      JSLogger.getInstance().traceExit();
   });
   /*************************************************************************************/
   /*** Add functionality to the save curse ***/
   /**
    * Click event that is launched when the save button is pressed
   */
   $('#button-save-curse').click(function(){
      JSLogger.getInstance().traceEnter();
      stepSavedM = false;
      stepModifiedM = false;
      saveStepInDDBB();
      JSLogger.getInstance().traceExit();
   });
</script>
