
<?php 
header('Content-Type: application/json; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php"); 

if (isset($_GET['w']) && strlen($_GET['w'])>0){	
	$w = " WHERE codigo =" .$_GET['w'];
}else{
	$w = "";
}

//SUPERVISAO
if (isset($_GET['g']) && strlen($_GET['g'])>0){	
	if ($_GET['g'] == '0') $w = " WHERE 1=1 ";	//todas as supervisoes
	else $w = " WHERE kaizens.gerencia =" . $_GET['g'];	
}

//SUPERVISAO
if (isset($_GET['s']) && strlen($_GET['s'])>0){	
	if ($_GET['s'] == '0') $w .= " AND 1=1 ";	//todas as supervisoes
	else $w .= " AND kaizens.supervisao =" . $_GET['s'];	
}

//DE HOJE
if (isset($_GET['o']) && $_GET['o']=='1'){	
	$w .= " AND kaizens.data = CURDATE()";
}

//DE ONTEM
if (isset($_GET['o']) && $_GET['o']=='2'){	
	$w .= " AND kaizens.data = (CURDATE() -1)";
}

//MES ATUAL
if (isset($_GET['o']) && $_GET['o']=='3'){	
	$w .= " AND MONTH(kaizens.data) = MONTH(CURDATE()) ";
}

//MES ANTERIOR
if (isset($_GET['o']) && $_GET['o']=='4'){	
	$w .= " AND MONTH(kaizens.data) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) ";
}

//TODOS OS REGISTROS DO ANO
if (isset($_GET['o']) && $_GET['o']=='5'){	
	$w .= " AND YEAR(kaizens.data) = YEAR(CURDATE())  ";
}

//TODOS OS REGISTROS DO ANO PASSADO
if (isset($_GET['o']) && $_GET['o']=='6'){	
	$w .= " AND YEAR(kaizens.data) = (YEAR(CURDATE())-1) ";
}


//ENTRE DATAS
if (isset($_GET['di']) && strlen($_GET['di'])> 0){	
	$w .= " AND kaizens.data BETWEEN '". $_GET['di'] ."' AND '". $_GET['df'] ."'";
}else{
	//if ($_GET['o'] != "6") $w .= " AND YEAR(kaizens.data) = YEAR(CURDATE()) "; // se não é filtro por ano passado nem data
}

//KAIZENS OU CONDIÇÕES NORMAIS
if (isset($_GET['n']) && strlen($_GET['n'])>0 ){	
	if ($_GET['n'] == 0) $w .= " AND bt_nao_kaizen = 0";
	if ($_GET['n'] == 1) $w .= " AND bt_nao_kaizen = 1";
	if ($_GET['n'] == 2) $w .= " AND 1=1";
}else $w .= " AND bt_nao_kaizen = 0";

function troca($str){
	//str_replace("<br>", " ", $str);
	$str = strtr($str, array("\r\n" => ' ', "\r" => ' ', "\n" => ' ', "<br>" => ' '));
	$str = trim($str);
	//$str = replacestr($str);
	return $str;
}

//QUERY DADOS
mysqli_select_db($con, "KAIZENS");
$sql = "SELECT codigo, titulo, tempo_antes, tempo_apos, tempo_ganho, 
(select USUARIOS.TBL_USUARIOS.NM_USUARIO FROM USUARIOS.TBL_USUARIOS where KAIZENS.kaizens.cadastrou = USUARIOS.TBL_USUARIOS.ID_USUARIO) nomecadastrou, 
(select USUARIOS.TBL_USUARIOS.CD_MATRICULA FROM USUARIOS.TBL_USUARIOS where KAIZENS.kaizens.cadastrou = USUARIOS.TBL_USUARIOS.ID_USUARIO) mat_cadastrou, 
(select LOCACAO.TBL_GERENCIAS.NM_GERENCIA from LOCACAO.TBL_GERENCIAS where KAIZENS.kaizens.gerencia = LOCACAO.TBL_GERENCIAS.ID_GERENCIA) nomegerencia , 
(select LOCACAO.TBL_SUPERVISOES.NM_SUPERVISAO from LOCACAO.TBL_SUPERVISOES where KAIZENS.kaizens.supervisao = LOCACAO.TBL_SUPERVISOES.ID_SUPERVISAO) nomesupervisao , 
(select USUARIOS.TBL_USUARIOS.NM_USUARIO FROM USUARIOS.TBL_USUARIOS where KAIZENS.kaizens.colab1 = USUARIOS.TBL_USUARIOS.ID_USUARIO) nome1, 
(select USUARIOS.TBL_USUARIOS.NM_USUARIO FROM USUARIOS.TBL_USUARIOS where KAIZENS.kaizens.colab2 = USUARIOS.TBL_USUARIOS.ID_USUARIO) nome2, 
(select USUARIOS.TBL_USUARIOS.NM_USUARIO FROM USUARIOS.TBL_USUARIOS where KAIZENS.kaizens.colab3 = USUARIOS.TBL_USUARIOS.ID_USUARIO) nome3, 
(select USUARIOS.TBL_USUARIOS.NM_USUARIO FROM USUARIOS.TBL_USUARIOS where KAIZENS.kaizens.colab4 = USUARIOS.TBL_USUARIOS.ID_USUARIO) nome4, 
(select USUARIOS.TBL_USUARIOS.NM_USUARIO FROM USUARIOS.TBL_USUARIOS where KAIZENS.kaizens.colab5 = USUARIOS.TBL_USUARIOS.ID_USUARIO) nome5, 
(select USUARIOS.TBL_USUARIOS.CD_MATRICULA FROM USUARIOS.TBL_USUARIOS where KAIZENS.kaizens.colab1 = USUARIOS.TBL_USUARIOS.ID_USUARIO) mat1, 
(select USUARIOS.TBL_USUARIOS.CD_MATRICULA FROM USUARIOS.TBL_USUARIOS where KAIZENS.kaizens.colab2 = USUARIOS.TBL_USUARIOS.ID_USUARIO) mat2, 
(select USUARIOS.TBL_USUARIOS.CD_MATRICULA FROM USUARIOS.TBL_USUARIOS where KAIZENS.kaizens.colab3 = USUARIOS.TBL_USUARIOS.ID_USUARIO) mat3, 
(select USUARIOS.TBL_USUARIOS.CD_MATRICULA FROM USUARIOS.TBL_USUARIOS where KAIZENS.kaizens.colab4 = USUARIOS.TBL_USUARIOS.ID_USUARIO) mat4, 
(select USUARIOS.TBL_USUARIOS.CD_MATRICULA FROM USUARIOS.TBL_USUARIOS where KAIZENS.kaizens.colab5 = USUARIOS.TBL_USUARIOS.ID_USUARIO) mat5, 
DATE_FORMAT(KAIZENS.kaizens.data,'%d/%m/%Y') AS 'data',  CASE     WHEN KAIZENS.kaizens.saude = 0 THEN '  ' 
WHEN KAIZENS.kaizens.saude = 1 THEN 'sim'  END AS saude,   CASE     WHEN KAIZENS.kaizens.seg = 0 THEN '  ' 
WHEN KAIZENS.kaizens.seg = 1 THEN 'sim' END AS seg,   CASE    WHEN KAIZENS.kaizens.pessoas = 0 THEN '  ' 
WHEN KAIZENS.kaizens.pessoas = 1 THEN 'sim'  END AS pessoas,  CASE   WHEN KAIZENS.kaizens.quali = 0 THEN '  ' 
WHEN KAIZENS.kaizens.quali = 1 THEN 'sim'  END AS quali,  CASE    WHEN KAIZENS.kaizens.prod = 0 THEN '  ' 
WHEN KAIZENS.kaizens.prod = 1 THEN 'sim'  END AS prod, CASE    WHEN KAIZENS.kaizens.custos = 0 THEN '  ' 
WHEN KAIZENS.kaizens.custos = 1 THEN 'sim'  END AS custos,   CASE    WHEN KAIZENS.kaizens.nd = 0 THEN '  ' 
WHEN KAIZENS.kaizens.nd = 1 THEN 'sim'  END AS nd,  CASE    WHEN KAIZENS.kaizens.espera = 0 THEN '  ' 
WHEN KAIZENS.kaizens.espera = 1 THEN 'sim'  END AS espera,   CASE    WHEN KAIZENS.kaizens.superprod = 0 THEN '  ' 
WHEN KAIZENS.kaizens.superprod = 1 THEN 'sim'  END AS superprod,   CASE    WHEN KAIZENS.kaizens.transp = 0 THEN '  ' 
WHEN KAIZENS.kaizens.transp = 1 THEN 'sim'  END AS transp,   CASE    WHEN KAIZENS.kaizens.invent = 0 THEN '  ' 
WHEN KAIZENS.kaizens.invent = 1 THEN 'sim'  END AS invent,   CASE    WHEN KAIZENS.kaizens.movi = 0 THEN '  ' 
WHEN KAIZENS.kaizens.movi = 1 THEN 'sim'  END AS movi,  CASE    WHEN KAIZENS.kaizens.process = 0 THEN '  ' 
WHEN KAIZENS.kaizens.process = 1 THEN 'sim'  END AS process, CASE    WHEN KAIZENS.kaizens.defeito = 0 THEN '  ' 
WHEN KAIZENS.kaizens.defeito = 1 THEN 'sim'  END AS defeito, 
CASE WHEN KAIZENS.kaizens.meio_ambiente = 1 THEN 'sim' WHEN KAIZENS.kaizens.meio_ambiente = 0 THEN ' ' END AS meio_ambiente,
CASE WHEN KAIZENS.kaizens.bt_nao_kaizen = 1 THEN 'Cond. Normal' WHEN KAIZENS.kaizens.bt_nao_kaizen = 0 THEN 'Kaizen' END AS tipo
FROM KAIZENS.kaizens" .$w. " ";
//echo $sql;
$query = mysqli_query($con, $sql) or die(mysql_error());
$total = mysqli_num_rows($query);

if ($total >0){
	while ($row=mysqli_fetch_assoc($query)){
		$result[] = $row;
	}

	$dados = $result;
	echo json_encode(array("draw"=>0,"data"=>$dados));
	
}else echo '{"data":[]}';

mysqli_close($con);
?>
