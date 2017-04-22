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
  require_once ("../controlador/usuario.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Registro de Usuarios</title>
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
      <section id="login_fondo">
      	<form action="" method="post">
         	<table align="center">
            <fieldset>
           		<legend align="center">Datos del usuario</legend>
                <label class='control-label' aling="center">Selecciona el tipo de usuario a registrar:</label>
                <div class="radio">
                   <label class="control-label">
                     <input type="radio" name="usuario" id="empl" value="1" onclick="mostrarReferencia();">Empleado
                   </label>
                </div>
                <div  class="radio">
                   <label class="control-label">
                     <input type="radio" name="usuario" id="cond" value="2" onclick="mostrarReferencia();">Conductor
                    </label>
                </div>
				<tr>
				 	<td><label class="control-label">Nombre</label></td>
            		<td><input type="text" class="form-control" name="nombre" placeholder="Nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Sólo deben ser letras" required /><br/></td>
				</tr>
				<tr>
			       <td><label class="control-label">Apellido Paterno</label></td>
			       <td><input type="text" class="form-control" name="paterno" placeholder="Paterno" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Sólo deben ser letras" required/><br /></td>
			    </tr>
          <tr id="datosE" style="display:none;">
			       <td><label class="control-label">Apellido Materno</label></td>
			       <td><input type="text" class="form-control" name="materno" placeholder="Materno" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Sólo deben ser letras" /><br /></td>
			    </tr>
					<tr id="datosC" style="display:none;">
						 <td><label class="control-label">Tipo conductor</label></td>
						 <td>
							 <select class="selectpicker show-tick form-control"  id="lista" name="tipo">
								  <option value="0">Selecciona una opción</option>
								  <option value="1">Oficial</option>
								  <option value="2">De apoyo</option>
								</select> <br />
						 </td>
					</tr>
		       <tr>
		          <td><label class="control-label">Usuario</label></td>
		          <td><input type="text" class="form-control" name="user" placeholder="Usuario" title="Sólo deben ser letras" required/><br /></td>
		      </tr>
              <tr>
		          <td><label class="control-label">Contraseña</label></td>
		          <td><input type="password" class="form-control" name="pass" placeholder="Contraseña" required/><br/></td>
		      </tr><br/>
            <br/>
          <tr>
              <td align="center">
                  <input type="hidden" name="funcion" value="agregar_user"/>
                  <input type="submit" value="Aceptar" class="btn btn-primary"/>
                  <input type="button" class="btn btn-primary" value="Cancelar" onclick="pregunta()" id="cancelar"/>
              </td>
          </tr>
           </fieldset>
		</table>
        </form>
      <br/>
      </section><br/>
    </div>
    <div  align="center">
		<img class="img-responsive" src="assets/images/pie.png" width="1500" height="120">
    </div>
    <!-- <script type="text/javascript" language="javascript" src="jquery-1.11.1.min.js"></script> -->
	<script type="text/javascript" language="javascript">
	$(document).ready(pregunta);
		function pregunta(){
			if (confirm('¿Esta seguro de cancelar?')){
				window.location="../vista/indexA.php";
			}
		}
		function mostrarReferencia(){
			if(document.getElementById("cond").checked == true){
				document.getElementById('datosE').style.display='block';
				document.getElementById('datosC').style.display='block';
			}
			if(document.getElementById("empl").checked == true){
				document.getElementById('datosE').style.display='none';
				document.getElementById('datosC').style.display='block';
			}
		}
	</script>
</body>
</html>
