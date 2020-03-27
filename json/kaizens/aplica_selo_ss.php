<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/funcoes.php");
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php");
session_start();

if (!$con) {
    echo "ERRO";
}else{
	
	if (isset($_GET['codigo']) && strlen($_GET['codigo'])> 0){
		
		$permitido = checapermissao(16);	
		if ($permitido){
			$codigo = $_GET['codigo'];			
			mysqli_select_db($con,"KAIZENS");
			$sql="insert into TBL_APROVACOES_SEGURANCA (ID_USUARIO, ID_KAIZEN,DT_APROVACAO) values ('".$_SESSION['ID_USUARIO']."',".$codigo.",curdate())";
			$result = mysqli_query($con,$sql);
			
			if ($result) echo "OK";
			else echo "ERRO";
			
			mysqli_close($con);
		}else echo "PERMISSAO";				
	}else echo "ERRO";
}
?>
</body>
</html>