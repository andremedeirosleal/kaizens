
<?php 
header('Content-Type: application/json; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php"); 
session_start();

//filtro
$w=" WHERE 1=1 ";
if (isset($_GET['w']) && strlen($_GET['w'])>0){	
	$w .= " AND TBL_IDEIAS.ID_IDEIA =" .$_GET['w'];
}

//REGISTROS DE HOJE
if (isset($_REQUEST['o']) && $_REQUEST['o']=='2'){	
	$w .= " AND DT_CADASTRO > 
	CONCAT(CURDATE(), ' 00:00:00') AND DT_CADASTRO < CONCAT(CURDATE(), ' 23:59:59') ";
}

//REGISTROS DE ONTEM
if (isset($_GET['o']) && $_GET['o']=='3'){	
	$w .= " AND DT_CADASTRO > (CURDATE()-1) AND DT_CADASTRO < (CURDATE()) ";
}

//MES ATUAL
if (isset($_GET['o']) && $_GET['o']=='4'){	
	$w .= " AND MONTH(DT_CADASTRO) = MONTH(CURDATE()) ";
}

//MES ANTERIOR
if (isset($_GET['o']) && $_GET['o']=='5'){	
	$w .= " AND MONTH(TBL_IDEIAS.DT_CADASTRO) = (MONTH(CURDATE())-1) ";
}

//DELETADOS
if (isset($_GET['o']) && $_GET['o']=='7'){	
	$w .= " AND TBL_IDEIAS.DT_CADASTRO =1 ";
}

//TODOS OS REGISTROS DO ANO
if (isset($_GET['o']) && $_GET['o']=='9'){	
	$w .= " AND YEAR(TBL_IDEIAS.DT_CADASTRO ) = YEAR(CURDATE())  ";
}


//QUERY DADOS		
mysqli_select_db($con, "KAIZENS");
$sql = "SELECT
TBL_IDEIAS.ID_IDEIA, 
TBL_IDEIAS.DS_PROBLEMA,
TBL_IDEIAS.DS_SOLUCAO,
TBL_IDEIAS.DT_CADASTRO,
USUARIOS.TBL_USUARIOS.NM_USUARIO,
LOCACAO.TBL_GERENCIAS.NM_SIGLA_GERENCIA,
LOCACAO.TBL_SUPERVISOES.NM_SUPERVISAO
FROM TBL_IDEIAS
LEFT JOIN USUARIOS.TBL_USUARIOS ON USUARIOS.TBL_USUARIOS.ID_USUARIO = TBL_IDEIAS.ID_USUARIO
LEFT JOIN LOCACAO.TBL_SUPERVISOES ON LOCACAO.TBL_SUPERVISOES.ID_SUPERVISAO = TBL_IDEIAS.ID_SUPERVISAO_USUARIO
LEFT JOIN LOCACAO.TBL_GERENCIAS ON LOCACAO.TBL_GERENCIAS.ID_GERENCIA = TBL_IDEIAS.ID_GERENCIA_USUARIO
$w ORDER BY DT_CADASTRO DESC";
$query = mysqli_query($con, $sql) or die(mysql_error());
$total = mysqli_num_rows($query);

if ($total >0){
	//Preenche o array com nome dos campos
	$fields = array();
	$x = 0;
	while ($fieldinfo=mysqli_fetch_field($query)){
		$fields[$x] = $fieldinfo->name;
		//echo "\n".$fields[$x];
		$x++;   
	}

	//Guarda os dados com nome dos campos
	$dados =  '{"data":[';
	while($row = mysqli_fetch_array($query)) {   
		$dados .= '{';	
			
		for ($x=0; $x< sizeof($fields); $x++){			
			$nome = $fields[$x];
			$valor = $row[$x];
			$dados .= '"'.$nome.'":"'.$valor.'",';		
		}			
		$dados = substr($dados, 0, strlen($dados) - 1) . '';  //remove a última virgula e completa sessão "data"
		$dados .= '},';	
	}
	$dados = substr($dados, 0, strlen($dados) - 1) . ']';  //remove a última virgula e completa sessão "data"

	//Fechamento do arquivo e impressão
	$dados .='}';
	echo $dados;
}else echo '{"data":[]}';

mysqli_close($con);
?>
