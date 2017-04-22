<?php
	session_start();
	//require_once("../controlador/bitacora.php");
	if($_SESSION['bandera'] !=1 ){
      ?>
		  <script type="text/javascript">
            window.location="../vista/login.php";
          </script>
      <?php
  }else{
    if($_SESSION['tipo']<1 && $_SESSION['tipo']>2){
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
<title>Registro</title>
	<link rel="icon" type="image/ico" href="assets/images/icono.ico"/>
    <link rel="stylesheet" href="assets/css/bootstrap.css" media="screen"/>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="assets/css/bootswatch.min.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript" language="javascript" src="t.js"></script>
	
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
              	<a href="index.php" onClick="pregunta()">Inicio</a>
            	</li>
            	<li>
              	<a href="agregarDatos.php" onClick="pregunta()">Bitácora</a>
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
      <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
        	<div class="panel panel-default">
        		<div class="panel-heading">
			    	<h3 class="panel-title" align="center" id="panelHea">Datos de la bitácora</h3>
			 	</div>
			 	<div class="panel-body">
			    <form method="post">
                	<div id="input1" class="clonedInput"><br/>
                    <fieldset>
           				<legend align="center"></legend>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6" align="center">
                                <div class="form-group">
                                    <label class="control-label" >Fecha</label>
                                    <input type="date" name="date1" class="form-control input-group-lg" placeholder="Fecha">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6" align="center">
                                <div class="form-group">
                                    <label class="control-label">Pago por la gasolina</label>
                                    <input type="text" name="pago1" class="form-control input-group-lg" placeholder="$">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6" >
                                <div class="form-group" align="center">
                                    <label class="control-label">Kilometraje</label>
                                    <input type="text" name="km1" class="form-control input-group-lg" placeholder="Km">
                                </div>
                            </div>
                        </div>
                 </fieldset>
              	</div>
                      <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6" >
                            <label class="control-label">¿Añadir más campos?</label>
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5">
                                <input type="button" id="btnAdd" class="btn btn-toolbar" value="+" />
                             </div>
                             <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5">
                                <input type="button"  id="btnDel" class="btn btn-warning" value="-" />
                            </div>
                         </div>
                        </div><br/>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                               <!-- <input type="hidden" name="funcion" value="agregarBitacora"> -->
                               <input type="submit" id="add" value="Aceptar" class="btn btn-info btn-block">
                             </div>
                             <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                               <input type="submit" value="Cancelar" class="btn btn-danger btn-block" id="cancelar">
                             </div>          
                        </div>
                	
			    </form>
			    </div>
	    	</div>
    	</div>
    	</div> 
    </div><br/><br/><br/>
    <div  align="center">
		<img class="img-responsive" src="assets/images/pie.png" width="1500" height="120">
    </div>
</body>
</html>