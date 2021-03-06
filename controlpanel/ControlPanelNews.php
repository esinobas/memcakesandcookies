<?php
/**
 * Abstract class with the static functions to management the page web news
 */

/** Includes **/

class ControlPanelNews{
   
   /** Private static properties **/
   
   /**
    * Object that allows write the log in a file
    * @var Logger
    */
   static private $loggerM = null;
   
   /**
    * Variable whereis save the page url
    */
   static private $pageUrlM = "";
   
   /** Private static funcions **/
   
   /**
    * Returns the logger that allows write the log in a file
    * @return Logger
    */
   static private function getLogger(){
      
      if (self::$loggerM == null){
         self::$loggerM = LoggerMgr::Instance()->getLogger(basename(__CLASS__));
      }
      return self::$loggerM;
   }
   
   
   
   /**
    * Writes the javascript function to write (insert or update) the news in 
    * the database, sending the data throught a server
    */
   static private function writeJSFuncionSendNewsToServer(){
      self::getLogger()->trace("Enter");
?>
      <script type="text/javascript">

         function getTimeStampStr(){
            JSLogger.getInstance().traceEnter();
            var now = new Date();
            var timeStampStr = now.getFullYear()+ "-" +
                               ((now.getMonth()+1)<10?"0":"")+ parseInt(now.getMonth()+1) + "-" +
                               (now.getDate()<10?"0":"")+ now.getDate() + " " +
                               (now.getHours()<10?"0":"") + now.getHours() + ":"+
                               (now.getMinutes()<10?"0":"")+now.getMinutes() + ":"+
                               (now.getSeconds()<10?"0":"")+now.getSeconds();
            JSLogger.getInstance().trace("TimeStamp [ " + timeStampStr + " ]"); 
            JSLogger.getInstance().traceExit();
            return timeStampStr;
         }
         /**
          * Sends the news data to the server for write the news in the database
          */
         function sendNewsToServer(){
               JSLogger.getInstance().traceEnter();
               var newsId = $('.News:visible').attr('id');
               var isNew = (newsId.localeCompare('New-News-Container') == 0);
               JSLogger.getInstance().trace("The news is" +
                     (isNew == false ? " not":"") +" new.");

               if (isNew){
                  JSLogger.getInstance().trace("Add new news");
               }else{
                  JSLogger.getInstance().trace("Update news with id [ " + 
                           newsId +" ]");
               }
               var title = $('.News:visible .News-Title').html();
               var text = $('.News:visible .News-Text').html();
               JSLogger.getInstance().trace("News Title [ " +
                     title +" ] with text [ " + text + " ]");
               var ajaxObject = new Ajax();
               ajaxObject.setSyn();
               ajaxObject.setPostMethod();
               
               JSLogger.getInstance().debug("Url whete the data will be send [ " + imagesPaths[URL_C] 
                   +"php/Database/RequestFromWeb.php ]");
               ajaxObject.setUrl(imagesPaths[URL_C]+"php/Database/RequestFromWeb.php");
               var requestParams = {};
               if (isNew){
                  requestParams.<?php print(COMMAND);?> = <?php print("\"".COMMAND_INSERT."\"");?>;
               }else{
                  requestParams.<?php print(COMMAND);?> = "<?php print(COMMAND_UPDATE);?>";
               }
               requestParams.<?php print(PARAMS);?> = {};
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = 
                              "<?php print(TB_News::TB_NewsTableC);?>";

               if (isNew){
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_News::TitleColumnC);?> = encodeURIComponent(title.replace(/\"/g,"\\\"")); 
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_News::NewColumnC);?> = encodeURIComponent(text.replace(/\"/g,"\\\""));  
               }else{
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?> = {};
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW)?> = {};
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW)?>.<?php print(PARAM_KEY);?> = parseInt(newsId.substring(5));
                
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW)?>.<?php print(TB_News::TitleColumnC);?> = encodeURIComponent(title.replace(/\"/g,"\\\"")); 
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW)?>.<?php print(TB_News::NewColumnC);?> = encodeURIComponent(text.replace(/\"/g,"\\\"")); 
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW)?>.<?php print(TB_News::phisicalTB_NewsDateTimeColumnC);?> = getTimeStampStr();
               }

               JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

               ajaxObject.setParameters(JSON.stringify(requestParams));

               ajaxObject.send();
               JSLogger.getInstance().trace("Response [ " + ajaxObject.getResponse() + " ]");

               if (ajaxObject.getResponse().indexOf("404 Not Found") != -1){
                  JSLogger.getInstance().error("The script [ " +imagesPaths[URL_C] +
                     "/php/Database/RequestFromWeb.php ] has been found");
                  MessageBox("Error", 
                      (isNew ? "No se ha podido crear. ":
                         "No se ha podido modificar. ")+"No se ha accedido al servidor",
                     {Icon: MessageBox.IconsE.ERROR});
               }else{
                  var objResponse = JSON.parse(ajaxObject.getResponse());
                  if (parseInt(objResponse['ResultCode']) != 200){
                        MessageBox("Error", 
                              (isNew ? "No se ha podido crear. ":
                              "No se ha podido modificar. ")+" Error [ " +
                           objResponse['ErrorMsg'] + " ]",
                           {Icon: MessageBox.IconsE.ERROR});
                        JSLogger.getInstance().error("The news has not been updated. [ " +
                            objResponse['ErrorMsg'] + " ]");
                  }else{
                     
                     JSLogger.getInstance().trace("The news has been updated");
                     if(isNew){
                        var id = objResponse['lastID'];
                        
                        JSLogger.getInstance().trace("The new news has the id [ " + id +" ]");
                        $('#Listbox-News').prepend('<div id="ListboxItem-News-'+
                              id+'" class="ListboxItem">'+title+'</div>');
                        $('#ListboxItem-News-'+id).addClass('ListBoxItemSelected');
                        var newsContainer = $('#New-News-Container').clone();
                        
                        newsContainer.attr('id', 'News-'+id);
                        $('#Container-News').append(newsContainer);
                        JSLogger.getInstance().trace("The newsContainer Id [ " + 
                              newsContainer.attr('id') + " ]");
                        $('#New-News-Container').remove();
                        $('#ListboxItem-News-'+id).click(function(){
                           JSLogger.getInstance().traceEnter();
                           
                           $(this).parent().find('.ListBoxItem').removeClass('ListBoxItemSelected');
                           //$(this).addClass('ListboxItemSelected');
                           $('#ListboxItem-News-'+id).addClass('ListBoxItemSelected');
                           $('.News').addClass("News-Hidden");
                           $('#News-'+id).removeClass("News-Hidden");
                           JSLogger.getInstance().traceExit();
                        });
                     }else{
                        var newsCloned = $('#Listbox-News').find('.ListBoxItemSelected').clone(true);
                        JSLogger.getInstance().trace("Cloned Id [ " + newsCloned.attr('id') + " ]");
                        JSLogger.getInstance().trace("Remove [ ListboxItem-" + newsId + " ]");
                        $('#Listbox-News').find('#ListboxItem-' + newsId).remove();
                        $('#Listbox-News').prepend(newsCloned);
                        
                     }
                  }
               }
                              
               JSLogger.getInstance().traceExit();
         }
      </script>
<?php 
      self::getLogger()->trace("Exit");
   }
   
   /**
    * Writes the Javascript fuction to add click event to the save button
    */
   static private function writeJSFunctionAddClickEventSaveButton(){
      self::getLogger()->trace("Enter");
      self::writeJSFuncionSendNewsToServer();
      
?>
      <script type="text/javascript">
         $('#Save-News').click(sendNewsToServer);
      </script>
<?php 
      self::getLogger()->trace("Exit");
   }
   
   /**
    * Writes the javascript function apply the tinymce to the news title and 
    * news text
    */
   static private function writeJSFunctionApplyTinyMce(){
      self::getLogger()->trace("Enter");
?>
   <script type="text/javascript">
   
      /**
       * Declaration of the TinyMce image filebrowser callback
       *
       * @param theField: The field name where the image name must be added
       */
      function tinyMceImageCallback(theField){
         JSLogger.getInstance().traceEnter();
         
         /**
          * Declaration for the image filebrowser callback used in the plugin 
          * insert/update image of the TinyMCE
          *
          * @param theDataCallback:(Object type) It is the data returned in the callback
          */
         function tinyMceFilebrowserCallback(theDataCallback){
            JSLogger.getInstance().traceEnter();
            JSLogger.getInstance().trace("The image url is [ <?php print(self::getPageUrl());?>" +
                  theDataCallback.path + " ]");
            $('#'+theField).val("<?php print(self::getPageUrl());?>"+theDataCallback.path);
            JSLogger.getInstance().traceExit();
         }

         imageFileBrowser = new FileBrowser(
               {
                  path:{
                        root_path: "<?php print($_SERVER['DOCUMENT_ROOT']);?>"
                       },
                  type: "a",
                  filter: "*.*",
                  page_url: "<?php print(self::getPageUrl());?>",
                  Title_Params:{
                        Caption:"Selecciona una imagen ...",
                        Background_Color:"orange"
                        },
                  toolbar:"upload_file|create_folder|delete",
                  callback: tinyMceFilebrowserCallback
               } 
         );
         JSLogger.getInstance().traceExit();
      }
      /**
       * Add the Tinymce to the title and the html step
       *
       * @param theTitleSelector: The title selector
       * @param theTextSelector: The text selector
       */
      function applyTinymce (theTitleSelector, theTextSelector){
         JSLogger.getInstance().traceEnter();
         tinymce.init({
            selector: theTitleSelector,
            theme: "modern",
            inline: true,
            statusbar: false,
            entity_encoding : "raw",
            add_unload_trigger: false,
            schema: "html5",
            language: "es",
            //plugins: "textcolor",
            menubar: false,
            toolbar: false
            //toolbar: "bold italic underline | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify "
         });
         tinymce.init({
            selector: theTextSelector,
            theme: "modern",
            inline: true,
            statusbar: false,
            entity_encoding : "raw",
            add_unload_trigger: false,
            schema: "html5",
            language: "es",
            plugins: "textcolor advlist image imagetools link lists",
            menubar: false,
            //toolbar1: "formatselect | undo redo | bold italic underline | fontselect fontsizeselect | forecolor backcolor",
            toolbar1: "undo redo | bold italic underline | fontsizeselect | forecolor backcolor",
            toolbar2: "alignleft aligncenter alignright alignjustify | outdent indent | bullist numlist | cut copy paste | image link",
            file_browser_callback: function (field_name, url, type, win) {
               JSLogger.getInstance().traceEnter();
               tinyMceImageCallback(field_name);
               JSLogger.getInstance().traceExit();
            }
         });
         JSLogger.getInstance().traceExit();
      }
   </script>
<?php 
      self::getLogger()->trace("Exit");
   }
   
   /**
    * Writes the javascript function to add a click event to the new news button
    */
   static private function writeJSFunctionNewNewsButtonClickEvent(){
      self::getLogger()->trace("Enter");
?>
      <script type="text/javascript">
         /** 
          * Function that add in the window the controls to create a new news
          */
         function addNewNewsControl(){
            JSLogger.getInstance().traceEnter();
            $('.News').addClass('News-Hidden');
            var newContainerNews = $('<div class="News" id="New-News-Container"></div>');
            newContainerNews.append('<div class="News-Title">Pulsa para escribir el titulo</div>');
            newContainerNews.append('<div class="News-Text">Pulsa para escribir</div>');
            $('#Container-News').append(newContainerNews);
            applyTinymce('#New-News-Container .News-Title', '#New-News-Container .News-Text');
            $('#Listbox-News .ListboxItem').removeClass('ListBoxItemSelected');
            JSLogger.getInstance().traceExit();
         }

         $('#New-News').click(addNewNewsControl);
      </script>
<?php 
      self::getLogger()->trace("Exit");
   }
   /**
    * Writes the java script functions to remove a news 
    */
   static private function writeJSFunctionToRemoveAnNews(){
      
      self::getLogger()->trace("Enter");
?>
      <script type="text/javascript">
         /**
          * Callback function used when news want to be removed
         */
         function removeCallback(){
            JSLogger.getInstance().traceEnter();
            var newsId= $('#Listbox-News .ListBoxItemSelected').attr('id').substring(17);
            JSLogger.getInstance().trace("The news with id [ " + newsId + 
                           " ] will be removed");

            JSLogger.getInstance().trace("Create ajax object");
            var ajaxObject = new Ajax();
            ajaxObject.setSyn();
            ajaxObject.setPostMethod();
            
            JSLogger.getInstance().debug("Url whete the data will be send [ " + imagesPaths[URL_C] 
                +"php/Database/RequestFromWeb.php ]");
            ajaxObject.setUrl(imagesPaths[URL_C]+"php/Database/RequestFromWeb.php");
            var requestParams = {};
            requestParams.<?php print(COMMAND);?> = <?php print("\"".COMMAND_DELETE."\"");?>;
            requestParams.<?php print(PARAMS);?> = {};
            requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = "<?php print(TB_News::TB_NewsTableC);?>";
            requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
            requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_KEY);?> = newsId;

            JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

            ajaxObject.setParameters(JSON.stringify(requestParams));

            ajaxObject.send();
           
            JSLogger.getInstance().trace("Response [ " + ajaxObject.getResponse() + " ]");
            if (ajaxObject.getResponse().indexOf("404 Not Found") != -1){
               JSLogger.getInstance().error("The script [ " +imagesPaths[URL_C] +
                  "/php/Database/RequestFromWeb.php ] has been found");
               MessageBox("Error", 
                  "La noticia-entrada-blog no se ha podido borrar. No se ha accedido al servidor",
                  {Icon: MessageBox.IconsE.ERROR});
            }else{
               var objResponse = JSON.parse(ajaxObject.getResponse());
               if (parseInt(objResponse['ResultCode']) != 200){
                     MessageBox("Error", 
                        "La noticia-entrada-blog no se ha podido borrar. Error [ " +
                        objResponse['ErrorMsg'] + " ]",
                        {Icon: MessageBox.IconsE.ERROR});
                     JSLogger.getInstance().error("The news has not been removed. [ " +
                         objResponse['ErrorMsg'] + " ]");
               }else{
                  
                  JSLogger.getInstance().trace("The news has been removed");
                  $('#Listbox-News .ListBoxItemSelected').remove();
                  $('#Listbox-News .ListboxItem').first().addClass('ListBoxItemSelected');
                  $('#News-' + newsId).remove();
                  var id = $('#Listbox-News .ListBoxItemSelected').attr('id');
                   JSLogger.getInstance().trace("Id [ " + id + " ]");
                  $('#News-' + id.substring(17)).removeClass('News-Hidden');
               }
            }
            JSLogger.getInstance().traceExit();
         }

         /**
          * Shows a message box asking confirm for remove a news or not
          */
         function removeNews(){
            JSLogger.getInstance().traceEnter();
            var newsName = $('.News:visible .News-Title').html();
            MessageBox("Borrar", "¿Borrar noticia-entrada-blog \"" + 
                  newsName + "\" ?",
                 {Buttons:{Buttons: MessageBox.ButtonsE.YES_NO,
                           Callback_Yes: removeCallback},
                  Icon: MessageBox.IconsE.QUESTION});
            JSLogger.getInstance().traceExit();
         }
         $('#Delete-News').click(removeNews);
      </script>
      
<?php 
      
      self::getLogger()->trace("Exit");
   }
   
   /**
    * Returns the page url
    * @return string
    */
   static public function getPageUrl(){
      self::getLogger()->trace("Enter/Exit");
      return self::$pageUrlM;
   }
   
   /** Public functions **/
   
   /**
    * Writes the code html to show the News control
    */
   static public function showControlPanelNews(){
      self::getLogger()->trace("Enter");
      self::writeJSFunctionApplyTinyMce();
?>
      <div id="News-Toolbar">
         <div id="New-News" class="Round-Corners-Button">
            Nueva
         </div>
         <div id="Delete-News" class="Round-Corners-Button">
            Eliminar
         </div>
         <div id="Save-News" class="Round-Corners-Button">
            Guardar
         </div>
         </div>
      
      <div id="Container-Listbox-News">
         <div id="Listbox-News" class="Listbox">
         
         </div>
      </div>
      <div id="Container-News">
      </div>
      
<?php 
      self::getLogger()->trace("Open the TB_News and add the news in the controls");
      $tbNews = new TB_News();
      $tbNews->open();
      $isFirst = true;
      while ($tbNews->next()){
?>
         <script type="text/javascript">
            $('#Listbox-News').append('<div id="ListboxItem-News-<?php print($tbNews->getId());?>" class="ListboxItem"><?php print($tbNews->getTitle());?></div>');
            $('#Container-News').append('<div class="News <?php if (! $isFirst){print("News-Hidden");}?>" id="News-<?php print($tbNews->getId());?>"><div class="News-Title"><?php print($tbNews->getTitle());?></div><div class="News-Text"><?php print($tbNews->getNew());?></div></div>');
            applyTinymce('#News-<?php print($tbNews->getId());?> .News-Title', 
                          '#News-<?php print($tbNews->getId());?> .News-Text');
            //JSLogger.getIntance().trace("Time stamp [ <?php print ($tbNews->getDateTime());?> ]"); 
         </script>
<?php    
         if ($isFirst){
            $isFirst = false;
         }
      }
?>
      <script type="text/javascript">
         $('#Listbox-News .ListboxItem').each(function(){
            JSLogger.getInstance().traceEnter();
            $(this).click(function(){
               JSLogger.getInstance().traceEnter();
               JSLogger.getInstance().trace("News ListboxItem [ " + $(this).attr('id') +" ]");
               $('.News').addClass("News-Hidden");
               var newsId = $(this).attr('id').substring(17);
               JSLogger.getInstance().trace("News Id [ " + newsId + " ]");
               $('#News-'+newsId).removeClass("News-Hidden");
               JSLogger.getInstance().traceEnter();
            });
            JSLogger.getInstance().traceExit();
         });
      </script>
<?php 
      self::writeJSFunctionNewNewsButtonClickEvent();
      self::writeJSFunctionAddClickEventSaveButton();
      self::writeJSFunctionToRemoveAnNews();
      self::getLogger()->trace("Exit");
   }
   
   /**
    * Sets the page url to be used in the class functions
    * @param string $thePageURL
    */
   static public function setPageURL($thePageURL){
      self::getLogger()->trace("Enter");
      self::$pageUrlM = $thePageURL;
      self::getLogger()->trace("Exit");
   }
   
    
}
?>