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
               <a href="<?php print($url)?>?collectionId=<?php print($tbMenuCollection->getCollectionId());?>"><img src="<?php print(createThumbnail($filePath, 
                                     $fileName, 150, 150,
                                     $filePath.$thumbnailPath 
                                     ,"",
                                    SingletonHolder::getInstance()->getObject('Logger')));?>">
               </a>
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
       * Extracts and returns the date (dd/mm/YYYY) from a timestamp
       * @param String with the $theTimestap
       * @return String with the date in format dd/mm/YYYY
       */
      static private function getDate($theTimestap){
         SingletonHolder::getInstance()->getObject('Logger')->trace("Enter");
         SingletonHolder::getInstance()->getObject('Logger')->trace("Timestamp [  $theTimestap ]");
         $timestamp = strtotime($theTimestap);
         $date = getDate($timestamp)['mday'] . "/" . 
                 getDate($timestamp)['mon'] . "/" . 
                 getDate($timestamp)['year'];
         
         
         SingletonHolder::getInstance()->getObject('Logger')->trace("Exit");
         return $date;
      }
      
      static private function getPlainTextIntroFromHtml($html, $numchars, $addThreePoins = true) {
         // Remove the HTML tags
         $html = strip_tags($html);
         // Convert HTML entities to single characters
         $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
         // Make the string the desired number of characters
         // Note that substr is not good as it counts by bytes and not characters
         $html = mb_substr($html, 0, $numchars, 'UTF-8');
         if ($addThreePoins){
            // Add an elipsis
            $html .= "…";
         }
         return $html;
      }
      
      /**
       * Writes the blog or posts section
       */
      static private function getBlogSection(){
         SingletonHolder::getInstance()->getObject('Logger')->trace("Enter");
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->rewind();
         SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->searchByKey('URL');
         $url = SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue();
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
                     <div id="Post-<?php print($tbPost->getId());?>" class="Post">
                        <div class="Post-Header">
                           <div class="Post-Title">
                           <?php print($tbPost->getTitle());?>
                           </div>
                           <div class="Post-Date">
                           <?php print(self::getDate($tbPost->getDateTime()));?>
                           </div>
                        </div>
                        <div class="Post-Begin">
                           <?php print(self::getPlainTextIntroFromHtml($tbPost->getNew(), 150));?>
                        </div>
                        
                        <div class="Post-Read">
                           <span class="Post-Read-Text"><a href="<?php print($url);?>?post=<?php print($tbPost->getId());?>">Leer</a></span>
                        </div>
                     </div>
                  </li>
<?php 
                  $numPost ++;
                  $numCols ++;
                  
               }
?>
             </div>
                        
             <div id="View-More-Blog" class="View-More">
                <span class="Text-View-More">Ver mas</span>
             </div>
             <script type="text/javascript">
                if ($('#Blog-Grid .Grid-Col').length < <?php print((self::NUM_POSTS_COLUMNS_C*self::NUM_POST_ROWS_C));?>){
                   $('#Blog-Section .Text-View-More').hide();
                }       
                $('#View-More-Blog').click(function(){
                   clickViewmoreBlogPosts();
                   }
                );
             
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
       * Writes the selected post
       * 
       * @param thePostId: The post id to show
       */
      static private function getSelectedPost($thePostId){
         SingletonHolder::getInstance()->getObject('Logger')->trace("Enter");
         SingletonHolder::getInstance()->getObject('Logger')->trace("Get and show the post id [ $thePostId ]");
         $tbPosts = SingletonHolder::getInstance()->getObject(TB_News::TB_NewsTableC);
         $tbPosts->open();
         $tbPosts->searchByKey($thePostId);
?>
         <section class="Detail-Section">
            <article class="Page-Post">
               <div class="Page-Post-Title">
                  <h1><?php print($tbPosts->getTitle());?></h1>
               </div>
               <div class="Page-Post-Date">
                  <?php print(self::getDate($tbPosts->getDateTime()));?>
               </div>
               <div class="Page-Post-Text">
                  <?php print($tbPosts->getNew());?>
               </div>
            </article>
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
      static public function getMainSection($thePostId){
?>
         <section id="Main-Section" class="Main-Section">
           
<?php
            if ( ! isset($thePostId)){
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
            }else{
               SingletonHolder::getInstance()->getObject('Logger')->trace("Show post [ $thePostId ]");
               SingletonHolder::getInstance()->setObject(TB_News::TB_NewsTableC, new TB_News());
               self::getSelectedPost($thePostId);
            }
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
      
      static private function getMonthName($theMonthNum){
            switch ($theMonthNum){
               case 1:
                  return "Enero";
               case 2:
                  return "Febrero";
               case 3:
                  return "Marzo";
               case 4:
                  return "Abril";
               case 5:
                  return "Mayo";
               case 6:
                  return "Junio";
               case 7:
                  return "Julio";
               case 8:
                  return "Agosto";
               case 9:
                  return "Septiembre";
               case 10:
                  return "Octubre";
               case 11:
                  return "Noviembre";
               case 12:
                  return "Diciembre";
               default:
                  return "Unknown";
            }
      }
      
      /**
       * Writes the lasts  posts in the lateral
       */
      static private function getLastsPost(){
         SingletonHolder::getInstance()->getObject('Logger')->trace("Enter");
?>
         <div id="Lasts-Five-Posts">
<?php 
            SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->rewind();
            SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->searchBykey('URL');
            $url = SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC)->getValue();
            SingletonHolder::getInstance()->getObject(TB_News::TB_NewsTableC)->reset();
            $tbPosts = SingletonHolder::getInstance()->getObject(TB_News::TB_NewsTableC);
            $tbPosts->rewind();
            SingletonHolder::getInstance()->getObject('Logger')->trace("NumRows: " . $tbPosts->getCardinality() );
            $idx = 0;
?>
            <span id="Last-Five-Posts-Title">Últimas Entradas</span>
            <ul id="Last-Posts-List">
<?php 
            while ($tbPosts->next() && $idx < 5){
               SingletonHolder::getInstance()->getObject('Logger')->trace("Idx [ $idx ]");
?>
               <li class="Last-Post-Element">
                  <a href="<?php print($url);?>?post=<?php print($tbPosts->getId());?>"><?php print(strip_tags($tbPosts->getTitle()));?></a>
               </li>

<?php 
               $idx ++;
            }
?>
            </ul>
         </div>
         <ul id="Post-By-Date">
<?php 
            $tbPosts->rewind();
            $year = 0;
            $month = 0;
            while($tbPosts->next()){
               $currentYear = getDate(strtotime($tbPosts->getDateTime()))['year'];
               $currentMonth = getDate(strtotime($tbPosts->getDateTime()))['mon'];
               SingletonHolder::getInstance()->getObject('Logger')->trace("SaveYear-CurrentYear [ $year ][ $currentYear ]".
                                                                     "SaveMont-CurrentMonth [ $month ][ $currentMonth ]");
               
               if ($currentYear != $year){
                  SingletonHolder::getInstance()->getObject('Logger')->trace("Writing post for year [ $currentYear ]".
                                                         " and month [ $currentMonth ]");
                  if ($year != 0){
?>
                        </ul>
                     </li>
<?php 
                  }
?>
                   <li>
                     <div id="Year-<?php print($currentYear);?>" class="Date-Div"><?php print($currentYear);?></div>
                     <ul>
                        <li>
                           <div id="Year-Month-<?php print($currentYear);?>-<?php print(self::getMonthName($currentMonth));?>" class="Date-Div"><?php print(self::getMonthName($currentMonth));?></div>
                           <ul>
<?php 
                  $year = $currentYear;
                  $month = $currentMonth;
               }else{
                  if ($currentMonth != $month){
                     SingletonHolder::getInstance()->getObject('Logger')->trace("Writing post for month [ $currentMonth ]");
?>
                           </ul>
                        </li>
                        <li>
                           <div id="Year-Month-<?php print($currentYear);?>-<?php print(self::getMonthName($currentMonth));?>" class="Date-Div"><?php print(self::getMonthName($currentMonth));?></div>
                           <ul>
<?php
                     $month = $currentMonth;
                  }
               }
?>
               <li>
                  <a href="<?php print($url);?>?post=<?php print($tbPosts->getId());?>">
                     
                     <?php print(strip_tags($tbPosts->getTitle()));?>
                  </a>
               </li>
<?php 
            }
          
            
?>
             </ul>
            </li>
           </ul>
         </li>
       </ul>
         <script type="text/javascript">
            $('#Post-By-Date ul').hide();
            $('#Post-By-Date > li').click(function(){
               $(this).children('ul').show();
            });
            $('#Post-By-Date > li > ul > li').click(function(){
               
               $(this).children('ul').show();
            });
         </script>
         
<?php 
         SingletonHolder::getInstance()->getObject('Logger')->trace("Exit");
      }
      /**
       * Writes the page web aside 
       */
      static public function getAside($thePostId){
?>
         <aside id="Lateral-Side" class="Lateral-Side">
<?php
            if ( ! isset($thePostId)){
               self::getInstagram();
               self::getFacebookPost();
               self::getTwiterTimeLine();
            }else{
               SingletonHolder::getInstance()->getObject('Logger')->trace("Show lasts post.");
               self::getLastsPost();
            }
            
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
               newColumn.append('<a href="<?php print($url);?>?collectionId='+
                     jsonResponse.data[0].CollectionId+'"><img src="<?php print($url);?>'+addDirectory(jsonResponse.data[0].ImagePath, thumbPath)+'"></img></a>');
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
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SKIP_ROWS);?> = $('#'+theSectionId+' .Grid li').length;
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

            /**
             * Callback for show the more blog posts
             * 
             * @param theResponse: The response from the server when the query has been finished
             */
            function viewMoreBlogPostCallback(theResponse){
               JSLogger.getInstance().traceEnter();
               JSLogger.getInstance().trace("Response [ " + theResponse + " ]");
               var rows = JSON.parse(theResponse)['data'];
               for (var row in rows){
                  var newRow = $('#Blog-Section .Grid .New-Row');
                  if (newRow.length == 0){
                     JSLogger.getInstance().trace("Create a new row");
                     newRow = $('<ul class="Grid-Row New-Row"></ul>');
                     $('#Blog-Section .Grid').append(newRow);
                  }
                  var newColumn = $('<li class="Grid-Col Grid-2-Cols"></li>');
                  var newPost = $('<div id="Post-'+ rows[row].Id +'"class="Post"></div>');
                  var newHeader= $('<div class="Post-Header"></div>');
                  newHeader.append('<div class="Post-Title">' + rows[row].Title 
                                                +'</div>');
                  var date = rows[row].DateTime.split(" ");
                  
                  var day = date[0].split("-")[2];
                  var month = date[0].split("-")[1];
                  var year = date[0].split("-")[0];
                  newHeader.append('<div class="Post-Date">' + day 
                        +'/'+month+'/'+year+'</div>');
                  newPost.append(newHeader);
                  newPost.append('<div class="Post-Begin">' + jQuery(rows[row].New).text().substr(0,150)
                                             +' ...</div>');
                  newPost.append('<div class="Post-Read"><span class="Post-Read-Text"><a href="<?php print($url);?>post=' +
                                                      rows[row].Id +'">Leer</a></span></div>');
                  newColumn.append(newPost);
                  newRow.append(newColumn);
               }

               JSLogger.getInstance().trace("All post has been loaded");
               $('#Blog-Section .View-More img').remove();
               newRow.removeClass('New-Row');
               var newHeight = parseInt(height) + parseInt(newRow.css('height'));
               
               JSLogger.getInstance().trace("Grid height from [ " + height +
                     " ] to [ " + newHeight +"px ]");
               
               $('#Blog-Section .Grid').animate({
                  height: newHeight+"px"
                  }, 
                  1000,
                  function(){
                           $('#Blog-Section .Grid').css('height','')
                            }
                  );
               
               if(rows.length == <?php print(self::NUM_POSTS_COLUMNS_C);?>){
                  $('#Blog-Section .View-More span').show();
               }
            
               
               JSLogger.getInstance().traceExit();
             }
            /**
             * Show more blog post in the page
             */
            function clickViewmoreBlogPosts(){
               JSLogger.getInstance().traceEnter();
               height = $('#Blog-Section .Grid').css('height');
               $('#Blog-Section .Grid').css('height', height);
               $('#Blog-Section .View-More span').hide();
               $('#Blog-Section .View-More').append('<img src="<?php print($url);?>images/ajax-loader.gif"></img>');
               JSLogger.getInstance().trace("Create Ajax object");
               var ajaxObject = new Ajax();
               ajaxObject.setAsyn();
               ajaxObject.setGetMethod();
               ajaxObject.setCallback(viewMoreBlogPostCallback);
               JSLogger.getInstance().debug("Url whete the data will be send [ <?php print($url);?>" 
               +"php/Database/RequestFromWeb.php ]");
               ajaxObject.setUrl("<?php print($url);?>php/Database/RequestFromWeb.php");
               var requestParams = {};
               requestParams.<?php print(COMMAND);?> = <?php print("\"".COMMAND_SELECT."\"");?>;
               requestParams.<?php print(PARAMS);?> = {};
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = <?php print("\""
                        .TB_News::TB_NewsTableC ."\"");?>;
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SKIP_ROWS);?> = $('#Blog-Section .Grid li').length;
               requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_NUM_ROWS)?> = <?php print(self::NUM_POSTS_COLUMNS_C);?>;
               JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

               ajaxObject.setParameters(JSON.stringify(requestParams));
               ajaxObject.send();
         
               JSLogger.getInstance().traceExit();
            }   
         </script>
<?php 
         SingletonHolder::getInstance()->getObject('Logger')->trace("Exit");
      }
      
      /**
       * Writes the collection images in the page
       * @param theCollectionId: The collection identifier
       */
      
      static public function getCollectionImages($theCollectionId){
         SingletonHolder::getInstance()->getObject('Logger')->trace("Enter");
         SingletonHolder::getInstance()->getObject('Logger')->trace("Geting images from collection [ $theCollectionId ]");
         $tbTypeCollectionImage = new TB_TypeCollectionImage();
         $tbTypeCollectionImage->open();
         $tbTypeCollectionImage->searchByColumn(TB_TypeCollectionImage::CollectionIdColumnC, $theCollectionId);
         $tbConfiguration = SingletonHolder::getInstance()->getObject(TB_Configuration::TB_ConfigurationTableC);
         $tbConfiguration->reset();
         $tbConfiguration->searchByKey('URL');
         $url = $tbConfiguration->getValue();
         $tbConfiguration->reset();
         $tbConfiguration->searchByKey('thumbnailsPath');
         $thumbnailPath = $tbConfiguration->getValue();
         
?>
         <div style="width: 100%; height: 125px;"></div>
         <section id="Main-Section" class="Main-Section">
            <h1 class="Class-H1"><?php print($tbTypeCollectionImage->getTypeName());?></h1>
            <h2 class="Class-H2"><?php print($tbTypeCollectionImage->getCollectionName());?></h2>
            <div id="CollectionImages-<?php print($theCollectionId);?>" class="Grid">
<?php
            $numCols = self::NUM_GRID_COLUMNS_C;
            $closePrevious = false;
 
            while($tbTypeCollectionImage->next()){
               if ($numCols == self::NUM_GRID_COLUMNS_C){
                  if ($closePrevious){
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
               $arrayPathFilename = explode("/",$tbTypeCollectionImage->getImagePath());
               $filePath = "";
               for ($idx = 0; $idx < count($arrayPathFilename); $idx++){
                  if ($idx != count($arrayPathFilename) -1 ){
                     $filePath .= $arrayPathFilename[$idx] . "/";
                  }
               }
               $fileName = $arrayPathFilename[count($arrayPathFilename) -1 ];
               SingletonHolder::getInstance()->getObject('Logger')->trace("File Path [ $filePath ]. File Name [ $fileName ]");
                
?>
               <li class="Grid-Col Grid-3-Cols">
                  <img alt="" src="<?php print(createThumbnail($filePath, 
                                     $fileName, 150, 150,
                                     $filePath.$thumbnailPath 
                                     ,"",
                                    SingletonHolder::getInstance()->getObject('Logger')));?>" title="<?php print($tbTypeCollectionImage->getImageDescription());?>">
               </li>
<?php
                $numCols ++;
            }
            if ($closePrevious){
?>
               </ul>
<?php 
            } 
?>
            </div>
         </section>         
                    
<?php
         SingletonHolder::getInstance()->getObject('Logger')->trace("Exit");
      }
   }
?>