<?php

/*$CantidadDiasHabiles = Evalua(DiasHabiles('2017/03/31','2017/04/21'));

echo   "DÍAS HABILES: ".$CantidadDiasHabiles."</br>"; */

$Miarrayfinal = data_last_month_day("2017/04/10");
echo "Final: ".$Miarrayfinal."<br/>";
$miArrayHoras = horaAleat();
//echo $Miarrayfinal;

function getUltimoDiaMes($fecha) {
  echo "fechaD: ".$fecha."<br />";
  $month = date('m',strtotime($fecha));
  echo "MES: ".$month."<br />";
  $year = date('Y',strtotime($fecha));
  echo "AÑO: ".$year."<br />";
  $ultimoDiaMes = date("Y-m-d",(mktime(0,0,0,$month+1,1,$year)-1));
  echo "ULTIMO DIAMES: ".$ultimoDiaMes;
}

function ultimaSemana($fecha){


}
//Ejemplo de uso
$ultimoDia = getUltimoDiaMes("2017-04-10");
echo $ultimoDia."<br/>";
//echo getUltimoDiaMes(2012,09)."<br/>";
/*
Resultado:
31
30
*/

/*for ($i=0; $i<sizeof($Miarrayfinal); $i++) {
   echo $Miarrayfinal[$i]."<br />";
}
$nodias = sizeof($Miarrayfinal);

for ($i=0; $i<sizeof($Miarrayfinal); $i++) {
   echo $miArrayHoras[$i]."<br />";
}*/

for ($i=0; $i<sizeof($Miarrayfinal); $i++) {
   $fecha = $Miarrayfinal[$i];
   $hora = $miArrayHoras[$i];

   echo $fecha."<br/>";
   echo $hora."<br/>";
}
/** Ultimo dia de este mes **/
function data_last_month_day($fecha_inicial) {
  echo "fechaL: ".$fecha_inicial."<br />";
  list($year,$mes,$dia) = explode("/",$fecha_inicial);
  $ini = mktime(0, 0, 0, $mes , $dia, $year);
  $month = date('m',$mes);
  $year = date('Y',$year);
  return date("d",(mktime(0,0,0,$month+1, 1,$year)-1));
};


//Función para obtener una hora aleatoria entre el horario laboral, es decir de 9:00 a 17:00 hrs
function horaAleat(){
  $ArrayHoras = array();
  $cont = 0;
    $hrIni=strtotime("09:00");
    $hrFin=strtotime("17:00");
    for($i=$hrIni; $i<=$hrFin; $i+=2400){
      $aleat = rand($hrIni,$hrFin); //rand(mínimo,máximo);
      $ArrayHoras[$cont] = date("H:00", $aleat);
      $cont++;
    }
  return $ArrayHoras;
}






//print_r($Miarrayfinal);
//1.- Pasar la fecha inicial y final a maketime y obtener un arreglo con todas los días intermedios.

function DiasHabiles($fecha_inicial,$fecha_final)
{
$newArray = array();
list($year,$mes,$dia) = explode("/",$fecha_inicial);
$ini = mktime(0, 0, 0, $mes , $dia, $year);
list($yearf,$mesf,$diaf) = explode("/",$fecha_final);
$fin = mktime(0, 0, 0, $mesf , $diaf, $yearf);

$r = 1;
while($ini != $fin)
{
$ini = mktime(0, 0, 0, $mes , $dia+$r, $year);
$newArray[] .=$ini;
$r++;
}
return $newArray;
}

//2.- Una función que evalué el arreglo de fechas obtenido, que contenga los feriados nacionales que correspondan (restando) y que reste los sábados y domingos.

function Evalua($arreglo)
{
$feriados = array(
'1/1', // Año Nuevo
'21/3', // Natalicio de Benito Juaréz
'13/4', // Jueves Santo
'14/4', // Viernes Santo
'16/4', // Domingo de Resurrección
'1/5', // Día del trbajo
'16/9', // Día de la Independencia
'2/11', //	Día de los Muertos
'20/11', // Revolución Mexicana
'24/12', // Noche buena
'25/12', //	Día de Navidad
);

$j= count($arreglo);
$dia_NoLab = 0;
$dia = 0;

for($i=0;$i<$j;$i++)
{
$dia = $arreglo[$i];

$fecha = getdate($dia);
$feriado = $fecha['mday']."/".$fecha['mon'];
if($fecha["wday"]==0 or $fecha["wday"]==6)
{
$dia_NoLab++;
echo "Dia Fin de Semana ". $feriado ."
";
}
elseif(in_array($feriado,$feriados))
{
$dia_NoLab++;
echo "Dia Festivo dentro del Arreglo de Festivos ". $feriado ."
";
}
}
$rlt = $j - $dia_NoLab;
echo "j= ". $j ." i= ". $i ."
";
return $rlt;
}

function fechasCincoDias($fecha){
  $ArrayFechas = array();
  $cont = 0;
  echo "NFECHA: ".$fecha."</br>";

  $fecha1 = strtotime($fecha);
  $mod_date = strtotime($fecha."+5 days");
 echo "FINAL: ".date("Y/m/d",$mod_date)."</br>";

  for($fecha1; $fecha1<$mod_date; $fecha1=strtotime('+1 day'.date('Y/m/d',$fecha1))){
    if((strcmp(date('D',$fecha1),'Sun')==0) || (strcmp(date('D',$fecha1),'Sat')==0)){
      $fecha1++;
    }
    else{
        $ArrayFechas[$cont] = date('Y/m/d',$fecha1);
        //print_r($ArrayFechas);
        $cont++;
    }
  }
    return $ArrayFechas;
}

function DiasHabilesCinco($fecha)
{
  $fecha_inicial = strtotime($fecha);
  $fecha_final  = strtotime($fecha."+5 days");

$newArray = array();
list($year,$mes,$dia) = explode("/",$fecha_inicial);
$ini = mktime(0, 0, 0, $mes , $dia, $year);
list($yearf,$mesf,$diaf) = explode("/",$fecha_final);
$fin = mktime(0, 0, 0, $mesf , $diaf, $yearf);

$r = 1;
while($ini != $fin)
{
$ini = mktime(0, 0, 0, $mes , $dia+$r, $year);
$newArray[] .=$ini;
$r++;
}
return $newArray;
}
?>
