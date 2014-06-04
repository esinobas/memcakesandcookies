<?php
   require_once(dirname(__FILE__).'/php/ddbb/DBIterator.php');
   require_once(dirname(__FILE__).'/php/localDB/TB_MENUS.php');
   include_once 'TB_COLLECTION.php';
   
   $options = TB_MENUS::getMenu(0);
  
?>
<br>
<br>
<ul id="menu">
   <?php
   while ($options->next()){
   ?>
   <li>
   <?php
      $row = $options->getRow();   
      
      if (TB_MENUS::hasSubmenu($row->getId()) == true){
         ?>
         <a href="#"></a>
         <?php
            printf("%s", $row->getOption());
            $optionsSubmenu = TB_COLLECTION::getCollectionsFromMenu($row->getId());
         ?>
         <div class="submenu">
                 
         <?php
            while($optionsSubmenu->next()){
            ?>
                  <a href=<?php printf("\"%s?pageId=%s&collection=%s\"", url, 
                       $row->getId(),$optionsSubmenu->getRow()->getId() ); ?>> 
                  <?php
                  
                     printf("%s",$optionsSubmenu->getRow()->getName());
                  ?>
                  </a>
                  <br>
            <?php           
            }
         ?>
         
         </div>
         
         <?php      
      }else{
         ?>
         <a href=<?php printf("\"%s?pageId=%s\"",url, $row->getId());?>>
            <?php printf("%s", $row->getOption()); ?>
         
         <?php      
      }
   ?>
    </a>
   </li>
   <?php
   }
   ?>
</ul>
