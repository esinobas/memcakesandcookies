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
         printf("%s\n", $row->getOption());
         $optionsSubmenu = TB_MENUS::getMenu($row->getId());
         ?>
         <div class="submenu">
                 
         <?php
            while($optionsSubmenu->next()){
            ?>
         
                  <?php
                     printf("%s\n<br>\n",$optionsSubmenu->getRow()->getOption());
                  ?>
          
            <?php           
            }
         ?>
         
         </div>
         
         <?php      
      }else{
         ?>
         <a href=<?php printf("\"%s?pageId=%s\"",url, $row->getId());?>>
            <?php printf("%s\n", $row->getOption()); ?>
         </a>
         <?php      
      }
   ?>
    
   </li>
   <?php
   }
   ?>
</ul>
