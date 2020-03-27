<html>
<head>
	<title>SGM</title>
	<link rel="shortcut icon" href="/images/icon.ico" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>

<?php	
	//header('Content-Type: application/json; charset=utf-8');
	include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php"); 	
	include($_SERVER['DOCUMENT_ROOT']."/classes/funcoes.php"); 
	
	noerrors();
	session_start();
	
	//SESSÃO MODIFICÁVEL - CADA TABELA CONTROLÁVEL PRECISA SER PERSONALIZADA AQUI
	mysqli_select_db($con, "USUARIOS");		//banco a se conectar
	$tabela = "TBL_USUARIOS";				//tabela a ser trabalhada
	$permissao = 3;							//código referente à permissão 
	$campoid = "ID_USUARIO";				//Campo utilizado na busca pelo registro, para exclusão e edição	
	$campofile = "TP_FOTO_USUARIO";			//nome do campo tipo file. color "" em caso de não existir
	
	function validadados($acao, $con, $tabela, $campoid, $campofile){
		$validado = true;
		if (isset($_REQUEST['NM_USUARIO']) && strlen($_REQUEST['NM_USUARIO'])<1){ 
			echo '<script type="text/javascript">alert("Nome de usuário inválido")</script>';			
			echo '<script type="text/javascript">window.location="usuarios_cadastrar.php";</script>';
			$validado =  false;
		}
			
		if (isset($_REQUEST['CD_MATRICULA']) && strlen($_REQUEST['CD_MATRICULA'])<1){ 
			echo '<script type="text/javascript">alert("Matrícula inválida.")</script>';			
			echo '<script type="text/javascript">window.location="usuarios_cadastrar.php";</script>';
			$validado =  false;
		}else{
			//verifica se matrícula já não está cadastrada.
			if ($acao == "incluir"){
				$result = mysqli_query($con, "select CD_MATRICULA from TBL_USUARIOS WHERE CD_MATRICULA = '".$_REQUEST['CD_MATRICULA'] ."'");
				$row = mysqli_num_rows($result);
				if ($row >0){
					echo '<script type="text/javascript">alert("A matrícula ' .$_REQUEST['CD_MATRICULA'].' já existe no sistema.\nFavor verificar.\n\n")</script>';			
					echo '<script type="text/javascript">window.location="usuarios_cadastrar.php";</script>';
					$validado =  false;
				};
			}
		}
				
		if (isset($_REQUEST['ID_SUPERVISAO']) && strlen($_REQUEST['ID_SUPERVISAO'])<1){ 
			echo '<script type="text/javascript">alert("Supervisão inválida.")</script>';			
			echo '<script type="text/javascript">window.location="usuarios_cadastrar.php";</script>';		
			$validado =  false;
		}
		
		if (isset($_REQUEST['DS_SENHA']) && strlen($_REQUEST['DS_SENHA'])<1){ 
			echo '<script type="text/javascript">alert("Senha inválida.")</script>';			
			echo '<script type="text/javascript">window.location="usuarios_cadastrar.php";</script>';
			$validado =  false;
		}
		
		if ($validado){		
			if ($acao == "incluir"){incluir($con, $tabela, $campoid, $campofile);}			
			if ($acao == "editar"){editar($con, $tabela, $campoid, $campofile);}
		}
	}	
	//FIM DA SESSÃO MODIFICÁVEL -----------------------------------------------------------------------
	
		
		
		
	//FUNÇÕES ESTRUTURADAS PARA USO GENERALIZADO - NÃO MODIFICAR	
	function settext($str){
		return strtr($str, array("\r\n" => '<br>', "\r" => '<br>', "\n" => '<br>', "'"=> "", '"'=> ""));
	}
			
	function incluir($con, $tabela, $campoid, $campofile){	
		$sql = "INSERT INTO $tabela(";		
		
		//imprime todas as variaveis recebidas
		foreach ($_REQUEST as $key => $value){
			if ($key != 'acao' && $key != $campoid)
			$sql .= "{$key},";
		}							
		
		//inclui campo nome do campo file
		if (strlen($campofile)>0){$sql .= $campofile ." ";}
		
		//remove a última ","
		$sql = substr($sql, 0, strlen($sql) - 1);													
		$sql .= ")VALUES (";		
		
		//imprime todos os valores das variaveis recebidas
		foreach ($_REQUEST as $key => $value){
			if ($key != 'acao' && $key != $campoid)
			$sql .= "'". settext($value). "',";
		}		
		
		//inclui valor do campo file
		if (strlen($campofile)>0){
			//CARREGA A FOTO EM FORMATO PARA SALVAR
			$imagem = $_FILES[$campofile]['tmp_name'];	
			$tamanho = $_FILES[$campofile]['size']; 
			$loadfoto = "";
						
			if ( $tamanho >0 ){ 
				if ($tamanho < 250000 || $tamanho == "0"){
					$fp = fopen($imagem, "rb");
					$loadfoto = fread($fp, $tamanho);
					$loadfoto = addslashes($loadfoto);
					$sql .= "'".$loadfoto."',";
					fclose($fp);				
				}else{
					echo '<script type="text/javascript">alert("' . "O Tamanho máximo de imagem permitido é 250 KByte." . '")</script>';			
					echo '<script type="text/javascript">window.location="usuarios_cadastrar.php";</script>';						
					return;
				}								
			}else $sql .= "'',";
		}		
		
		//remove a última ","	
		$sql = substr($sql, 0, strlen($sql) - 1);													
		$sql .= ")";
		
		$result = mysqli_query($con, $sql);	
		
		//verifica se salvou com sucesso
		if (!$result){
			echo('<script type="text/javascript">alert("Erro ao tentar salvar.");</script>');				
			echo('<script type="text/javascript">window.location="usuarios_cadastrar.php";</script>');					
		}else{
			echo('<script type="text/javascript">alert("DADOS SALVOS COM SUCESSO!");</script>');				
			echo('<script type="text/javascript">window.location="usuarios_cadastrar.php";</script>');
		}
	}
		
	
	function editar($con, $tabela, $campoid, $campofile){	
		$sql = "UPDATE $tabela SET ";		
		
		//imprime todas as variaveis recebidas
		foreach ($_REQUEST as $key => $value){
			if ($key != 'acao' && $key != $campoid){ 
				$sql .= "{$key}='" . settext($value) ."',";}
			else{
				if ($key == $campoid){
				$valorid = $value;}
			}
		}							
		
		if (strlen($campofile)>0){
			//CARREGA A FOTO EM FORMATO PARA SALVAR
			$imagem = $_FILES[$campofile]['tmp_name'];	
			$tamanho = $_FILES[$campofile]['size']; 
			$loadfoto = "";
						
			if ( $tamanho >0 ){ 
				if ($tamanho < 250000 || $tamanho == "0"){
					$fp = fopen($imagem, "rb");
					$loadfoto = fread($fp, $tamanho);
					$loadfoto = addslashes($loadfoto);
					$sql .= $campofile ."='". $loadfoto."',";
					fclose($fp);				
				}else{
					echo '<script type="text/javascript">alert("' . "O Tamanho máximo de imagem permitido é 250 KByte." . '")</script>';			
					echo '<script type="text/javascript">window.location="usuarios_editar?codedit="'.$valorid.';</script>';	
					return;
				}								
			}
		}
		
		//remove a última ","
		$sql = substr($sql, 0, strlen($sql) - 1);													
		
		$sql .= " WHERE $campoid = $valorid";		
		
		$result = mysqli_query($con, $sql);	
		
		//verifica se salvou com sucesso
		if (!$result){
			echo('<script type="text/javascript">alert("Erro ao tentar salvar.");</script>');				
			echo '<script type="text/javascript">window.location="usuarios_editar?codedit="'.$valorid.';</script>';					
		}else{
			echo '<script type="text/javascript">alert("DADOS SALVOS COM SUCESSO!");</script>';				
			echo '<script type="text/javascript">window.location="'.$_SESSION['caller'].'";</script>';
		}		
	}
	
	
	function excluir($con, $tabela, $campoid, $codigo, $permissao){						
		
		$permitido = checapermissao($permissao);
		
		if ($permitido){
			if ($codigo < 1) return "erro: código inválido";
				
			$sql = "DELETE FROM $tabela WHERE $campoid = $codigo ";			
					
			if (mysqli_query($con, $sql)){
				echo "sucesso   $sql";
			}else die('erro\n'.mysqli_error()."\n");
			
			mysqli_close($con);						
		}else {
			echo "acesso";
		}	
	}
	
	
	function desativar($con, $tabela, $campoid, $codigo, $permissao){		
		$permitido = checapermissao($permissao);
		
		if ($permitido){
			if ($codigo < 1) return "erro: código inválido";
				
			$sql = "UPDATE $tabela SET BT_ATIVO=0 WHERE $campoid = $codigo";			
					
			if (mysqli_query($con, $sql)){
				echo "sucesso";
			}else die('erro\n'.mysqli_error()."\n");
			
			mysqli_close($con);						
		}else {
			echo "acesso";
		}	
	}
	
	
	
	if (isset($_REQUEST['acao']) && $_REQUEST['acao'] == "incluir"){
		validadados("incluir", $con, $tabela, $campoid, $campofile);}
		
	if (isset($_REQUEST['acao']) && $_REQUEST['acao'] == "editar"){				
		validadados("editar", $con, $tabela, $campoid, $campofile);}
	
	if (isset($_REQUEST['acao']) && $_REQUEST['acao'] == "excluir"){				
		if (isset($_REQUEST['codigo']) && strlen($_REQUEST['codigo']) >0){			
			excluir($con, $tabela, $campoid, $_REQUEST['codigo'], $permissao);
		}
	}
	
	if (isset($_REQUEST['acao']) && $_REQUEST['acao'] == "desativar"){				
		desativar($con, $tabela, $campoid, $_REQUEST['codigo'], $permissao);
	}
?>
</body>
</html>