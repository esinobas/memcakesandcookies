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
       * Writes the Main section
       */
      static public function getMainSection(){
?>
         <section id="Main-Section" class="Main-Section">
            Main
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
         
         foreach (array_keys($lastImages) as $idx){
            SingletonHolder::getInstance()->getObject('Logger')->trace("Media Thumbmail [$idx] => ".
                  $lastImages[$idx]->Thumbnail);
?>
            <style>.ig-b- { display: inline-block; }
.ig-b- img { visibility: hidden; }
.ig-b-:hover { background-position: 0 -60px; } .ig-b-:active { background-position: 0 -120px; }
.ig-b-v-24 { width: 137px; height: 24px; background: url(//badges.instagram.com/static/images/ig-badge-view-sprite-24.png) no-repeat 0 0; }
@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
.ig-b-v-24 { background-image: url(//badges.instagram.com/static/images/ig-badge-view-sprite-24@2x.png); background-size: 160px 178px; } }</style>
<a href="http://instagram.com/esinobas?ref=badge" class="ig-b- ig-b-v-24"><img src="//badges.instagram.com/static/images/ig-badge-view-24.png" alt="Instagram" /></a>
            <img src="<?php print($lastImages[$idx]->Thumbnail);?>">
<?php 
         }
         
      }
      
      /**
       * Writes the page web aside 
       */
      static public function getAside(){
?>
         <aside id="Lateral-Side" class="Lateral-Side">
<?php
            self::getInstagram();
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