<?php

include("conecta.php"); // caminho do seu arquivo de conexão ao banco de dados
$consulta = "select * from historico order by hora desc limit 1";
$con      = $conexao->query($consulta) or die($conexao->error);

while($dado = $con->fetch_array()) { 
    $dado=['ciclo'];
    
}

if (dado==0){
    // Escolher o ciclo que vai ser usado 
    header("Location: inicial.php");
} else {
   // vai para mostrar como ta o ciclo 
    header("Location: cicloAtivo.php");
}

?>


