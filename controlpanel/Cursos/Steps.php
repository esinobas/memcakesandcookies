<?php
   /**
    * This file contains the code htlm (php) for desing the web part where
    * the curse steps are handled.
    */
?>
<script type="text/javascript">
   JSLogger.getInstance().registerLogger("Steps.php",JSLogger.levelsE.TRACE);
</script>
<div id="steps-data">
   <?php 
      $tbCurseStep->rewind();
   ?>
   <div id="steps-list">
      Pasos del curso
      <ul id="List-Curse-Index">
      <?php 
         while ($tbCurseStep->next()){
            $title = new DOMDocument();
            $title->loadHTML($tbCurseStep->getTitle());
      ?>
         <li id=<?php printf("\"Curse-Index-%s\"",$tbCurseStep->getId());?> class="Curse-Index">
            <a href=<?php printf("\"#Step-Id-%d\"", $tbCurseStep->getId());?>>
               <?php printf("%s\n",$title->textContent);?>
            </a>
         </li>
      <?php
         }
      ?>
      </ul>
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
                  <img src="./icons/delete.png" height="16" width="16">
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
      <?php 
         $tbCurseStep->rewind();
         while ($tbCurseStep->next()){
      ?>
            <div id=<?php printf("\"Step-Id-%d\"", $tbCurseStep->getId());?> class="step-data">
               <div class="step-title">
                  <?php printf("%s\n", $tbCurseStep->getTitle());?>
               </div>
               <div class="step-html">
                  <?php printf("%s\n", $tbCurseStep->getHtml());?>
               </div>
            </div>
      <?php
         }
      ?>
      </div>
   </div>

</div>
<script type="text/javascript">
   //JSLogger.getInstance().registerLogger("Steps.php",JSLogger.levelsE.TRACE);
   //Global variables
   var stepSavedM = true;
   var stepModifiedM = false;
   var newStepM = false;
   /****** Add functionality to the toolbar buttons ********/
   
   /*****************************************************************/
   /**
    * It prepares the parameters when the step is new and it is added
    * in the data base
    */
   function insertionParameters( theTitle, theHtml, theCurseKey, theCurseName, 
                                    theCurseDesc,
                                    theCurseDuration, theCursePrice,
                                    theCurseLevelId, theCurseLevel,
                                    theCursePublic, theCurseImage){
      JSLogger.getInstance().traceEnter();
      var paramsRequest = {};
      paramsRequest.command = <?php print("\"".$COMMAND_INSERT."\"");?>;
      paramsRequest.paramsCommand = {};
      paramsRequest.paramsCommand.Table = <?php print("\"".TB_Curse_Step::TB_Curse_StepTableC."\"");?>;
      paramsRequest.paramsCommand.<?php print($PARAM_DATA);?> = {};
      paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_DATA,
                             TB_Curse_Step::TitleColumnC);?> = theTitle;
      paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_DATA,
                              TB_Curse_Step::HtmlColumnC);?> = theHtml;
      paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_DATA,
                  TB_Curse_Step::Curse_IdColumnC);?> = theCurseKey
      paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_DATA,
                  TB_Curse_Step::CurseNameColumnC);?> = theCurseName;
      paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_DATA,
                  TB_Curse_Step::CurseDescriptionColumnC);?> = theCurseDesc;
      paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_DATA,
                  TB_Curse_Step::CurseDurationColumnC);?> = theCurseDuration;
      paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_DATA,
                  TB_Curse_Step::CursePriceColumnC);?> = theCursePrice;
      paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_DATA,
                  TB_Curse_Step::CurseLevelIdColumnC);?> = theCurseLevelId;
      paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_DATA,
                   TB_Curse_Step::CurseLevelColumnC);?> = theCurseLevel;
      paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_DATA,
                  TB_Curse_Step::CursePublicColumnC);?> = theCursePublic;
      paramsRequest.paramsCommand.<?php printf("%s.%s",$PARAM_DATA,
                  TB_Curse_Step::CurseImageColumnC);?> = theCurseImage;
      JSLogger.getInstance().traceExit();
      return paramsRequest;
   }

   /*****************************************************************/
   /**
     * Refresh the index steps adding a new step
     *
     * @param theStepId
     * @param theTitle
     * @param theHtml
     */
   function refreshAddingStep(theStepId, theTitle, theHtml){
      JSLogger.getInstance().traceEnter();
      $('#new-title-step').remove();
      $('#new-html-step').remove();
      $('.Curse-Index').removeClass('Selected-Curse-Index');
      var temporal = $(theTitle);
      var newIndexStep = $('<li>'+temporal.last().html()+'</li>');
      newIndexStep.attr('id', 'Curse-Index-'+theStepId);
      newIndexStep.addClass('Curse-Index');
      newIndexStep.addClass('Selected-Curse-Index');
      $('#List-Curse-Index').append(newIndexStep);
      var stepData = $('<div></div>');
      stepData.addClass('step-data');
      stepData.attr('id','Step-Id-'+theStepId);
      var stepTitle = $('<div></div>');
      stepTitle.addClass('step-title');
      stepTitle.append(theTitle);
      stepData.append(stepTitle);
      var stepHtml = $('<div></div>');
      stepHtml.addClass('step-html');
      stepHtml.append(theHtml);
      stepData.append(stepHtml);
      JSLogger.getInstance().traceExit();
   }
   /****************************************************************/
   /**
    * Refreshs the index after remove a step
    *
    */
   function refreshAfterDeleteStep(){
      JSLogger.getInstance().traceEnter();
      
      var dataStep = $('.Selected-Curse-Index').find('a').attr('href');
      $(dataStep).remove();
      $('.Selected-Curse-Index').remove();
      $('.Curse-Index:first').addClass('Selected-Curse-Index');
      $('.step-data').hide();
      $('.step-data:first').show();
      
      JSLogger.getInstance().traceExit();
   }
   /************************************************************************/
   /**
    * It removes the step from the data base
    */
   function removeStepInDDBB(){
      JSLogger.getInstance().traceEnter();
      var stepId = $('.Selected-Curse-Index').attr('id').split('-')[2];
      JSLogger.getInstance().trace('Trying remove step with id [ ' + stepId + 
            ' ]');
     //Create the ajax object to send the remove step data to the server with the data base
      var ajaxObject = new Ajax()
      ajaxObject.setSyn();
      ajaxObject.setPostMethod();
      <?php
         $tbConfiguration->rewind();
         $tbConfiguration->searchByKey('URL');
      ?>
      JSLogger.getInstance().trace("Url wehere send the request: " + <?php
                     printf("\"%s\"",$tbConfiguration->getValue());?>+
               "/controlpanel/Cursos/php/Database/RequestFromWeb.php");
      ajaxObject.setUrl(<?php printf("\"%s\"",$tbConfiguration->getValue());?>+"/controlpanel/Cursos/php/Database/RequestFromWeb.php");
      var paramsRequest = {};

      paramsRequest.command = <?php print("\"".$COMMAND_DELETE."\"");?>;
      paramsRequest.paramsCommand = {};
      paramsRequest.paramsCommand.Table = <?php print("\"".TB_Curse_Step::TB_Curse_StepTableC."\"");?>;
      paramsRequest.paramsCommand.<?php print($PARAM_DATA);?> = {};
      paramsRequest.paramsCommand.<?php print($PARAM_DATA);?>.<?php print($PARAM_KEY);?> = {};
      paramsRequest.paramsCommand.<?php printf("%s.%s.%s",$PARAM_DATA,$PARAM_KEY,TB_Curse_Step::IdColumnC);?> = stepId; 
      
      JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(paramsRequest) +" ]");

      ajaxObject.setParameters(JSON.stringify(paramsRequest));
      
      ajaxObject.send();
      JSLogger.getInstance().trace("Response [ " + ajaxObject.getResponse() + " ]");

      if (ajaxObject.getResponse().indexOf("404 Not Found") != -1){
         JSLogger.getInstance().error("The script [ " + url +
               " ] has been found");
         MessageBox("Error", 
               "El paso no se ha borrado"+
                 ". No se ha podido acceder al script en el servidor",
               {Icon: MessageBox.IconsE.ERROR});
      }else{
         var objResponse = JSON.parse(ajaxObject.getResponse());
         if (parseInt(objResponse['ResultCode']) != 200){
                  MessageBox("Error", 
                     "No se ha podido borrar "+ 
                     " el paso. Error [ " +
                     objResponse['ErrorMsg'] + " ]",
                     {Icon: MessageBox.IconsE.ERROR});
                JSLogger.getInstance().error("The step has been not delete. [ " +
                      objResponse['ErrorMsg'] + " ]");
         }else{
           
            JSLogger.getInstance().error("The step has been deleted sucessful");
            refreshAfterDeleteStep();
         }
      }
      JSLogger.getInstance().traceExit();
   }
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
      <?php
         $tbConfiguration->rewind();
         $tbConfiguration->searchByKey('URL');
      ?>
      JSLogger.getInstance().trace("Url wehere send the request: " + <?php
                     printf("\"%s\"",$tbConfiguration->getValue());?>+
               "/controlpanel/Cursos/php/Database/RequestFromWeb.php");
      ajaxObject.setUrl(<?php printf("\"%s\"",$tbConfiguration->getValue());?>+"/controlpanel/Cursos/php/Database/RequestFromWeb.php");
      var paramsRequest = null;
      if (newStepM){
        
         paramsRequest = insertionParameters($('#new-title-step').html(),
                                             $('#new-html-step').html(),
                                             <?php print ($curseKey);?>,
                                             $('#data-curse-name').val(),
                                             $('#data-curse-desc').val(),
                                             $('#data-curse-duration').val(),
                                             $('#data-curse-price').val(),
                                             $('#data-curse-level').val(),
                                             $('#data-curse-level option:selected').text(),
                                             ($('#data-curse-public').prop("checked") == false ? 0 : 1),
                                             $('#CurseImage').prop("src"));
                                             
      }else{
        //paramsRequest.paramsCommand.<?php //print($PARAM_ROWS);?> = {};
      }
      
      //if (!newStepM){
      //   paramsRequest.paramsCommand.<?php //printf("%s.%s",$PARAM_ROWS,$PARAM_ROW);?> = {};
      //   paramsRequest.paramsCommand.<?php //printf("%s.%s.%s",$PARAM_ROWS,$PARAM_ROW, $PARAM_KEY);?> = "Por definir";
      //}
      
                         
      JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(paramsRequest) +" ]");

      ajaxObject.setParameters(JSON.stringify(paramsRequest));
     
      ajaxObject.send();
      JSLogger.getInstance().trace("Response [ " + ajaxObject.getResponse() + " ]");

      if (ajaxObject.getResponse().indexOf("404 Not Found") != -1){
         JSLogger.getInstance().error("The script [ " + url +
               " ] has been found");
         MessageBox("Error", 
               "El paso no se ha "+(newStepM?"insertado":"modificado")+
                 ". No se ha podido acceder al script en el servidor",
               {Icon: MessageBox.IconsE.ERROR});
      }else{
         var objResponse = JSON.parse(ajaxObject.getResponse());
         if (parseInt(objResponse['ResultCode']) != 200){
                  MessageBox("Error", 
                     "No se ha podido "+(newStepM?"insertar":"modificadar")+ 
                     " el curso. Error [ " +
                     objResponse['ErrorMsg'] + " ]",
                     {Icon: MessageBox.IconsE.ERROR});
                JSLogger.getInstance().error("The curse has been not insert/update. [ " +
                      objResponse['ErrorMsg'] + " ]");
         }else{
           
            JSLogger.getInstance().error("The curse has been  insert/update sucessful");
            if ( newStepM ){
               
               refreshAddingStep(parseInt(objResponse['lastID']), 
                                          $('#new-title-step').html(),
                                          $('#new-html-step').html());
               newStepM = false;
               
            }
            
         }
      }
      
      JSLogger.getInstance().traceExit();
   }

   /**********************************************************************/
   /**
    * Add the Tinymce to the title and the html step
    *
    * @param theTitleSelector: The title selector
    * @param theHtmlStepSelector: The Html Step selector
    */
   function applyTinymce(theTitleSelector, theHtlmlSelector){
      JSLogger.getInstance().traceEnter();
      tinymce.init({
         selector: theTitleSelector,
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
         selector: theHtlmlSelector,
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
      newStepM = true;
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
      applyTinymce("#new-title-step","#new-html-step");
      
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
   /***************   Selected and show the first step ******************/
   $('.Curse-Index:first').addClass('Selected-Curse-Index');
   $('.step-data').hide();
   $('.step-data:first').show();
   /***************************** Add the event click to all curses index *******************/
   $('.Curse-Index').click(function(){
      $('.Curse-Index').removeClass('Selected-Curse-Index');
      $(this).addClass('Selected-Curse-Index');
      $('.step-data').hide();
      var selectedStep = $(this).find('a').attr('href');
      $(selectedStep).show();
   });

    
   
   /*************************************************************/
   /*** Add the functionality to the remove button ***/
   /**
    * 
    */
   $('#button-remove-curse').click(function(){
      JSLogger.getInstance().traceEnter();
      var stepIdSelected = $('.Selected-Curse-Index').attr('id').split('-')[2];
      var temporal = $($('.Selected-Curse-Index a').attr('href')).find('.step-title');
      
      var stepTitle = $('.Selected-Curse-Index a').last().html(); 
      JSLogger.getInstance().debug('Trying remove step with id [ ' +
               stepIdSelected + ' ] and name [ ' + stepTitle.trim() + ' ]');

      MessageBox("Borrar paso de curso", 
            "¿Quieres borrar el paso \""+stepTitle.trim()+"\"?",
            {Icon: MessageBox.IconsE.QUESTION,
             Buttons: {Buttons: MessageBox.ButtonsE.YES_NO, 
                         Callback_Yes: removeStepInDDBB
                       }
             });
      JSLogger.getInstance().traceExit();
   });
     
   /*******  Add the Tinymce funcionality to all the titles and html steps ****/
   applyTinymce(".step-title",".step-html");
</script>
