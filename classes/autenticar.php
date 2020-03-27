<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php");
include($_SERVER['DOCUMENT_ROOT']."/classes/funcoes.php");
session_start();
mysqli_select_db($con, 'USUARIOS');
?>

<html>
<head>
<title>Autenticando</title>
<link rel="shortcut icon" href="/images/icon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<script type="text/javascript">
	function loginfailed(){
		setTimeout("window.location='/classes/login.php'",1000);
	}
</script>
</head>

<body>

<?php
$user = $_POST['matricula'];
$senha = trim($_POST['senha']);
$senha_hash = hash('gost',$senha.$codigo_hash);

//tenta localizar com a senha sem hash
$sql = "SELECT 
TBL_USUARIOS.ID_USUARIO, TBL_USUARIOS.NM_USUARIO, TBL_USUARIOS.ID_USUARIO, TBL_USUARIOS.CD_MATRICULA, 
TBL_USUARIOS.DS_SENHA, TBL_USUARIOS.DS_EMAIL, TBL_USUARIOS.ID_SUPERVISAO, TBL_USUARIOS.ID_TURMA,
LOCACAO.TBL_SUPERVISOES.NM_SUPERVISAO,
LOCACAO.TBL_GERENCIAS.ID_GERENCIA, LOCACAO.TBL_GERENCIAS.NM_GERENCIA
FROM TBL_USUARIOS 
left join LOCACAO.TBL_SUPERVISOES ON TBL_USUARIOS.ID_SUPERVISAO = LOCACAO.TBL_SUPERVISOES.ID_SUPERVISAO
left join LOCACAO.TBL_GERENCIAS ON LOCACAO.TBL_SUPERVISOES.ID_GERENCIA = LOCACAO.TBL_GERENCIAS.ID_GERENCIA
WHERE BINARY CD_MATRICULA = '$user' and BINARY DS_SENHA = ";
$query = mysqli_query($con,$sql ."'".$senha."'");
$row = mysqli_fetch_array($query);
$total = mysqli_num_rows($query);

if ($total > 0){	
	//Se encontrou o login, exige alteração da senha
	echo "<form id='form1' method='post' action='trocar_senha.php'><input type='hidden' name='id_usuario'/ value='".$row['ID_USUARIO']."'></form>";
	echo ('<script>alert("POR CRITÉRIOS DE SEGURANÇA\nSUA SENHA DEVERÁ SER TROCADA."); document.getElementById("form1").submit();</script>');
	return;	
}else{
	//Se não match com senha normal, procura com hash;
	$query = mysqli_query($con,$sql ."'".$senha_hash."'");
	$row = mysqli_fetch_array($query);
	$total = mysqli_num_rows($query);	
}

if ($total > 0){	
	$_SESSION['NM_USUARIO']=$row['NM_USUARIO'];
	$_SESSION['ID_USUARIO']=$row['ID_USUARIO'];
	$_SESSION['CD_MATRICULA']=$row['CD_MATRICULA'];
	$_SESSION['DS_SENHA']=$row['DS_SENHA'];	
	$_SESSION['ID_SUPERVISAO']=$row['ID_SUPERVISAO'];	
	$_SESSION['NM_SUPERVISAO']=$row['NM_SUPERVISAO'];	
	$_SESSION['ID_GERENCIA']=$row['ID_GERENCIA'];
	$_SESSION['NM_GERENCIA']=$row['NM_GERENCIA'];	
	$_SESSION['ID_TURMA']=$row['ID_TURMA'];		
	$email = $row['DS_EMAIL']; 


	//CARREGA PERMISSÕES DO USUÁRIO
	$sql = "SELECT * FROM TBL_PERMISSOES_USUARIOS WHERE ID_USUARIO = ".$row['ID_USUARIO'];
	$query = mysqli_query($con,$sql);	
	$total = mysqli_num_rows($query);	
	$x = 0;
	while($row = mysqli_fetch_array($query)) {  
		$_SESSION['permissoes'][$x] = $row['ID_PERMISSAO'];
		$x ++;		
	}	
	
	//LOGIN REALIZADO COM SUCESSO
	//VERIFICA QUEM CHAMOU E REDIRECIONA PARA O CHAMADOR	

	//verifica se tem email
	if(empty($email)){
		echo '<script type="text/javascript">alert("' . "Seu Cadastro precisa ser atualizado. Clique em 'Ok' ou pressione 'ENTER' no teclado para continuar. ". '")</script>';				
		echo '<script type="text/javascript">window.location="/classes/usuarios/usuarios_editar.php?codedit='.$_SESSION['ID_USUARIO'].'"</script>';
	}

	//verifica se houve chamada de email	
	if (isset($_SESSION['mail']) && strlen($_SESSION['mail'])>0){
		echo '<script type="text/javascript">window.location="'.$_SESSION['mail'].'"</script>';
	}else{
		if (isset($_SESSION['caller']))
			echo '<script type="text/javascript">window.location="'.$_SESSION['caller'].'"</script>';
		else	
			echo '<script type="text/javascript">window.location="/index.php"</script>';
	}

}else{	
	echo "<center><strong>Nome de usuario ou senha incorretos.</strong></center>";
	echo"<script>loginfailed()</script>";
}

?>

</body>
</html> 