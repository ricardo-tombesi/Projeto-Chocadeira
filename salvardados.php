<?php

include("conecta.php");

$temperatura = $_GET['temperatura'];
$umidade = $_GET['umidade'];
$luminosidade = $_GET['luminosidade'];
$bomba = $_GET['bomba'];
	
$sql="insert into historico (data,hora,temperatura,umidade,luminosidade,bomba) values (date(current_timestamp),time(current_timestamp),'$temperatura','$umidade','$luminosidade','$bomba')";
$resultado = $conexao->query($sql);
        
?>

