
<?php 
header('Content-Type: application/json; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT']."/kaizens/connections/kaizens_prd.php");
//include($_SERVER['DOCUMENT_ROOT']."/kaizens/classes/funcoes.php");
//noerrors();
//checalogin();

$w = " WHERE 1=1 ";

//filtro por id
if (isset($_GET['w']) && strlen($_GET['w'])>0){	
	$w .= " AND tbl_controle_producao.id_controle_producao =" .$_GET['w'];
}	

//SERVIÇOS DE HOJE
if (isset($_GET['o']) && $_GET['o']==2){	
	$w .= " AND date(dt_abertura) = CURDATE()";
}

//SERVIÇOS DE ONTEM
if (isset($_GET['o']) && $_GET['o']==3){	
	$w .= " AND date(dt_abertura) = (CURDATE() -1)";
}

//MES ATUAL
if (isset($_GET['o']) && $_GET['o']==4){	
	$w .= " AND MONTH(dt_abertura) = MONTH(CURDATE()) and YEAR(dt_abertura) = YEAR(curdate()) ";
}

//MES ANTERIOR
if (isset($_GET['o']) && $_GET['o']==5){	
	$w .= " AND YEAR(dt_abertura) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(dt_abertura) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) ";	
}

//TODOS OS REGISTROS DO ANO
if (isset($_GET['o']) && $_GET['o']==7){	
	$w .= " AND YEAR(dt_abertura) = YEAR(CURDATE())  ";
}

//TODOS OS REGISTROS DO ANO PASSADO
if (isset($_GET['o']) && $_GET['o']==8){	
	$w .= " AND YEAR(dt_abertura) = (YEAR(CURDATE()) -1) ";
}

//ENTRE dt_abertura
if (isset($_GET['di']) && strlen($_GET['di'])> 0){	
	$w .= " AND date(dt_abertura) BETWEEN '". $_GET['di'] ."' AND '". $_GET['df'] ."'";
}	


$w .= " AND bt_active = 1 ";


//QUERY DADOS		
$sql = "SELECT 
tb_registers.`*`,
IF(tb_registers.dt_criation, DATE_FORMAT(tb_registers.dt_criation,'%d/%m/%Y'),NULL) AS dt_abertura,
tb_supervisions.ds_supervision,
(CONCAT('/kaizens/view/global/register_photo.php?code=', tb_registers.id_register ,'&field=1'))photo_before,
(CONCAT('/kaizens/view/global/register_photo.php?code=', tb_registers.id_register ,'&field=2'))photo_after,
tb_managers.ds_manager
FROM tb_registers
left join tb_supervisions on tb_registers.id_supervision = tb_supervisions.id_supervision
left join tb_managers on tb_supervisions.id_manager = tb_managers.id_manager
$w ";

$query = mysqli_query($con_kaizens_prd, $sql) ;
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
			// $dados .= '"'.$nome.'":"'.$valor.'",';		
			$dados .= '"'.$nome.'":'.json_encode($valor).',';		
		}			
		$dados = substr($dados, 0, strlen($dados) - 1) . '';  //remove a última virgula e completa sessão "data"
		$dados .= '},';	
	}
	$dados = substr($dados, 0, strlen($dados) - 1) . ']';  //remove a última virgula e completa sessão "data"

	//Fechamento do arquivo e impressão
	$dados .='}';
	echo $dados;
}else echo '{"data":[]}';

mysqli_close($con_kaizens_prd);
?>