<?php
   require_once(dirname(__FILE__).'/php/ddbb/DBIterator.php');
   require_once(dirname(__FILE__).'/php/localDB/TB_MENUS.php');
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
         <a href="#">
         <?php
            printf("%s", $row->getOption());
           $optionsSubmenu = TB_MENUS::getMenu($row->getId());
         ?>
         <div class="submenu">
                 
         <?php
            while($optionsSubmenu->next()){
            ?>
                  <a href=<?php printf("\"%s?pageId=%s&collection=%s\"", url, $optionsSubmenu->getRow()->getId(), $row->getId()); ?>> 
                  <?php
                  
                     printf("%s",$optionsSubmenu->getRow()->getOption());
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
