<?php
include_once 'conecta.php';

 session_start();
 
 date_default_timezone_set('America/Sao_Paulo');
 
$id_ciclo = $_POST["id_ciclo"]; 


$consulta = "select * from ciclo where id_ciclo like'%$id_ciclo'";
$con      = $conexao->query($consulta) or die($conexao->error);


while($dado = $con->fetch_array()) { 
    if($dado['id_ciclo']==$id_ciclo){
        $dias=$dado['dias'];
         $_SESSION["dias"] = $dias;
         $primeira_rolagem=$dado['primeira_rolagem'];
         $_SESSION["primeira_rolagem"] = $primeira_rolagem;
    $achou=1;
} 
else {
    $achou=0;
}
}
if ($achou==1){
    
    if (isset($_POST['id_ciclo'])){
    $id_ciclo=$_POST["id_ciclo"];
    $cliente = $_SESSION["cliente"];
    
    $url = 'http://192.168.1.3/iniciarCiclo';
   $contents = file_get_contents($url);
    
    $teste = '+ '.$dias.' days';
    $data_fim = date('Y/m/d', strtotime($teste));
    $data_inicio = date('Y/m/d');
     
  $sql = "insert into producao (id_ciclo,cliente,data_inicio,data_fim,hora_inicio) values ('$id_ciclo','$cliente','$data_inicio','$data_fim',time(current_timestamp))";
  $resultado = $conexao->query($sql);
  
$consulta1 = "select * from producao";
$con1      = $conexao->query($consulta1) or die($conexao->error);


  
  $teste1 = '+ '.$primeira_rolagem.' days';
  $data_rolagem = date('Y/m/d', strtotime($teste1));
  
  $hora_rolagem = date('H:i', strtotime('+2 minutes'));
  
  $sql1 = "insert into horarios (chocadeira,data_rolagem,hora_rolagem) values ('192.168.1.3','$data_rolagem','$hora_rolagem')";
  $resultadoo = $conexao->query($sql1);
 
       /// ACIONANDO CICLO///// 
  header("Location:ciclo_ativo.php");
       
  //unset($_SESSION["cliente"]);
  unset($_SESSION["dias"]);
  unset($_SESSION["primeira_rolagem"]);
    }
} 
else{
    header("Location: tabela_ciclos.php");
}



?>
