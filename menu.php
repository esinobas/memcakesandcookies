<?php
   $loggerMenu =  LoggerMgr::Instance()->getLogger("menu.php");
   $loggerMenu->trace("menu.php. Enter");
   
   require_once 'Database/TB_Menu.php';
   require_once 'Database/TB_MenuCollection.php';
   
   $tableMenu = new TB_Menu();
   $tableMenu->open();
   $tableMenuCollection = new TB_MenuCollection();
   $tableMenuCollection->open();
   
   $tableConfiguration->rewind();
   $tableConfiguration->searchByKey("URL");

?>
<br>
<br>
<ul id="menu">
   <?php
      while ($tableMenu->next()){
   ?>
   <li>
   <?php

      if ($tableMenuCollection->searchByColumn(TB_MenuCollection::MenuIdColumnC,
              $tableMenu->getId()) == true){
   ?>
         <a href="#"></a>
         <?php
            printf("%s", $tableMenu->getOption());
            $loggerMenu->trace("The option \"".$tableMenu->getOption().
                  "\" has [ " .$tableMenuCollection->getCardinality() .
                  " ] submenus.");
         ?>
         <div class="submenu">
                 
         <?php
            while($tableMenuCollection->next()){
            ?>
                  <a href=<?php printf("\"%s?pageId=%s&collection=%s\"", 
                        $tableConfiguration->getValue(),
                        $tableMenuCollection->getMenuId(),
                        $tableMenuCollection->getCollectionId());?>> 
                  <?php
                     printf("%s",$tableMenuCollection->getCollectionName());
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
         <a href=<?php printf("\"%s?pageId=%s\"",$tableConfiguration->getValue(),
                $tableMenu->getId());?>>
            <?php printf("%s", $tableMenu->getOption()); ?>
         
         <?php      
      }
   ?>
    </a>
   </li>
   <?php
   }
   $loggerMenu->trace("menu.php. Exit");
   ?>
</ul>
