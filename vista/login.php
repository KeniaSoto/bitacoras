<?php
	session_start();
	require_once("../controlador/sesion.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Inicio de sesión</title>
	<link rel="icon" type="image/ico" href="assets/images/icono.ico"/>
    <link rel="stylesheet" href="assets/css/bootstrap.css" media="screen"/>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="assets/css/bootswatch.min.css"/>
    <!-- All the files that are required -->
    <!-- <link rel="stylesheet" href="assets/css/prueba1.css"/> -->
	<!-- <script src="assets/js/prueba1.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> -->

</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
        </div>
      </div>
    </div>  
    <div class="wrapper" style="background-color: #ffffff">
        <div>
        	  <img src="assets/images/logocemitt.jpg" width="175px" height="175px" style="position:relative; left:10%">
              <img src="assets/images/morelos.jpg" width="175px" height="175px" style="position:relative; left:70%">
        </div>
    </div>
    <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="assets/images/avatar.png"/>
            <p id="profile-name" class="profile-name-card">Bienvenido</p><br/>
            <form class="form-signin" method="post">
            	<input type='text' name="usuario" class='form-control' placeholder='Usuario' required/>
                <input type="password" name="password" class='form-control' placeholder='Contraseña' required/>
                
                <input type="hidden" name="funcion" value="inicioSesion"/>   
				<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Iniciar Sesión</button>
            </form>
        </div><!-- /card-container -->
    </div><!-- /container -->
    <div  align="center">
		<img class="img-responsive" src="assets/images/pie.png" width="1330" height="120">
    </div> 
</body>
</html>