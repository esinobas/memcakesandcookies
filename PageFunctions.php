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
       * Writes the page web aside 
       */
      static public function getAside(){
?>
         <aside id="Lateral-Side" class="Lateral-Side">
            aside
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