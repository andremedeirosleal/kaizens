<!DOCTYPE html>
<html>
<head>
</head>

<style type="text/css">
    body{ font-family: Arial; }
  .meuhr{
    /*height: 0px;*/
    margin: 5px;
   }

   .btn-default{
    position: relative;
    color: #007E7A;
    top: 10px;
    border: 1px solid #D0D0D2;
    border-radius: 3px;
   }
  .navbar-brand:active, .navbar-brand:visited{
      color: white;
  }
  .navbar-brand:hover{
    color: #ECB11F;
  }
  .navbar{
    background-color: #007E7A;
    box-shadow: 0px 0px 5px #747678 ;
  }
  .navbar-nav > .open > a:visited, .navbar-nav > .open, .nav .open > a, .nav .open > a:focus   {background-color: #007E7A;}
    
    .menuUsers{
      background-color: #e6e6e7;
    }
    .navbar ul li ul li a{
      color: black;
    }
    .navbar ul li ul li a:hover{
      color: #ECB11F;
      /*background: #e6e6e7;*/
    }
  .navbar ul li a, .navbar-brand{
  color: white;
  }
  .navbar-toggle > .icon-bar{
        background-color: #747678;
  }
  .navbar-toggle  {
    border: 1px solid white;
  }

  .navbar-nav > li > a:hover, .navbar-nav > li > a:active, .nav > li > a:focus {
    color: #ECB11F;
    background-color: #007E7A;    
  }

.usuarioLogado{
  position: absolute;
  color: white;
  top: 0px;
  font-style: italic;
}

.glyphicon-user a{
  position: absolute;
  left: -10px;
  top: 0px;
  color: white;
}
.glyphicon-user:hover{
  color: #ECB11F ;
}
  .ativado{
    background: #747678;
    box-shadow: 0px 0px 5px #747678;
  }

</style>
<body>

<?php
//Não exibe warnings
error_reporting(0);
ini_set("display_errors", 0 );
session_start();

include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php");
mysqli_select_db($con, "KAIZENS");

//CONTA REPLICACOES DA DIRETORIA
$sql="SELECT COUNT(ID_REPLICACAO_KAIZEN)total FROM TBL_REPLICACOES_KAIZENS" ;
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$total_vm = $row['total'];

//CONTA REPLICACOES DA GERENCIA DO USUÁRIO LOGADO
mysqli_select_db($con,"share_kaizens");
$sql="SELECT COUNT(ID_REPLICACAO_KAIZEN)total, kaizens.gerencia FROM TBL_REPLICACOES_KAIZENS
LEFT JOIN kaizens on kaizens.codigo = TBL_REPLICACOES_KAIZENS.ID_KAIZEN_ORIGINAL
where kaizens.gerencia = ".$_SESSION['ID_GERENCIA']." GROUP BY kaizens.gerencia";
$result = mysqli_query($con, $sql) or die("Error: ".mysqli_error($con));
$row = mysqli_fetch_array($result);
$total_ger = $row['total'];

//CONTA SHARES DA SUPERVISÃO DO USUARIO LOGADO
$sql="SELECT COUNT(ID_REPLICACAO_KAIZEN)total, kaizens.supervisao 
FROM TBL_REPLICACOES_KAIZENS LEFT JOIN kaizens on kaizens.codigo = TBL_REPLICACOES_KAIZENS.ID_KAIZEN_ORIGINAL
where kaizens.supervisao = ".$_SESSION['ID_SUPERVISAO']." GROUP BY kaizens.supervisao";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$total_sup =  $row['total'];

$total = $total_vm + $total_ger + $total_sup;
if ($total > 0) $color = "yellow";
else $color = "white";

//IMPRIME NO FORMATO DE MENU
echo '
	<a title="Kaizens replicados" id="menu" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">	
		Replicações 
		<span  class="glyphicon glyphicon-duplicate"></span>
										
	</a>			
	<ul  class="dropdown-menu menuUsers">
		<li><a id="total_vm"  title= "Kaizens replicados EFVM" href="preview.php?replicados=1" class="parent">Replicados EFVM ('.$total_vm.')</a> </li>
		<li><a id="total_ger" title= "Kaizens replicados de minha gerência" href="preview.php?replicados=2" class="parent">Replicados '.$_SESSION['NM_GERENCIA'].' ('.$total_ger.')</a></li> 
		<li><a id="total_sup" title= "Kaizens replicados de minha supervisão" href="preview.php?replicados=3" class="parent">Replicados '.$_SESSION['NM_SUPERVISAO'].' ('.$total_sup.')</a></li> 
		<li><hr class="meuhr"></li>
		<li><a title="Todos os Kaizens recomendados até hoje" href="replicacoes.php" class="parent">Todos</a></li>
	</ul>
	';


mysqli_close($con);
?>
</body>
</html>