
<?php 
header('Content-Type: application/json; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php"); 
session_start();

if (isset($_GET['w']) && strlen($_GET['w'])>0){	
	$w = " WHERE TBL_USUARIOS.ID_USUARIO =" .$_GET['w'];
}else{
	if (isset($_GET['m']) && strlen($_GET['m'])>0){	
		$w = " WHERE TBL_USUARIOS.CD_MATRICULA ='" .$_GET['m'] ."'";
	}else{
		$w = "";
	}
}

//exibição de gerencias (0 = SÓ gerencia do usuário logado)
if (isset($_GET['g']) && strlen($_GET['g']) >0){	
	if ($_GET['g']==0) 
		$w = " WHERE LOCACAO.TBL_SUPERVISOES.ID_GERENCIA = " .$_SESSION['ID_GERENCIA'];
	else
		$w = " WHERE LOCACAO.TBL_SUPERVISOES.ID_GERENCIA = " .$_GET['g'];	
}


//QUERY DADOS		
$sql = "SELECT 
TBL_USUARIOS.ID_USUARIO, 
TBL_USUARIOS.NM_USUARIO, 
TBL_USUARIOS.CD_MATRICULA, 
TBL_USUARIOS.ID_SUPERVISAO, 
LOCACAO.TBL_SUPERVISOES.NM_SUPERVISAO,
LOCACAO.TBL_SUPERVISOES.ID_GERENCIA,
LOCACAO.TBL_GERENCIAS.NM_GERENCIA
FROM TBL_USUARIOS 

LEFT join LOCACAO.TBL_SUPERVISOES ON TBL_USUARIOS.ID_SUPERVISAO = LOCACAO.TBL_SUPERVISOES.ID_SUPERVISAO
LEFT JOIN LOCACAO.TBL_GERENCIAS ON TBL_SUPERVISOES.ID_GERENCIA = LOCACAO.TBL_GERENCIAS.ID_GERENCIA
".$w."
ORDER BY TBL_USUARIOS.NM_USUARIO ASC";

mysqli_select_db($con, "USUARIOS");
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
