<?php
	session_start();
	if($_SESSION['bandera']!=1){
      ?>
		  <script type="text/javascript">
            window.location="../vista/login.php";
          </script>
      <?php
  }else{
    if($_SESSION['tipo']<1 && $_SESSION['tipo']>3){
      ?>
        <script type="text/javascript">
          window.location="../controlador/cerrarsesion.php";
        </script>
      <?php
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Página Principal</title>
	<link rel="icon" type="image/ico" href="assets/images/icono.ico"/>
    <link rel="stylesheet" href="assets/css/bootstrap.css" media="screen"/>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="assets/css/bootswatch.min.css"/>
</head>
<body>
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand"></a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
        	<ul class="nav navbar-nav">
                <li>
                    <a href="indexA.php">Inicio</a>
                </li>
                <!-- <li>
                    <a href="AgregarUsuario.php">Usuario</a>
                    <ul>
                        <li>
                            <a href="AgregarUsuario.php">Agregar</a>
                        </li>
                    </ul> 
                </li> -->
              <li>
                <a href="#"></a>
              </li>
            </ul> 
          	<ul class="nav navbar-nav navbar-right">
            	<li><a href="cerrarsesion.php">Cerrar Sesión</a></li>
          	</ul>
        </div>
      </div>
    </div>
	<div class="wrapper" style="background-color: #ffffff"><br/>
        <div>
        	  <img src="assets/images/logocemitt.jpg" width="175px" height="175px" style="position:relative; left:10%">
              <h1 id="titulo" class="page-header">Bienvenid@ <?php echo $_SESSION['nombre']; ?></h1>
        </div>
    </div>
    <div class="container">
      <section id="Datos">
      	<form action="" method="post">
            <table align="center">
            	<tr>
                  <td>&nbsp; 
                      <img src="assets/images/adduser.png"  width="110px" height="110px">
                     </td>
                     <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;  
                      <img  src="assets/images/search.png" width="110px" height="110px">
                     </td>
                     <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                      <img  src="assets/images/iconSearch2.png" width="110px" height="110px">
                     </td>
                </tr>
                <tr>
                  <td><br/>     
                  	<a href="AgregarUsuario.php" class="btn btn-primary" role="button">Registrar usuario</a>
                  </td>
                  <td><br/>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                      <a href="mostrarUsuario.php" class="btn btn-primary" role="button">Mostrar usuarios </a>
                  </td>
                  <td><br/>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                      <a href="mostrarConductor.php" class="btn btn-primary" role="button">Mostrar conductores </a>
                  </td>
                </tr>
            </table>  
        </form>
      <br/>
      </section>
    </div>
    <div id="footer">
    	<img class="img-responsive" src="assets/images/pie.png" width="1500" height="120">
    </div> 
</body>
</html>