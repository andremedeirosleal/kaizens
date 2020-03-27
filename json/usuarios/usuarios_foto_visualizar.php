<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php");
try{
	$codigo = $_REQUEST['codigo'];
	
	// Instancia o objeto PDO
	$pdo = new PDO( 'mysql:host='.$hostname_con.';dbname=USUARIOS', $username_con, $password_con );

	// executa a instrução SQL
	$consulta = $pdo->query( "SELECT ID_USUARIO, TP_FOTO_USUARIO FROM TBL_USUARIOS WHERE ID_USUARIO =" .$codigo);

	//Pega os dados do usuário através de um array
	$linha = $consulta->fetch( PDO::FETCH_ASSOC );
	
	//exibe a imagem
	Header( "Content-type: image/jpg"); 
	echo "{$linha['TP_FOTO_USUARIO']}";
	
	// fecho a conexão
	$pdo = null;
}catch ( PDOException $e ){
	//Caso ocorra uma exceção, exibe na tela
	//echo $e->getMessage();
}
?>