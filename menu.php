<?php
   require_once(dirname(__FILE__).'/php/ddbb/DBIterator.php');
   require_once(dirname(__FILE__).'/php/localDB/TB_MENUS.php');
   $options = TB_MENUS::getMenu(0);
  
?>
<br>
<ul id="menu">
   <?php
   while ($options->next()){
   ?>
   <li>
   <?php
      $row = $options->getRow();   
      printf("%s\n", $row->getOption());
      if (TB_MENUS::hasSubmenu($row->getId()) == true){
         $optionsSubmenu = TB_MENUS::getMenu($row->getId());
         ?>
         
         <ul class="submenu">
         a
         <?php
            while($optionsSubmenu->next()){
            ?>
               <li>
                  <?php
                     printf("%s\n",$optionsSubmenu->getRow()->getOption());
                  ?>
               </li> 
            <?php           
            }
         ?>
         </ul>
         
         <?php      
      }
   ?>
    
   </li>
   <?php
   }
   ?>
</ul>
