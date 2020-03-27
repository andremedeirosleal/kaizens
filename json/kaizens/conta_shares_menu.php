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

//CONTA SHARES DA VM
$sql="SELECT count(codigo) total FROM share_kaizens WHERE diretoria = 1  and data_share >= DATE_ADD(CURDATE(), INTERVAL -60 DAY) group by cod_kaizen" ;
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$total_vm = mysqli_num_rows($result);

//CONTA SHARES DA GERENCIA DO USUÁRIO LOGADO
mysqli_select_db($con,"share_kaizens");
$sql="SELECT count(codigo) total FROM share_kaizens WHERE cod_sup is null and cod_ger = ".$_SESSION['ID_GERENCIA'] ." and data_share >= DATE_ADD(CURDATE(), INTERVAL -60 DAY) group by cod_kaizen";
$result = mysqli_query($con, $sql) or die("Error: ".mysqli_error($con));
$row = mysqli_fetch_array($result);
$total_ger = mysqli_num_rows($result);

//CONTA SHARES DA SUPERVISÃO DO USUARIO LOGADO
$sql="SELECT count(codigo) total FROM share_kaizens WHERE cod_sup = " .$_SESSION['ID_SUPERVISAO'] ." and data_share >= DATE_ADD(CURDATE(), INTERVAL -60 DAY)  group by cod_kaizen";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$total_sup = mysqli_num_rows($result);

$total = $total_vm + $total_ger + $total_sup;
if ($total > 0) $color = "yellow";
else $color = "white";

//IMPRIME NO FORMATO DE MENU
echo '
	<a title="Kaizens marcados como recomendados" id="menu" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">	
		Recomendados 
		<span  class="glyphicon glyphicon-bell"></span>
		('.$total.')
									
	</a>			
	<ul  class="dropdown-menu menuUsers">
		<li><a id="total_vm"  title= "Kaizens recomendados para toda EFVM (últimos 60 dias)" href="preview.php?share=1" class="parent">Para EFVM ('.$total_vm.')</a> </li>
		<li><a id="total_ger" title= "Kaizens recomendados para minha gerência (últimos 60 dias)" href="preview.php?share=2" class="parent">Para '.$_SESSION['NM_GERENCIA'].' ('.$total_ger.')</a></li> 
		<li><a id="total_sup" title= "Kaizens recomendados para minha supervisão (últimos 60 dias)" href="preview.php?share=3" class="parent">Para '.$_SESSION['NM_SUPERVISAO'].' ('.$total_sup.')</a></li> 
		<li><hr class="meuhr"></li>
		<li><a title="Todos os Kaizens recomendados até hoje" href="preview.php?share=4" class="parent">Todos</a></li>
	</ul>
	';


mysqli_close($con);
?>
</body>
</html>