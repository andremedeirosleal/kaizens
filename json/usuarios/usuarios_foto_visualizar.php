<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php");
try{
	$codigo = $_REQUEST['codigo'];
	
	// Instancia o objeto PDO
	$pdo = new PDO( 'mysql:host='.$hostname_con.';dbname=USUARIOS', $username_con, $password_con );

	// executa a instru��o SQL
	$consulta = $pdo->query( "SELECT ID_USUARIO, TP_FOTO_USUARIO FROM TBL_USUARIOS WHERE ID_USUARIO =" .$codigo);

	//Pega os dados do usu�rio atrav�s de um array
	$linha = $consulta->fetch( PDO::FETCH_ASSOC );
	
	//exibe a imagem
	Header( "Content-type: image/jpg"); 
	echo "{$linha['TP_FOTO_USUARIO']}";
	
	// fecho a conex�o
	$pdo = null;
}catch ( PDOException $e ){
	//Caso ocorra uma exce��o, exibe na tela
	//echo $e->getMessage();
}
?>