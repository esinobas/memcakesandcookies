<?php
   /**
    * This file contains a static class with static functions that are used
    * to compose the page web.
    */

   class PageFunctions{
      
      /**
       * Writes the page header
       */
      static public function getHeader(){
?>
         <header>
          
         </header>
<?php
         
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->searchByKey('URL');
?>
         <div id="Solid-Header">
            <div id="Solid-Header-Center">
               <a href="<?php print( SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue());?>">
                  <div id="Logo" style="background-image: url(<?php print( SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue());?>images/logoCMYKwithoutBorder.jpg);"></div>
               </a>
               <nav>
                  <ul>
                     <a href="<?php print( SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue());?>#Cakes"><li>Cakes</li></a>
                     <a href="<?php print( SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue());?>#Cookies"><li>Cookies</li></a>
                     <!-- <li>Subscripcion</li> -->
                     <a href="<?php print( SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue());?>#Contact"><li>Contacto</li></a>
                  </ul>
               </nav>
            </div>
         </div>
<?php 
      }
      
      /**
       * Writes the images slides in the page web
       */
      static public function getImagesSlide(){
?>
         <section id="Section-Images-Slides">
            <div id="Images-Slide" class="Images-Slide-Container">
<?php
               $tbSlideImagesHome = new TB_SlideImagesHome();
               $tbSlideImagesHome->open();
               while($tbSlideImagesHome->next()){
?>
                  <div class="Images-Slide-Item">
                     <img src="<?php print( SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue().$tbSlideImagesHome->getPath());?>">
                  </div>
<?php 
               } 
?>
            </div>
            <script type="text/javascript">
               ImagesSlide.init('Images-Slide', 2, 2);
            </script>
         </section>
<?php 
      }
      
      /**
       * Writes the cakes section
       */
      static private function getCakesSection(){
         SingletonHolder::getInstance()->getObject('Logger')->trace("Enter");
?>
         <spam class="Anchor" id="Cakes"></spam>
         <section id="Cakes-Section" class="Detail-Section">
            <h2>Cakes</h2>
            <div id="Cakes-Grid" class="Grid">
<?php
         $tbMenuCollection = new TB_MenuCollection();
         $tbMenuCollection->open();
         $tbCollectionImages = new TB_TypeCollectionImage();
         $tbCollectionImages->open();
         
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->rewind();
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->searchByKey('URL');
         $url = SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue();
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->rewind();
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->searchByKey('thumbnailsPath');
         $thumbnailPath = SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue();
         
         $numCols = 3;
         $closePrevious = false;
         $maxNumElements = 3 * 2;
         $numElements = 0;
         
         $tbMenuCollection->searchByColumn(TB_MenuCollection::MenuIdColumnC, "2");
         while ($tbMenuCollection->next() && $numElements < $maxNumElements){
            SingletonHolder::getInstance()->getObject('Logger')->trace("Get the first Collection Image [ " . 
                  $tbMenuCollection->getCollectionName() ." ]");
           
            $tbCollectionImages->rewind();
            if ($tbCollectionImages->searchByColumn(TB_TypeCollectionImage::CollectionIdColumnC,
                                                $tbMenuCollection->getCollectionId())){
            
               SingletonHolder::getInstance()->getObject('Logger')->trace(
                     "The image [ " . $tbCollectionImages->getImagePath() . 
                     " ] has been getted");
               $arrayPathFilename = explode("/",$tbCollectionImages->getImagePath());
               $filePath = "";
               for ($idx = 0; $idx < count($arrayPathFilename); $idx++){
                 if ($idx != count($arrayPathFilename) -1 ){
                     $filePath .= $arrayPathFilename[$idx] . "/";
                  }
               }
               $fileName = $arrayPathFilename[count($arrayPathFilename) -1 ];
               SingletonHolder::getInstance()->getObject('Logger')->trace("File Path [ $filePath ]. File Name [ $fileName ]");
               if ($numCols == 3){
                  if($closePrevious){
                  ?>
                     </ul>
                  <?php 
                    $closePrevious = false;
                    
                  }
?>
                  <ul class="Grid-Row">
<?php
                  $numCols = 0;
                 
                  $closePrevious = true;
               }
?>
               <li class="Grid-Col">
               <h3>
<?php 
               print($tbMenuCollection->getCollectionName());
?>
               </h3>
               <img src="<?php print(createThumbnail($filePath, 
                                 $fileName, 150, 150,
                                 $filePath.$thumbnailPath 
                                 ,"Thumb_",
                                  SingletonHolder::getInstance()->getObject('Logger')));?>">
               </li>

<?php 
               $numCols++;
               $numElements ++;
            }
           
         } 
         if ($closePrevious){
?>
            </ul>
<?php 
         }
?> 
            </div>
            <div id="View-Most-Cakes" class="View-More">
               <span class="Text-View-More">Ver mas</span>
            </div>
            
            <script type="text/javascript">

               var numImagesToLoad = 0;
               var showViewMore = true;
               
               function getImageDataCallback(theResponseText){
                  JSLogger.getInstance().traceEnter();
                  JSLogger.getInstance().trace("Response [" + theResponseText +" ]");
                  var jsonResponse = JSON.parse(theResponseText);
                  //Check if the new row exists
                  var newRow = $('#Cakes-Grid .New-Row');
                  if (newRow.length == 0){
                     JSLogger.getInstance().trace("Create a new row");
                     newRow = $('<ul class="Grid-Row New-Row"></ul>');
                     $('#Cakes-Grid').append(newRow);
                  }
                  var newColumn = $('<li class="Grid-Col"></li>');
                  newColumn.append('<h3>' + jsonResponse.data[0].CollectionName+'</h3>');
                  newColumn.append('<img src="<?php print($url);?>'+jsonResponse.data[0].ImagePath+'"></img>');
                  newRow.append(newColumn);

                  if (--numImagesToLoad == 0){
                     JSLogger.getInstance().trace("All images have been loaded");
                     $('#View-Most-Cakes img').remove();
                     if (showViewMore){
                        $('#View-Most-Cakes span').css('display', '');
                     }
                  }
                  JSLogger.getInstance().traceExit();
               }
   
               function getFirstCollectionImageFromServer(theResponseText){
                  JSLogger.getInstance().traceEnter();
                  JSLogger.getInstance().trace("Response [" + theResponseText +" ]");
                  var rows = JSON.parse(theResponseText)['data'];

                  for (var row in rows){
                     JSLogger.getInstance().trace("Collection : id [ " + rows[row].CollectionId +
                           " ] [ " + rows[row].CollectionName + " ]");
                  
                     JSLogger.getInstance().trace("Create Ajax object");
                     var ajaxObject = new Ajax();
                     ajaxObject.setAsyn();
                     ajaxObject.setGetMethod();
                     ajaxObject.setCallback(getImageDataCallback);
                     JSLogger.getInstance().debug("Url whete the data will be send [ <?php print($url);?>" 
                                    +"php/Database/RequestFromWeb.php ]");
                     ajaxObject.setUrl("<?php print($url);?>php/Database/RequestFromWeb.php");
                     var requestParams = {};
                     requestParams.<?php print(COMMAND);?> = <?php print("\"".COMMAND_SELECT."\"");?>;
                     requestParams.<?php print(PARAMS);?> = {};
                     requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = <?php print("\""
                           .TB_TypeCollectionImage::TB_TypeCollectionImageTableC ."\"");?>;
                     requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
                     requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_NUM_ROWS)?> = 1
                     requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?> = {};
                     requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?>.<?php print(PARAM_SEARCH_COLUMN);?> = "<?php print(TB_TypeCollectionImage::CollectionIdColumnC);?>";
                     requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?>.<?php print(PARAM_SEARCH_VALUE);?> = rows[row].CollectionId;
                     JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

                     ajaxObject.setParameters(JSON.stringify(requestParams));
                     ajaxObject.send();
                     numImagesToLoad ++;
                  }
                  if (numImagesToLoad < 3){
                     showViewMore = false;
                  }
                  JSLogger.getInstance().traceExit();
               };
            
               $('#View-Most-Cakes').click(function(){

                  $('#View-Most-Cakes span').css('display', 'none');
                  $('#View-Most-Cakes').append('<img src="<?php print($url);?>images/ajax-loader.gif"></img>');
                  JSLogger.getInstance().trace("Create Ajax object");
                  var ajaxObject = new Ajax();
                  ajaxObject.setAsyn();
                  ajaxObject.setGetMethod();
                  ajaxObject.setCallback(getFirstCollectionImageFromServer);
                  JSLogger.getInstance().debug("Url whete the data will be send [ <?php print($url);?>" 
                  +"php/Database/RequestFromWeb.php ]");
                  ajaxObject.setUrl("<?php print($url);?>php/Database/RequestFromWeb.php");
                  var requestParams = {};
                  requestParams.<?php print(COMMAND);?> = <?php print("\"".COMMAND_SELECT."\"");?>;
                  requestParams.<?php print(PARAMS);?> = {};
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = <?php print("\""
                           .TB_MenuCollection::TB_MenuCollectionTableC ."\"");?>;
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SKIP_ROWS);?> = $('#Cakes-Grid li').length;
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_NUM_ROWS)?> = 3;
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?> = {};
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?>.<?php print(PARAM_SEARCH_COLUMN);?>="<?php print(TB_MenuCollection::MenuIdColumnC);?>";
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?>.<?php print(PARAM_SEARCH_VALUE);?> = "2";
                  JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

                  ajaxObject.setParameters(JSON.stringify(requestParams));
                  ajaxObject.send();
                  
               });
            </script>
         </section>
<?php 
         SingletonHolder::getInstance()->getObject('Logger')->trace("Exit");
      }
      
      /**
       * Writes the cookies section
       */
      
      /**
       * Writes the contact section
       */
      
      /**
       * Writes the newsletter section
       */
      /**
       * Writes the Main section
       */
      static public function getMainSection(){
?>
         <section id="Main-Section" class="Main-Section">
           
<?php
            self::getCakesSection(); 
?>
         </section>
<?php 

      }
      
      /**
       * Writes the Instagram photos (media)
       */
      static private function getInstagram(){
         
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->rewind();
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->searchByKey('Instagram');
         $instagramUser = SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue();
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->rewind();
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->searchByKey('numberThumbnails');
         $numThumbnails = intval(SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue());
         
         $lastImages = json_decode(Instagram::getLastImages($instagramUser, $numThumbnails));
         
         SingletonHolder::getInstance()->getObject('Logger')->trace("\nMost Last Images [ " .
                       json_encode($lastImages) ." ]\n");

?> 
         <div class="Instagram-Plugin">
            <div class="View-On-Instagram">
               <style>.ig-b- { display: inline-block; }
                  .ig-b- img { visibility: hidden; }
                  .ig-b-:hover { background-position: 0 -60px; } .ig-b-:active { background-position: 0 -120px; }
                  .ig-b-v-24 { width: 137px; height: 24px; background: url(//badges.instagram.com/static/images/ig-badge-view-sprite-24.png) no-repeat 0 0; }
                  @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
                     .ig-b-v-24 { background-image: url(//badges.instagram.com/static/images/ig-badge-view-sprite-24@2x.png); background-size: 160px 178px; } }
               </style>
               <a target="_blank" href="http://instagram.com/<?php print($instagramUser);?>?ref=badge" class="ig-b- ig-b-v-24"><img src="//badges.instagram.com/static/images/ig-badge-view-24.png" alt="Instagram" /></a>
            </div>
         
<?php 
         
         foreach (array_keys($lastImages) as $idx){
            SingletonHolder::getInstance()->getObject('Logger')->trace("Media Thumbmail [$idx] => ".
                  $lastImages[$idx]->Thumbnail);
?>
            <div class="Instagram-Thumbnail">
               <a target="_blank" href="<?php print($lastImages[$idx]->Link);?>">
                  <img src="<?php print($lastImages[$idx]->Thumbnail);?>" title="<?php print($lastImages[$idx]->Text);?>">
               </a>
            </div>
<?php 
         }
?>
         </div>
<?php 
      }
      
      /**
       * Writes the facebook post
       */
      static private function getFacebookPost(){
      
?>
      <div id="fb-root"></div>
      <script>
         (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) 
               return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.5";
            fjs.parentNode.insertBefore(js, fjs);
            }
         (document, 'script', 'facebook-jssdk')
         );
      </script>
<?php
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->rewind(); 
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->searchByKey('Facebook');
?>
      <div class="fb-page" data-href="<?php print(SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue());?>" data-width="300" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false" data-show-posts="true"></div>
<?php 
      }
      
      /**
       * Writes the twiter timeline
       */
      static private function getTwiterTimeLine(){
         
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->rewind();
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->searchByKey('Twiter');
?>
         <div class="Twiter-Widget">
            <a class="twitter-timeline" href="<?php print(SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue());?>" data-widget-id="670182839384678400">Tweets por el @MEMCyC.</a>
            <script>
               !function(d,s,id){
                  var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
                  if(!d.getElementById(id)){
                     js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
                     fjs.parentNode.insertBefore(js,fjs);
                  }
               }(document,"script","twitter-wjs");</script>
          </div>
          
<?php 
      }
      /**
       * Writes the page web aside 
       */
      static public function getAside(){
?>
         <aside id="Lateral-Side" class="Lateral-Side">
<?php
            self::getInstagram();
            self::getFacebookPost();
            self::getTwiterTimeLine();
            
?>
         </aside>
<?php 
      }
      
      /**
       * Writes the page web footer
       */
      static public function getFooter(){
      }
      
   }
?>