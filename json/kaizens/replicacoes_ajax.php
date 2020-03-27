
<?php 
header('Content-Type: application/json; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php"); 

if (isset($_GET['w']) && strlen($_GET['w'])>0){	
	$w = " WHERE ID_KAIZEN_ORIGINAL =" .$_GET['w'];
}else{
	$w = "";
}

//QUERY DADOS		
mysqli_select_db($con, "KAIZENS");
$sql = "SELECT 
TBL_REPLICACOES_KAIZENS.ID_REPLICACAO_KAIZEN, 
TBL_REPLICACOES_KAIZENS.ID_KAIZEN_ORIGINAL,
TBL_REPLICACOES_KAIZENS.ID_KAIZEN_NOVO,
TBL_REPLICACOES_KAIZENS.ID_REPLICADOR,
TBL_REPLICACOES_KAIZENS.ID_SUPERVISAO_APLICADA,
DATE_FORMAT(TBL_REPLICACOES_KAIZENS.DT_REPLICACAO,'%d/%m/%Y') AS 'DT_REPLICACAO',
LOCACAO.TBL_GERENCIAS.NM_GERENCIA,
LOCACAO.TBL_SUPERVISOES.NM_SUPERVISAO,
USUARIOS.TBL_USUARIOS.NM_USUARIO,
USUARIOS.TBL_USUARIOS.CD_MATRICULA,
kaizens.bt_nao_kaizen,
CASE WHEN kaizens.bt_nao_kaizen = 1 THEN 'Cond. Normal' WHEN kaizens.bt_nao_kaizen = 0 THEN 'Kaizen' END AS tipo

FROM TBL_REPLICACOES_KAIZENS

left join kaizens on TBL_REPLICACOES_KAIZENS.ID_KAIZEN_NOVO = kaizens.codigo
left join LOCACAO.TBL_GERENCIAS on kaizens.gerencia = LOCACAO.TBL_GERENCIAS.ID_GERENCIA
left join LOCACAO.TBL_SUPERVISOES on kaizens.supervisao = LOCACAO.TBL_SUPERVISOES.ID_SUPERVISAO
left join USUARIOS.TBL_USUARIOS on TBL_REPLICACOES_KAIZENS.ID_REPLICADOR = USUARIOS.TBL_USUARIOS.ID_USUARIO
" .$w;
$query = mysqli_query($con, $sql) or die(mysql_error());
$total = mysqli_num_rows($query);

if ($total >0){
	//Preenche o array com nome dos campos
	$fields = array();
	$x = 0;
	while ($fieldinfo=mysqli_fetch_field($query)){
		$fields[$x] = $fieldinfo->name;    
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
