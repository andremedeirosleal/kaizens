<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php

session_start();

$con = mysqli_connect('localhost','automacao','@utomaca0','KAIZENS');
mysqli_set_charset($con, "utf8");	//Configuração de idioma
if (!$con) {
    echo "Erro ao conectar-se ao banco.";
}else{
	//$q = "1,1,1,100";
	$q = $_GET['q'];
	$q = $_SESSION['ID_USUARIO'] .",".$q;
	
	
	mysqli_select_db($con,"share_kaizens");
	$sql="insert into share_kaizens (data_share, user, diretoria, cod_ger, cod_sup,cod_kaizen) values (curdate(),".$q.")";
	$result = mysqli_query($con,$sql);

	
	
	
	if ($result)
		echo "OK";
	else
		echo "ERRO";

	mysqli_close($con);
	
	
}
?>
</body>
</html>