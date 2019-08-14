
<?php
        include_once 'conecta.php';
        session_start();

 $cliente = $_POST["cliente"];
 $_SESSION["cliente"] = $cliente;
 $senha=$_POST["senha"];
 
$consulta = "select * from clientes where cliente like'%$cliente'";
$con      = $conexao->query($consulta) or die($conexao->error);

$consultaa = "select * from producao where cliente like'%$cliente'";
$conn      = $conexao->query($consultaa) or die($conexao->error);

 while($dado = $con->fetch_array()) { 
if(($dado['cliente']==$cliente)&&($dado['senha']==$senha))  {
//header("Location: tabela_ciclos.php");
$achou=1;
} 
 }
    while($dad = $conn->fetch_array()) { 
         if (($dad['cliente'] == $cliente)) {
           $encontrou=1;
        } 
    }
  
 if(($achou == 1) && ($encontrou == 1)){
     header("Location: ciclo_ativo.php");
 }
  if($achou == 1 && ($encontrou !=1)){
     header("Location: tabela_ciclos.php");
 }
        
 if($achou==0){
  if (($cliente==admin) &&($senha==123)){
     header("Location: ADM.php");
 } else {
      header("Location: login.php");
 }
 }
 ?>
    