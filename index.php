<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>MEM Cakes & Cookies</title>
<meta name="generator" content="Bluefish 2.2.4" >
<meta name="author" content="Esteban Sinobas Carpio" >
<meta name="date" content="2013-11-19T17:05:19+0100" >
<meta name="copyright" content="">
<meta name="Description" content="Tartas (cakes) decoradas con fondant. Galletas (cookies) decoradas con fondant. Tartas de fantasia modeladas con fondant. Tartas y galletas de fondant en Madrid. Cakes and cookies with fondant in Madrid. Tartas y galletas para cumpleaños, comuniones y todo tipo de eventos y celebraciones">
<meta name="keywords" content="memcakesandcookies, cakes, cookies, cake, cookie, cupcakes, cupcake, tartas, galletas, cumpleaños, celebraciones, eventos, catering, bodas, comuniones, dulces">
<meta name="ROBOTS" content="INDEX, FOLLOW">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="expires" content="0">


<!-- Scripts -->
<script type="text/javascript" src="./scripts/SlideImages.js"></script>

 <!-- Styles -->
   
   <link rel="stylesheet" type="text/css" href="./style/StyleMain.css"> 
   
   
<?php
  require_once(dirname(__FILE__).'/php/localConfiguration/configuration.php');
?>
</head>
<body>

    <div id="Contenedor">
         <div id="Cabecera">
            
            <div id="Logo">
               <a href=<?php printf("\"%s\"", url);?>>
                  <img src="images/logoCMYKwithoutBorder.jpg" alt="MEM cakes and cookies" title="MEM cakes and cookies" >
               </a>
            </div>

            <div id="div_menu">
               <?php
                 require_once(dirname(__FILE__).'/menu.php');
               ?>
            </div>
         </div>
         <div id="Cuerpo">
         <?php
            $pageId = $_GET["pageId"];
            if ($pageId == "1"){
               require_once(dirname(__FILE__).'/about.php');            
            }
         ?>
         </div>
      </div>
    
</body>
</html>