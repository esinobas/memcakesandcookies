<?php 
   session_start();
?>
<html>
   <head>
      <title>
         Administracion MEM Cakes & Cookies
      </title>
      
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">

      <link rel="stylesheet" type="text/css" href="style.css">
      <script type="text/javascript" src="../scripts/jquery-1.9.0.js"></script>
      <script type="text/javascript" src="../plugins/Ajax/Ajax.js"></script>
      <script type="text/javascript" src="ControlPanelFunctions.js"></script>
      <script type="text/javascript" src="newcollection.js"></script>  
      <link rel="stylesheet" type="text/css" href="newcollection.css"> 
      <script type="text/javascript" src="UploadImage.js"></script>  
      <link rel="stylesheet" type="text/css" href="UploadImage.css">
      <script type="text/javascript" src="UpdateImageDescription.js"></script>   
      <link rel="stylesheet" type="text/css" href="UpdateImageDescription.css">  
      <script type="text/javascript" src="../plugins/FileBrowser/FileBrowser.js"></script>
      <script type="text/javascript" src="../plugins/FileBrowser/FileBrowserFactory.js"></script>
      <script type="text/javascript" src="../plugins/FileBrowser/FileBrowserDefault.js"></script>
      <script type="text/javascript" src="../plugins/FileBrowser/FileBrowserDataBase.js"></script>
      <link rel="stylesheet" type="text/css" href="../plugins/FileBrowser/FileBrowser.css">
      <script type="text/javascript" src="../plugins/FileBrowser/ShowSelectedFile.js"></script>
      <link rel="stylesheet" type="text/css" href="../plugins/FileBrowser/ShowSelectedFile.css">

   </head>
   <body>
      <script type="text/javascript" >
         function selectTab(theTab){
           // console.debug("controlpanel.php::selectTab::ENTER");
           // console.debug("controlpanel.php::selectTab::tab [ "+theTab+" ]");
            
             $(".menuItem").each(function () {
	              // console.debug("controlpanel.php::selectTab::[ " + $(this).html().trim() + " ]");
	               if ($(this).html().trim().toUpperCase() == theTab.trim().toUpperCase()){
	                  //console.debug("controlpanel.php::selectTab:: The [ " + theTab +" ] has been selected");
	                  $(this).css("border-bottom-style","none");
	                  $(this).css("background-color","#ff6600");
	                  $(this).css("color","white");
	                  
	               }else{
	                  $(this).css("border-bottom-style","solid");
	                  $(this).css("background-color","white");
	                  $(this).css("color","#ff6600");
	               }
               }
            );
           // console.debug("controlpanel.php::selectTab::EXIT");
            
         }

      </script>
   
      <div id="main">
         <div id="header">      
            
            <div id="logo">
               <img src="../images/logoCMYKwithoutBorder.jpg" alt="MEM Cakes & Cookies" title="MEM Cakes & Cookies"/>
            </div>
            <div id="centerHeader">
               <h1>Panel de Administracion</h1>
            </div>
            <div id="rightHeader">
               <div id="usuario">               
                  Usuario:
               </div>
               <div id="user">
                  <?php
                     $user = $_SESSION['user'];
                     printf("%s\n", $user);
                  ?>
                  </div>
                  <div id="exit">
                     <a href="./logout.php">Salir</a>
                  </div>
            </div>
         </div>
     
     <div id="data">
       <div id="div_menu">
            <?php
                  
                 require_once($_SERVER['DOCUMENT_ROOT'].'/php/ddbb/DBIterator.php');
                 require_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_MENUS.php');
                 require_once($_SERVER['DOCUMENT_ROOT'].'/php/localDB/TB_COLLECTION.php');
                 require_once($_SERVER['DOCUMENT_ROOT'].'/php/localConfiguration/configuration.php');
                 $options = TB_MENUS::getMenu();
            ?>
          
               <?php
                 while ($options->next()){
                    $row = $options->getRow();   
      
                    if ($row->getId() != 1 && $row->getId() != 6){
                    ?>
                       <a href=<?php printf("\"%s/controlpanel/controlpanel.php?option=%s\"", url, $row->getOption());?> >
                       <div class="menuItem"> 
                             <?php printf("%s", $row->getOption()); ?>
                          
                       </div>
                       </a>
                    <?php
                    }
                  }
                ?>
            
             
        </div>
        <script type="text/javascript" >
        
           selectTab(<?php printf("'%s'", $_GET['option']);?>);

        </script>
        
        <div id="controles">
           <?php
              
              $idOption = TB_MENUS::getIdByOption($_GET['option']);
           ?>
           <div id="toolbar">
              Colecciones:
              <?php
                 $subMenus = TB_COLLECTION::getCollectionsFromMenu($idOption);
              ?>
              <select id="comboCollection">
                 <option value="0">Todas</option>
                 <?php
                 while($subMenus->next()){
                 ?>
                    <option value=<?php printf("\"%d\"", $subMenus->getRow()->getId());?>><?php printf("%s", $subMenus->getRow()->getName());?></option>
                 <?php
                 }
                 ?>
              </select>
              <button id="btnAdd">Añadir</button>
           </div>
           <script type="text/javascript" >
              
              $("#btnAdd").click(function(){
                                            newcollection.show(
                                                  {
                                                      idCollection:<?php printf("%d",$idOption);?>,
                                                      url:<?php printf("'./insertSubmenu.php'");?>
                                                      }
                                              );
                                            }
                                );
           </script>
           <div id="images">
               <?php 
                     require_once(dirname(__FILE__).'/ShowImages.php');
                 ?>
           
              <!--  <div id="images_gallery">
                Gallery
              </div> -->
              <!-- 
              <div id="All_images">
                 <?php 
                     require_once(dirname(__FILE__).'/ShowImages.php');
                 ?>
              </div>
              <div id="Collection_images">
              <button id="BtnFileBrowser">Seleccionar Imagen</button>
              <script type="text/javascript" >
                 $('#BtnFileBrowser').click(function(){
                    FileBrowser.init({title: <?php printf("\"%s\"",$_GET['option']);?>+" / "+$('#comboCollection>option:selected').text(),
                        buttons: "upload|select|delete",
                        pathUploadFile: "images/cakes",
                        color_selected_file: "orange",
                        server_type: "Database",
                        custom_params: {option:<?php printf("\"%s\"",$_GET['option']);?>,
                                        collection:$('#comboCollection>option:selected').text()}});
                    FileBrowser.show();
                 }
                 );
              </script>
              </div>
              -->
           </div>
        </div>

     </div>      
   </div>
   <script type="text/javascript" >
      setFunctionsToObjects(<?php printf("'%s'", $_GET['option']);?>);
   </script>
   </body>

</html>