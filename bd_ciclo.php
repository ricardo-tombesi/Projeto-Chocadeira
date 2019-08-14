<?php

include_once 'conecta.php';

$especie = $_POST["especie"]; 

$consulta = "select * from ciclo where especie like'%$especie'";
$con      = $conexao->query($consulta) or die($conexao->error);

 while($dado = $con->fetch_array()) { 
if($dado['especie']==$especie)  {
$achou=1;
//header("Location: cadastro_usuario.html");

}
else{ 
    $achou=0;
}  
 }
if($achou==0){
//<!--conecta ao banco e salva-->

if (isset($_POST['especie'])){
  $especie=$_POST["especie"];  
  $temperatura_mini=$_POST["temperatura_mini"];
  $temperatura_max= $_POST["temperatura_max"];
  $umidade_mini=$_POST["umidade_mini"];
  $umidade_max= $_POST["umidade_max"];
  $dias= $_POST["dias"];
  $primeira_rolagem=$_POST["primeira_rolagem"];
  $rolagem_diarias= $_POST["rolagem_diarias"];
  

    $sql="insert into ciclo (especie,temperatura_mini,temperatura_max,umidade_mini,umidade_max,dias,primeira_rolagem,rolagem_diarias) values ('$especie','$temperatura_mini','$temperatura_max','$umidade_mini','$umidade_max','$dias','$primeira_rolagem','$rolagem_diarias')";
    $resultado = $conexao->query($sql);
        header("Location: ADM.php");
}
}
 ?>
 
 
