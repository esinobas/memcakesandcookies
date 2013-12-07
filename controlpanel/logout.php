<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>logout</title>
<meta name="generator" content="Bluefish 2.2.4" >
<meta name="author" content="Esteban Sinobas Carpio" >
<meta name="date" content="2013-12-03T12:37:42+0100" >
<meta name="copyright" content="">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="expires" content="0">
</head>
<body>

   <?php
      session_destroy();
      header("Location:../admin.php");
   ?>
</body>
</html>