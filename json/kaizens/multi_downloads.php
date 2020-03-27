<?PHP
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php");	
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
	$w .= " AND MONTH(kaizens.data) = (MONTH(CURDATE())-1) ";
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
	if ($_GET['o'] != "6") $w .= " AND YEAR(kaizens.data) = YEAR(CURDATE()) "; // se não é filtro por ano passado nem data
}

mysqli_select_db($con, "KAIZENS");
$query_kaizen = "SELECT codigo from kaizens $w";
$kaizen = mysqli_query($con, $query_kaizen) or die(mysqli_error());
$row_kaizen = mysqli_fetch_assoc($kaizen);
?>

<html>
<body>	
	<?php
	do{ 
		echo '<iframe  name="iframeKaizens" style="border:1px white" id="iframeXLS" align="center" height="1px" width="1px" src="/kaizens/baixakaizen.php?codedit='.$row_kaizen['codigo'].'","_blank"" ></iframe>';		
	}while($row_kaizen = mysqli_fetch_assoc($kaizen)); 
	?>
</body>
</html>