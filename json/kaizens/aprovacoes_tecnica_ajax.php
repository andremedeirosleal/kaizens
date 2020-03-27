
<?php 
header('Content-Type: application/json; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php"); 

if (isset($_GET['w']) && strlen($_GET['w'])>0){	
	$w = " WHERE TBL_APROVACOES_TECNICA.ID_KAIZEN =" .$_GET['w'];
}else{
	$w = "";
}

//QUERY DADOS		
mysqli_select_db($con, "KAIZENS");
$sql = "SELECT 
TBL_APROVACOES_TECNICA.ID_APROVACAO_TECNICA,
TBL_APROVACOES_TECNICA.ID_USUARIO, TBL_APROVACOES_TECNICA.ID_KAIZEN, 
DATE_FORMAT(TBL_APROVACOES_TECNICA.DT_APROVACAO,'%d/%m/%Y') AS 'DT_APROVACAO',
LOCACAO.TBL_GERENCIAS.NM_GERENCIA,
LOCACAO.TBL_SUPERVISOES.NM_SUPERVISAO,
USUARIOS.TBL_USUARIOS.NM_USUARIO,
USUARIOS.TBL_USUARIOS.CD_MATRICULA

FROM TBL_APROVACOES_TECNICA
left join USUARIOS.TBL_USUARIOS on TBL_APROVACOES_TECNICA.ID_USUARIO = USUARIOS.TBL_USUARIOS.ID_USUARIO
left join LOCACAO.TBL_SUPERVISOES on USUARIOS.TBL_USUARIOS.ID_SUPERVISAO = LOCACAO.TBL_SUPERVISOES.ID_SUPERVISAO
left join LOCACAO.TBL_GERENCIAS on LOCACAO.TBL_SUPERVISOES.ID_GERENCIA = LOCACAO.TBL_GERENCIAS.ID_GERENCIA
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
