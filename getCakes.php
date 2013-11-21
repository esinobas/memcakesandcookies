<?php

 require_once(dirname(__FILE__).'/php/ddbb/DBIterator.php');
 require_once(dirname(__FILE__)."/php/localDB/TB_CAKES.php");
 require_once(dirname(__FILE__)."/php/localConfiguration/configuration.php");
 
 if ($collection == 0){

    //get all cakes
    $cakes = TB_CAKES::getAll();
    while ($cakes->next()){
       $srcImage = $cakes->getRow()->getPath().thumbnailsPath.'/'.$cakes->getRow()->getNameFile();
    ?>
       <img src=<?php printf("\"%s\"",$srcImage);?> title=<?php printf("\"%s\"", $cakes->getRow()->getDescription());?> >
    <?php     
    }
     
 }
?>