<?php
   /**
    * This file contains a static class with static functions that are used
    * to compose the page web.
    */

   class PageFunctions{
      
      /**
       * Private constants
       * 
       */
      
      /**
       * 
       */
      const NUM_GRID_COLUMNS_C = 3;
      
      const NUM_GRID_ROWS_C = 2;
      
      const NUM_POSTS_COLUMNS_C = 2;
      
      const NUM_POST_ROWS_C = 2;
      
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
       * Get from the data base the collections and their first image and 
       * they are written in the grid
       * @param integer $theType
       */
      static private function writeTheFirstCollectionImage($theType){
         
         SingletonHolder::getInstance()->getObject('Logger')->trace("Enter");
         SingletonHolder::getInstance()->getObject('Logger')->trace("Search collections and theirs first images for the type [ $theType ]");
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->rewind();
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->searchByKey('URL');
         $url = SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue();
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->rewind();
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->searchByKey('thumbnailsPath');
         $thumbnailPath = SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue();
          
         $numCols = self::NUM_GRID_COLUMNS_C;
         $closePrevious = false;
         $maxNumElements = self::NUM_GRID_COLUMNS_C * self::NUM_GRID_ROWS_C;
         $numElements = 0;
          
         $tbMenuCollection = SingletonHolder::getInstance()->getObject(TB_MenuCollection::TB_MenuCollectionTableC);
         $tbMenuCollection->rewind();
         $tbMenuCollection->searchByColumn(TB_MenuCollection::MenuIdColumnC, strval($theType));
          
         $tbCollectionImages = SingletonHolder::getInstance()->getObject(TB_TypeCollectionImage::TB_TypeCollectionImageTableC);
          
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
               if ($numCols == self::NUM_GRID_COLUMNS_C){
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
               <li class="Grid-Col Grid-3-Cols">
               <h3>
<?php 
                  print($tbMenuCollection->getCollectionName());
?>
               </h3>
               <img src="<?php print(createThumbnail($filePath, 
                                     $fileName, 150, 150,
                                     $filePath.$thumbnailPath 
                                     ,"",
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
 
                  
         SingletonHolder::getInstance()->getObject('Logger')->trace("Exit");
      }
      
      
      /**
       * Writes the blog or posts section
       */
      static private function getBlogSection(){
         SingletonHolder::getInstance()->getObject('Logger')->trace("Enter");
?>
         <spam class="Anchor" id="Blog"></spam>
         <section id="Blog-Section" class="Detail-Section">
             <div id="Blog-Grid" class="Grid">
<?php
               $tbPost = new TB_News();
               $tbPost->open();
               $numPost = 0;
               $numCols = self::NUM_POSTS_COLUMNS_C;
               $closePrevious = false;
               while ($tbPost->next() &&
                     $numPost < (self::NUM_POST_ROWS_C * self::NUM_POSTS_COLUMNS_C)){
                  
                  
                  if ($numCols == self::NUM_POSTS_COLUMNS_C){
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
                  <li class="Grid-Col Grid-2-Cols">
                     <div class="Post">
                        <div class="Post-Header">
                           <div class="Post-Title">
                           <?php print($tbPost->getTitle());?>
                           </div>
                           <div class="Post-Date">
                           <?php print($tbPost->getDateTime());?>
                           </div>
                        </div>
                        <div class="Post-Begin">
                        </div>
                        <div class="Post-Read">
                        </div>
                     </div>
                  </li>
<?php 
                  $numPost ++;
               }
?>
             </div>
                        
             <div id="View-More-Blog" class="View-More">
                <span class="Text-View-More">Ver mas</span>
             </div>
             <script type="text/javascript">
                  
             </script>
          </section>
<?php 
            SingletonHolder::getInstance()->getObject('Logger')->trace("Exit");
         }
        
      
      /**
       * Writes the Cookies section
       */
      static private function getCookiesSection(){
         SingletonHolder::getInstance()->getObject('Logger')->trace("Enter");
         ?>
               <spam class="Anchor" id="Cookies"></spam>
               <section id="Cookies-Section" class="Detail-Section">
                  <h2>Cookies</h2>
                  <div id="Cookies-Grid" class="Grid">
      <?php
                     self::writeTheFirstCollectionImage(3);
?>
                  </div>
                  
                  <div id="View-More-Cookies" class="View-More">
                     <span class="Text-View-More">Ver mas</span>
                  </div>
                  <script type="text/javascript">
                     if ($('#Cookies-Grid .Grid-Col').length < <?php print((self::NUM_GRID_COLUMNS_C*self::NUM_GRID_ROWS_C));?>){
                        $('#Cookies-Section .Text-View-More').hide();
                     }       
                     $('#View-More-Cookies').click(function(){
                        clickViewMore('Cookies-Section');
                     }
                  );  
                  </script>
               </section>
<?php 
         SingletonHolder::getInstance()->getObject('Logger')->trace("Exit");
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
               self::writeTheFirstCollectionImage(2);
         
?>
            </div>
            <div id="View-More-Cakes" class="View-More">
               <span class="Text-View-More">Ver mas</span>
            </div>
            <script type="text/javascript">
               if ($('#Cakes-Grid .Grid-Col').length < <?php print((self::NUM_GRID_COLUMNS_C*self::NUM_GRID_ROWS_C));?>){
                  $('#Cakes-Section .Text-View-More').hide();
               }       
               $('#View-More-Cakes').click(function(){
                     clickViewMore('Cakes-Section');
                  }
               );
            </script>
            
         </section>
<?php 
         SingletonHolder::getInstance()->getObject('Logger')->trace("Exit");
      }
      

      
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
            $tbMenuCollection = new TB_MenuCollection();
            $tbMenuCollection->open();
            $tbCollectionImages = new TB_TypeCollectionImage();
            $tbCollectionImages->open();
            SingletonHolder::getInstance()->setObject(
                        TB_MenuCollection::TB_MenuCollectionTableC, 
                        $tbMenuCollection);
            SingletonHolder::getInstance()->setObject(
                        TB_TypeCollectionImage::TB_TypeCollectionImageTableC, 
                        $tbCollectionImages);
            self::getBlogSection();
            self::getCakesSection(); 
            self::getCookiesSection();
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

      
      /**
       * Writes the javascript functions to be used in the web
       */
       static public function writeJavascriptFunctions(){
         SingletonHolder::getInstance()->getObject('Logger')->trace("Enter");
?>
         <script type="text/javascript">
            /**
               Functions to be used in the web
            */
            //Global variables
            var numImagesToLoad = 0;
            var showViewMore = true;
            var height = 0;
<?php
            SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->rewind(); 
            SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->searchByKey('thumbnailsPath');
?>
            var thumbPath = "<?php print(SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue());?>";

            /**
             * Funtcion that adds a directory to the final path
             */
            function addDirectory(thePath, theDirectoryToAdd){
               JSLogger.getInstance().traceEnter();
               JSLogger.getInstance().trace("Original path [ " +thePath + " ]");
               JSLogger.getInstance().trace("Directory to add [ " +theDirectoryToAdd + " ]");
               var arrayTokens = thePath.split("/");
               var newPath = "";
               
               for (var idx = 0; idx < arrayTokens.length; idx++){
                  JSLogger.getInstance().trace("Token [ " + arrayTokens[idx] + " ]");
                  if (idx < (arrayTokens.length - 1) ){
                     newPath += arrayTokens[idx] +"/";
                  }
                  if (idx ==  (arrayTokens.length - 1) ){
                     newPath += theDirectoryToAdd + "/" + arrayTokens[idx];
                  }
                 
               }
               JSLogger.getInstance().trace("Return [ " + newPath + " ]");
               JSLogger.getInstance().traceExit();
               return newPath;
            }
            /**
             * Callback that loads an image after a get requesto to the server
             *
             * @param the ResponseText is a string in a json format with the image data
             */
            function getImageDataCallback(theResponseText){
               JSLogger.getInstance().traceEnter();
               JSLogger.getInstance().trace("Response [" + theResponseText +" ]");
               var jsonResponse = JSON.parse(theResponseText);
               var sectionId = jsonResponse.addToCallback.SectionId;
               JSLogger.getInstance().trace("The section id extraed from callback is [ " +
                                          sectionId + " ]");
               //Check if the new row exists
               var newRow = $('#'+sectionId+' .Grid .New-Row');
               if (newRow.length == 0){
                  JSLogger.getInstance().trace("Create a new row");
                  newRow = $('<ul class="Grid-Row New-Row"></ul>');
                  $('#'+sectionId+' .Grid').append(newRow);
               }
               var newColumn = $('<li class="Grid-Col Grid-3-Cols"></li>');
               newColumn.append('<h3>' + jsonResponse.data[0].CollectionName+'</h3>');
               newColumn.append('<img src="<?php print($url);?>'+addDirectory(jsonResponse.data[0].ImagePath, thumbPath)+'"></img>');
               newRow.append(newColumn);

               if (--numImagesToLoad == 0){
                  JSLogger.getInstance().trace("All images have been loaded");
                  $('#' + sectionId + ' .View-More img').remove();
                  newRow.removeClass('New-Row');
                  var newHeight = parseInt(height) + parseInt(newRow.css('height'));
                  
                  JSLogger.getInstance().trace("Grid height from [ " + height +
                        " ] to [ " + newHeight +"px ]");
                  
                  $('#'+sectionId+' .Grid').animate({
                     height: newHeight+"px"
                     }, 
                     1000,
                     function(){
                              $('#'+sectionId+' .Grid').css('height','')
                               }
                     );
                  
                  
                  if (showViewMore){
                  
                     $('#' + sectionId + ' .View-More span').show();
                  }
               }
               JSLogger.getInstance().traceExit();
            }

            /**
             * Get the first collection image form the server throught an 
             * ajax request. It is a callback
             * 
             * @param theResponseText is a json string with collection data
             */
            function getFirstCollectionImageFromServer(theResponseText){
               JSLogger.getInstance().traceEnter();
               JSLogger.getInstance().trace("Response [" + theResponseText +" ]");
               var addToCallback = JSON.parse(theResponseText)['addToCallback'];
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
                  requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(ADD_TO_CALLBACK);?> = addToCallback;
                   

                  JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

                  ajaxObject.setParameters(JSON.stringify(requestParams));
                  ajaxObject.send();
                  numImagesToLoad ++;
               }
               if (numImagesToLoad < <?php print(self::NUM_GRID_COLUMNS_C);?>){
                  
                  showViewMore = false;
                 
               }
               JSLogger.getInstance().traceExit();
            };

            /**
             * Function that is called from the link or text View More for
             * show more collections in the main page.
             *
             * @param theSectionId: Section where the grid is located
            */
            function clickViewMore(theSectionId){

               JSLogger.getInstance().traceEnter();
               JSLogger.getInstance().trace("The Section Id [ " + theSectionId +" ]");
               height = $('#'+theSectionId+' .Grid').css('height');
               $('#'+theSectionId+' .Grid').css('height', height);
               $('#'+theSectionId+' .View-More span').hide();
               $('#'+theSectionId+' .View-More').append('<img src="<?php print($url);?>images/ajax-loader.gif"></img>');
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
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_NUM_ROWS)?> = <?php print(self::NUM_GRID_COLUMNS_C);?>;
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?> = {};
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?>.<?php print(PARAM_SEARCH_COLUMN);?>="<?php print(TB_MenuCollection::MenuIdColumnC);?>";
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?>.<?php print(PARAM_SEARCH_VALUE);?> = "2";
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(ADD_TO_CALLBACK);?> = {};
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(ADD_TO_CALLBACK);?>.SectionId = theSectionId; 
               JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

               ajaxObject.setParameters(JSON.stringify(requestParams));
               ajaxObject.send();
               
           
            }
               
         </script>
<?php 
         SingletonHolder::getInstance()->getObject('Logger')->trace("Exit");
      }
   }
?>