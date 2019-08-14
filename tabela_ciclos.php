<?php
include_once 'conecta.php'; 
  
$consulta = "select * from ciclo";
$con      = $conexao->query($consulta) or die($conexao->error);

?>




<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <meta charset="UTF-8">
        <title>:..   E2C   ..:</title>
    </head>
    
    <body>
     <center>
   
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="navbar navbar-dark bg-primary" id="textoNavbar">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
          <a class="nav-link" href="index.html">Página Inicial</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="tabela_ciclos.php">Iniciar Ciclo</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="cadastro_ciclo.html">Cadastrar Ciclo</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="ciclo_ativo.php">Ciclo Em Execução</a>
      </li>
    </ul>
  </div>
</nav>

         
         </br>
        </br>
        
 <div class="container">       
        <table  class="table table-list-search">
    <tr>
      <td>ID </td>
      <td>Espécie </td>
      <td>Temperatura Máxima </td>
      <td>Tempatura Mínima</td>
      <td>Umidade Mínima</td>
      <td>Umidade Máxima</td>
      <td>Dias de Encubação</td>
      <td>Primeira Rolagem</td>
      <td>Quantidade Rolagem</td>
    </tr>
    <?php while($dado = $con->fetch_array()) { ?>
    <tr>
      <td><?php echo $dado['id_ciclo']; ?></td>
      <td><?php echo $dado['especie']; ?></td>
      <td><?php echo $dado['temperatura_mini']; ?></td>
      <td><?php echo $dado['temperatura_max']; ?></td>
       <td><?php echo $dado['umidade_mini']; ?></td>
        <td><?php echo $dado['umidade_max']; ?></td>
         <td><?php echo $dado['dias']; ?></td>
          <td><?php echo $dado['primeira_rolagem']; ?></td>
           <td><?php echo $dado['rolagem_diarias']; ?></td>
    </tr>
    <?php } 
    ?>
  </table>
 </div> 
        
        
        </br></br></br></br>
        
        
        <form action="start_ciclo1.php" method="post" id="formFooter">
        
        <li>Por favor, informe o Id do ciclo desejado!</li>
             <br/>

             <b>ID Ciclo:</b>              
             <input type="number" name="id_ciclo" required="">  
             <input type="submit" name="submit" value="Pronto">
                                 <br/>
            </form>      
        
        </br></br>
          
     </center>
    </body>
</html>
