<?php
header('Content-Type:text/html;charset=utf-8');					//Configuração de idioma
session_start();

include($_SESSION['menu']);										//inclui menu do caller

mysqli_select_db($con, 'USUARIOS');

noerrors();

//Checa permissao e se o usuario logado tem permissao
$permissao = checapermissao(3);
if ($permissao == false){		
	if (!$permissao){
		echo '<script type="text/javascript">alert("Seu acesso não possui permissão para essa ação.")</script>';	
		echo '<script type="text/javascript">window.location="'  .$_SESSION['caller']. '"</script>';
	}
}

//cria os checkboxes de permissoes
$sql = "SELECT * FROM TBL_PERMISSOES ORDER BY NM_PERMISSAO ASC";
$query = mysqli_query($con,$sql);	
$checkboxes = "<table border='0' align='center'>";
while ($row=mysqli_fetch_assoc($query)) {
	$checkboxes .= '<tr><td><input type="checkbox" 
	id="'.$row['ID_PERMISSAO'].'" 
	name="'.$row['ID_PERMISSAO'].'"
	value="'.$row['ID_PERMISSAO'].'"
	/></td><td> &nbsp'.$row['NM_PERMISSAO'].'</td></tr>';
}
$checkboxes .= '</table>';

//checa se existe o usuario
$codedit = $_REQUEST['codedit'];
$sql = "SELECT ID_USUARIO, CD_MATRICULA, NM_USUARIO FROM TBL_USUARIOS WHERE ID_USUARIO = $codedit";
$query = mysqli_query($con,$sql);	
$total="";
$total = mysqli_num_rows($query);

if (strlen($total) == 0 ){	
	echo '<script type="text/javascript">alert("' . "USUÁRIO NÃO ENCONTRADO." . '")</script>';	
	echo '<script type="text/javascript">window.location="'  .$_SESSION['caller']. '"</script>';
}else{
	$row = mysqli_fetch_assoc($query);
	$nome = $row['NM_USUARIO'];
	$matricula = $row['CD_MATRICULA'];
}


//salva as alterações
if (isset($_REQUEST['acao']) && $_REQUEST['acao']=="salvar"){	
	$tabela = 'TBL_PERMISSOES_USUARIOS';
	
	
	//DELETA TODAS AS PERMISSOES DO USUARIOS
	$sql = "DELETE FROM $tabela WHERE ID_USUARIO = $codedit";
	$result = mysqli_query($con, $sql);		
	
	//imprime todas as variaveis recebidas
	$sql = "";
	foreach ($_REQUEST as $key => $value){		
		if ($key != 'acao' && $key != 'codedit')
			$sql .= "INSERT INTO $tabela (ID_USUARIO, ID_PERMISSAO) VALUES ($codedit, $value );";
	}							
	
	$result = mysqli_multi_query($con, $sql);	
		
	//verifica se salvou com sucesso
	if (!$result){
		echo('<script type="text/javascript">alert("Erro ao tentar salvar.");</script>');				
		echo('<script type="text/javascript">window.location="usuarios_cadastrar.php";</script>');					
	}else{
		echo('<script type="text/javascript">alert("DADOS SALVOS COM SUCESSO!");</script>');
		echo('<script type="text/javascript">window.location="'.$_SESSION['caller'].'";</script>');		
	}	
}


?>

<html>
<head>
	<meta charset="utf-8">
	<link href="/classes/style.css" rel="stylesheet" type="text/css">  
		
	<script language="javascript">	
		//define o menu ativo			
		$("#mnusuarios").addClass("active");		
	</script>
	<style type="text/css">
				
		.form-control {
			height: 27px;
			font-size:12px;
		}
		.field_name{
			color:gray;
		}
		.titulo{
			font-size:16px;
			font-weight:bold;
		}
		
				
	</style>
</head>
<body> 

<div align="center">
	<div align="center" class="panel panel-default" style="width:620px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 10px 0 rgba(0, 0, 0, 0.15); margin-top:30px; text-align:center">
		<div align="center" class="panel-heading" style="width:620px; text-align:center">
			<h4 align="center"><span class="titulo">Permissões do usuário</span></h4>
			<p align="center"><?php echo $nome ." - " .$matricula;?> </p>
		</div>
		<div class="panel-body">
			<form name="form1" method="post" action="usuarios_permissoes.php" enctype="multipart/form-data">										
				<!--PERMISSÕES DOS USUÁRIOS-->
				<div class="permissoes">
					<?php 						
					$permissao = checapermissao(3);
					if ($permissao){ 							
						echo $checkboxes;
						
						//consulta e marca marca os checkboxes com permissão do usuário
						$sql = "SELECT * FROM TBL_PERMISSOES_USUARIOS WHERE ID_USUARIO = $codedit";
						$query = mysqli_query($con, $sql);							
						while($row=mysqli_fetch_assoc($query)){
							echo "<script>document.getElementById('".$row['ID_PERMISSAO']."').checked=true;</script>";
						}
					}
					?>					
				</div>					
				<br>								
				<input type="hidden" name="acao" id="acao" value="salvar"/>					
				<input type="hidden" name="codedit" id="codedit" value="<?php echo $codedit; ?>"/>					 
				<button class="btn btn-primary btnvale" id="btnvale" align="middle" style="width:200px;height:30px" type="submit" onClick="return ValidaForm()">Salvar</button>
				<button class="btn btn-primary btnvale" id="btnvale" align="middle" style="width:200px;height:30px" type="button" onClick="return redirecionar()">Cancelar</button>					
			</form>				
		</div>
	</div>
</div>
</body>
</html>