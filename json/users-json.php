
<?php 
header('Content-Type: application/json; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT']."/kaizens/connections/kaizens_prd.php");
include($_SERVER['DOCUMENT_ROOT']."/kaizens/classes/funcoes.php");
noerrors();

//filtro por id
if (isset($_GET['w']) && strlen($_GET['w'])>0){	
	$w = " WHERE tb_users.id_user =" .$_GET['w'];
}else
	$w = " WHERE tb_users.bt_active = 1";

//QUERY DADOS		
mysqli_select_db($con_kaizens_prd, "paint_control");
$sql = "SELECT tb_users.nm_user, tb_users.id_user, tb_users.ds_email,
tb_supervisions.ds_supervision,
tb_managers.ds_manager
FROM tb_users 
left join tb_supervisions on tb_users.id_supervision = tb_supervisions.id_supervision
left join tb_managers on tb_supervisions.id_manager = tb_managers.id_manager
$w order by nm_user asc";
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
