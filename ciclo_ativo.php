<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <meta charset="UTF-8">
        <title>:..   E2C   ..:</title>
    </head>
    <center>
    <body>
        <h1> Ciclo Ativo </h1>
        
        
   <?php
          session_start();
 
          date_default_timezone_set('America/Sao_Paulo');
          
        include("conecta.php"); // caminho do seu arquivo de conexão ao banco de dados
        $consulta = "select * from historico order by id_historico desc limit 1";
        $con      = $conexao->query($consulta) or die($conexao->error);
        
         $consulta1 = "select * from producao";
         $con1      = $conexao->query($consulta1) or die($conexao->error);
        
        while($dado1 = $con1->fetch_array()) {
      $data_inicial = date('Y-m-d');
      $data_final = $dado1['data_fim'];
     $diferenca = strtotime($data_final) - strtotime($data_inicial);
     $dias_restantes = floor($diferenca / (60 * 60 * 24));

        }
        
   ?>
  <div class="container">  
  <table  class="table table-list-search">
    <tr>
      <td>Temperatura </td>
      <td>Umidade </td>
      <td>Luminosidade </td>
      <td>Data de Leitura </td>
      <td>Hora de Leitura </td>
      <td>Dias Restante</td>
    </tr>
    <?php while($dado = $con->fetch_array()) { ?>
   
    <tr>
      <td><?php echo $dado['temperatura']; ?></td>
      <td><?php echo $dado['umidade']; ?></td>
      <td><?php echo $dado['luminosidade']; ?></td>
      <td><?php echo date('d/m/Y', strtotime($dado['data'])); ?></td>
	  <td><?php echo $dado['hora']; ?></td>
      <td><?php echo $dias_restantes; ?></td>    
    </tr>
    <?php } ?>
  </table>
</div>
        
    </body>
    </center
    




    
</html>
