<?php

 require_once(dirname(__FILE__).'/php/ddbb/DBIterator.php');
 require_once(dirname(__FILE__)."/php/localDB/TB_CAKES.php");
 
 if ($collection == 0){

    //get all cakes
    $cakes = TB_CAKES::getAll();
    while ($cakes->next()){
    ?>
       <img src=<?php printf("\"%s/%s\"", $cakes->getRow()->getPath(), $cakes->getRow()->getNameFile());?> >
    <?php     
    }
     
 }
?>