<?php
include_once 'conecta.php';


$cliente = $_POST["cliente"]; 

$consulta = "select * from clientes where cliente like'%$cliente'";
$con      = $conexao->query($consulta) or die($conexao->error);

 while($dado = $con->fetch_array()) { 
if($dado['cliente']==$cliente)  {
$achou=1;

header("Location: usuario_igual.html");
}



else{ 
    $achou=0;
}  
 }
if($achou==0){
    
//<!--conecta ao banco e salva-->

if (isset($_POST['cliente'])){
  $cliente=$_POST["cliente"];
  $senha = $_POST["senha"];

    $sql="insert into clientes (cliente,senha) values ('$cliente','$senha')";
    $resultado = $conexao->query($sql);
        header("Location: login.php");
}
}


    ?>

