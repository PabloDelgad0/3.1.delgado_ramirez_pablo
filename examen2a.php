<?php
//Oscar Boronat Doval
//Examen 1 Ev2 PHP
//Fecha 12/02/2020
//examen2a.php

include "./comunExamen.php";

/* COOKIES */
if(isset($_COOKIE['visitas'])){
	setcookie('visitas', $_COOKIE['visitas']+1, time() + 3600 * 24 * 30);
	$contadorVisitas = $_COOKIE['visitas']+1;
}
else{
	setcookie('visitas', 1, time() + 3600 * 24 * 30);
	$contadorVisitas = 1;
}

/* CONTROL DEL FORMULARIO */

if( empty($_POST) || empty( $_POST['enviar'] ) || $_POST['enviar'] != 'CONSULTAR' ){       
    printf("<h3>Debe rellenar el formulario.");
    header("./formEx2a.php");
    die("<h3> <a href='./formEx2a.php'>Volver al formulario</a> </h3>");
}

if( empty($_POST['pais']) || $_POST['pais'] == -1){
	printf("<h3>Debe elegir un pais");
    die("<h3> <a href='./formEx2a.php'>Volver al formulario</a> </h3>");
}

setcookie('pais', $_POST['pais']);

printf("
<!DOCTYPE html>
<html>
	<head>
		<meta charset='UTF-8'>
		<title>Formulario Paises-Piloto</title>
		<link rel='stylesheet' type='text/css' href='./style.css'>
	<head>
	<body>
		<h2>Oscar Boronat Doval</h2>
		<hr>
");

/* TABLA */

$mysqli = conectaF1();

$consulta = $mysqli->query("SELECT NOMBRE, FCH_NACIMIENTO FROM TPILOTO WHERE PAIS='" . $_POST['pais'] . "'");

if ( ! $consulta ){
	printf("Error al realizar la consulta.");
	die("Error en mysql");
}else{
	$filas = $mysqli->affected_rows;
	printf("<h3>Listando %d filas</h3>", $filas);
	printf("<table>");
	printf("<tr>
			<th>PILOTO</th>
			<th>FECHA NACIMIENTO</th>
		</tr>");
	while( $fila = $consulta->fetch_assoc() ){
		printf("<tr>");
		foreach($fila as $indice => $dato){
			printf("<td>%s</td>", $dato);
		}
		printf("</tr>");
	}
	printf("</table>");
}

$mysqli->close();	

printf("<br>Fecha y hora de la consulta: %s", date("d-m-Y H:i:s e",$_POST['fechahora']));


printf("
		<br><br>
		<a href='./formEx2a.php'>Formulario Paises-Pilotos</a>
	</body>
</html>
");

?>