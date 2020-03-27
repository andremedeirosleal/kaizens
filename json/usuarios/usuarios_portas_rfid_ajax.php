
<?php 
header('Content-Type: application/json; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php"); 

if (isset($_GET['w']) && strlen($_GET['w'])>0){	
	$w = " WHERE TBL_USUARIOS.ID_USUARIO = " .$_GET['w'];
}else{
	$w = "";
}

//QUERY DADOS		
mysqli_select_db($con, "USUARIOS");
$sql = "SELECT 
TBL_CRACHAS_USUARIOS.*,
TBL_USUARIOS.NM_USUARIO,
TBL_USUARIOS.CD_MATRICULA,
LOCACAO.TBL_PORTAS_RFID.*
FROM TBL_CRACHAS_USUARIOS
LEFT JOIN TBL_USUARIOS ON TBL_CRACHAS_USUARIOS.ID_USUARIO = TBL_USUARIOS.ID_USUARIO
LEFT JOIN LOCACAO.TBL_PORTAS_RFID ON TBL_CRACHAS_USUARIOS.ID_PORTA_RFID = LOCACAO.TBL_PORTAS_RFID.ID_PORTA_RFID " .$w;
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
