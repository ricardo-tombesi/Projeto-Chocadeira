<?php

 include("conecta.php"); 
 
  date_default_timezone_set('America/Sao_Paulo');
  $correto=0;

  // consultas ao banco de dados
$consulta = "select data_rolagem,hora_rolagem from horarios order by id_horarios desc limit 1";
$con      = $conexao->query($consulta) or die($conexao->error);


$consultaa = "select * from producao";
$conn     = $conexao->query($consultaa) or die($conexao->error);

$procura = "select * from ciclo";
$pro  = $conexao->query($procura) or die($conexao->error);


 ////////
// colocando em sessao as rolagem 
while($item = $pro->fetch_array()) { 
    
    $rolagem_diarias = $item['rolagem_diarias'];
    $_SESSION["rolagem_diarias"] = $rolagem_diarias;
    
}

// testando se terminu o ciclo
while($dadoo = $conn->fetch_array()) { 
  // função para trabalhar com a hora
    $hora_atual = date('H:i:s');
    $horal_atual2 = date('H:i:s',strtotime('-1 minutes'));
    
    if ( $dadoo ['data_fim'] == date('Y-m-d') && $dadoo ['hora_inicio'] <= $hora_atual && $dadoo['hora_inicio']>$horal_atual2){
           
     /// Encerrar cicloooooo
        /////enviar pro arduinoooo
    $url = 'http://192.168.1.4/encerarCiclo';
    $contents = file_get_contents($url);
    } else{
        
while($dado = $con->fetch_array()) { 
    // funçao para calculo da hora
    $hora_atual = date('H:i:s');
    $horal_atual2 = date('H:i:s',strtotime('-1 minutes'));
    echo $hora_atual;
    echo '</br>';
    echo $horal_atual2;
    echo '</br>';
    echo $dado['hora_rolagem'];
    echo '</br>';
    
    if ($dado['data_rolagem'] == date('Y-m-d')) {

        if ($dado['hora_rolagem'] <= $hora_atual && $dado['hora_rolagem'] > $horal_atual2) {

            echo 'So felicidade';
        
            $correto = 1;
            
        } 
        
        echo 'dias certos';
        
       } 
}
}
}       
        if ($correto == 1){  
           /// função para calcular nova hora
         $valor = 24/$rolagem_diarias;
         $quant = 'PT'.$valor.'H';
        
        $data_rolagem = new DateTime('America/Sao_Paulo');
        $data_rolagem->add(new DateInterval($quant));
        $data_rolagem->format('Y-m-d') . "\n"; 
      
        $data_rolagem1 = $data_rolagem->format('Y-m-d');
        $hora_rolagem = $data_rolagem->format('H:i:s');    
      
        /// envia pro banco no dada de rolagem
        $sql = "insert into horarios (chocadeira,data_rolagem,hora_rolagem) values ('192.168.1.3','$data_rolagem1','$hora_rolagem')";
            $resultadoo = $conexao->query($sql);
      
    $url = 'http://192.168.1.3/ligar';
    $contents = file_get_contents($url);
    
    
    
  
} else {
    
       echo '</br>';
       echo 'nada pra fazer por aqui';    
       }
      
?>
