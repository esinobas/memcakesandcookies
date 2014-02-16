<?php 
   session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
  
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>Admin MEM Cakes and Cookies</title>

  <script type="text/javascript" src="./scripts/jquery-1.9.0.js"></script>

  
  <style type="text/css">
body {
  background-color: white;
}
#contenedor {
  background-color: white;
  width: 500px;
  min-width: 500px;
  max-width: 500px;
  margin-right: auto;
  margin-left: auto;
}
#image {
  width: 90%;
  text-align: center;
}
#titulo {
  text-align: center;
}
#titulo h1 {
  font-family: "Helvetica";
  color: #ff9900;
  text-align: center;
  font-size: x-large;
  font-style: italic;
  font-weight: normal;
}
#labels {
  font-weight: normal;
  font-family: Helvetica;
  float: left;
  font-style: normal;
}
#inputs {
  font-family: Helvetica;
  color: #964b00;
  font-style: italic;
  padding-left: 10px;
}
.formLabel {
  text-align: right;
  font-style: normal;
  font-family: Helvetica;
  font-weight: normal;
  color: #ff9900;
  float: left;
  width: 20%;
  display: inline;
  padding-left: 10%;
}
.formInput {
  font-family: Helvetica;
  color: #964b00;
  font-style: italic;
  text-align: left;
  width: 65%;
  display: inline;
  float: left;
  padding-left: 5%;
}
#boton {
  font-family: Helvetica;
  text-align: center;
}
.textStyle {
  font-style: italic;
  font-family: Helvetica;
  color: #964b00;
}
#Error {
  font-family: Helvetica;
  font-weight: bold;
  margin-top: 8px;
  padding-top: 3px;
  text-align: center;
  background-color: white;
  color: red;
  
}

  </style>
</head>
   <body>
      <?php
         include_once('./php/login/login.php');
         $error = false;         
         if (isset($_POST["Boton"])){
            
            if (isset($_POST["user"]) && isset($_POST["password"])){
                  
               if (!checkLogin($_POST["user"],$_POST["password"])){
               
                  $error = true;
               }else{
                  $_SESSION['user'] = $_POST["user"];
                  header("Location:./controlpanel/controlpanel.php?option=Cakes");               
               }          
            }
         }
      ?>
      <div id="contenedor">
         <div style="width: 474px;" id="image"><img style="width: 300px; height: 221px;" alt="Logo" title="Logo" src="images/logoCMYKwithoutBorder.jpg"><br>
         </div>
      <div id="titulo">
         <h1>Administración de MEM Cakes And Cookies</h1>
      </div>
      <div id="form">
         <form action="" method="post">
            <div id="labelUser" class="formLabel">Usuario:</div>
            <div class="formInput"><input class="textStyle" maxlength="30" name="user"></div>
            <div class="formLabel">Contraseña:</div>
            <div class="formInput"><input class="textStyle" maxlength="30" name="password" type="password"></div>
            <div id="boton"> <input name="Boton" value="Aceptar" type="submit"> </div>
         </form>
      </div>
      <?php
         if ($error == true){
         ?>   
            <div id="Error">
               Has introducido mal el usuario o la contraseña. Vuelve a intentarlo
            </div>
         <?php
         }
         ?>
   </div>

<!-- Contendor -->
</body></html>