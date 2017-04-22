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
  require_once ("../modelo/usuario.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Consulta de Usuarios</title>
	<link rel="icon" type="image/ico" href="assets/images/icono.ico"/>
    <link rel="stylesheet" href="assets/css/bootstrap.css" media="screen"/>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="assets/css/bootswatch.min.css"/>
     <script type="text/javascript" language="javascript" src="jquery-1.11.1.min.js"></script>
	<script type="text/javascript" language="javascript">

      $(document).ready(function(cargar){
          $("#buscar").keyup(mostrar);
        }
      );
		function mostrar(){
		  var clave=$("#buscar").val();
		  $.ajax({
			url:"../controlador/buscarUser.php"
			,type: 'POST'
			,data:{
			  "clave" : clave
			}
			,success: function(datos){
			  $("#busqueda").html(datos);
			}
		  });
		}
	</script>
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
								<a href="indexA.php" onClick="pregunta()">Inicio</a>
						</li>
						<li>
								<a href="AgregarUsuario.php" onClick="pregunta()">Usuario</a>
						</li>
        	</ul>
          	<ul class="nav navbar-nav navbar-right">
            	<li><a href="cerrarsesion.php" onClick="pregunta()">Cerrar Sesión</a></li>
          	</ul>
        </div>
      </div>
    </div>
	<div class="wrapper" style="background-color: #ffffff"><br/>
        <div>
        	  <img src="assets/images/logocemitt.jpg" width="175px" height="175px" style="position:relative; left:10%">
        </div>
    </div><br/>
    <div class="container">
     <section id="fondo">
      <fieldset>
            <legend>Usuarios</legend>
          </fieldset>
            Buscar por nombre
            <input type="text" id="buscar"/>
      </section>
      <br/>
       <?php
	   		$user = new Usuario();
            $user->MostrarUsuario();
       	?>
        </form>
      <br/>
      </section><br/>
    </div>
    <div  align="center">
		<img class="img-responsive" src="assets/images/pie.png" width="1500" height="120">
    </div>
</body>
</html>
