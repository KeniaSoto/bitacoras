	var contElemt = 1;
	var contCampos = 1;
	var arrCampos = [];
	var arrValores = [];

	$(document).ready(function () {

		$("#btnAdd").click(function () {
			agregarNuevosCampos();
		});

		$("#btnDel").click(function () {
			removerCampos();
		});

		$("#add").click(function () {
			guardarCampos();
		});
	});


	function agregarNuevosCampos() {
		$("#formCampos").append("<div id='campos" + contCampos + "' class=''>" +
				" <fieldset>"+
				" <legend align='center'></legend>"+
				" <div class='row'>" +
				"   <div class='col-xs-6 col-sm-6 col-md-6' align='center'>" +
				"      <div class='form-group'>" +
				"         <label class='control-label' >Fecha</label>" +
				"        <input type='date' name='date" + contElemt + "' id='date" + contElemt + "' class='form-control input-group-lg' placeholder='Fecha'>" +
				"   </div>" +
				"</div>" +
				"<div class='col-xs-6 col-sm-6 col-md-6' align='center'>" +
				"   <div class='form-group'>" +
				"      <label class='control-label'>Pago por la gasolina</label>" +
				"     <input type='text' name='pago" + contElemt + "' id='pago" + contElemt + "' class='form-control input-group-lg' placeholder='$'>" +
				" </div>" +
				"</div>" +
				"</div>" +
				"<div class='row'>" +
				"   <div class='col-xs-6 col-sm-6 col-md-6' >" +
				"      <div class='form-group' align='center'>" +
				"         <label class='control-label'>Kilometraje</label>" +
				"        <input type='text' name='km" + contElemt + "' id='km" + contElemt + "' class='form-control input-group-lg' placeholder='Km'>" +
				"   </div>" +
				"</div>" +
				"</div>" +
				"</div>" +
				"</fieldset>");
		arrCampos.push({campo: contCampos, values: [{date: 'date' + contElemt, pago: 'pago' + contElemt, km: 'km' + contElemt}]});
		contCampos++;
		contElemt++;
		console.log(arrCampos);
	}

	function removerCampos() {
		console.log(arrCampos[arrCampos.length - 1].campo);
		$("#campos" + arrCampos[arrCampos.length - 1].campo).remove();
		arrCampos.splice(arrCampos.length - 1, 1);
		console.log(arrCampos);
	}

	function guardarCampos() {
		console.log("va a guardar campos");
		arrValores.push({
			date: $("#date0").val(),
			km: $("#km0").val(),
			pago:$("#pago0").val()
		});
		$.each(arrCampos, function (key, data){
			arrValores.push({
				date: $("#"+data.values[0].date).val(),
				km: $("#"+data.values[0].km).val(),
				pago:$("#"+data.values[0].pago).val()
			});
		});

	var arregloenjson = JSON.stringify(arrValores);
	console.log(arregloenjson);
	$.ajax({
        type: "POST",
        url: "../controlador/bita.php",
        data:{
				funcion : "agregarBitacora",
				valArray: arregloenjson
			},
        cache: false,
        success: function(data){
            arregloenjson=undefined;
						console.log(data)
        }
    });
		arregloenjson=[];
		arrValores=[];

}
