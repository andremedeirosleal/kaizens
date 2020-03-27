<?php 
header('Content-Type: application/json; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php");
include($_SERVER['DOCUMENT_ROOT']."/classes/funcoes.php");

noerrors();
session_start();

//LOCACAÇÃO//-------------------------------------------------------------------------
//GERENCIA
if ($_GET['g'] == '0') $w = " WHERE 1=1 ";	//todas as supervisoes
else $locacao = " WHERE id_gerencia =" . $_GET['g'];	

//SUPERVISAO
if ($_GET['s'] == '0') $w .= " AND 1=1 ";	//todas as supervisoes
else $locacao .= " AND id_supervisao =" . $_GET['s'];	




//periodo//----------------------------------------------------------------------------
//DE HOJE
$periodo = " WHERE 1=1 ";
if (isset($_GET['o']) && $_GET['o']=='1'){	
	$periodo .= " AND data = CURDATE()";
}

//DE ONTEM
if (isset($_GET['o']) && $_GET['o']=='2'){	
	$periodo .= " AND data = (CURDATE() -1)";
}

//MES ATUAL
if (isset($_GET['o']) && $_GET['o']=='3'){	
	$periodo .= " AND MONTH(data) = MONTH(CURDATE()) ";
}

//MES ANTERIOR
if (isset($_GET['o']) && $_GET['o']=='4'){	
	$periodo .= " AND MONTH(data) = (MONTH(CURDATE())-1) ";
}

//DO ANO
if (isset($_GET['o']) && $_GET['o']=='5'){	
	$periodo .= " AND YEAR(data) = YEAR(CURDATE())  ";
}

//DO ANO PASSADO
if (isset($_GET['o']) && $_GET['o']=='6'){	
	$periodo .= " AND YEAR(data) = (YEAR(CURDATE())-1) ";
}

//ENTRE DATAS
if (isset($_GET['di']) && strlen($_GET['di'])> 0){	
	$periodo .= " AND data BETWEEN '". $_GET['di'] ."' AND '". $_GET['df'] ."'";
}else{
	if ($_GET['o'] != "6") $periodo .= " AND YEAR(data) = YEAR(CURDATE()) "; // se não é filtro por ano passado nem data
}

//QUERY DADOS		
mysqli_select_db($con, "KAIZENS");
$sql = "
SELECT * FROM (

select 
sum(qtd) Total, 
u.ID_USUARIO colab, 
u.CD_MATRICULA matricula, 
u.ID_SUPERVISAO id_supervisao, 
u.NM_USUARIO nome,
(SELECT 
	LOCACAO.TBL_GERENCIAS.NM_GERENCIA 
	FROM LOCACAO.TBL_SUPERVISOES 
	LEFT JOIN LOCACAO.TBL_GERENCIAS ON LOCACAO.TBL_GERENCIAS.ID_GERENCIA = LOCACAO.TBL_SUPERVISOES.ID_GERENCIA 
	WHERE LOCACAO.TBL_SUPERVISOES.ID_SUPERVISAO = u.ID_SUPERVISAO
)gerencia,
(select LOCACAO.TBL_SUPERVISOES.NM_SUPERVISAO FROM LOCACAO.TBL_SUPERVISOES WHERE LOCACAO.TBL_SUPERVISOES.ID_SUPERVISAO = u.ID_SUPERVISAO)nm_supervisao,
(select LOCACAO.TBL_SUPERVISOES.ID_GERENCIA FROM LOCACAO.TBL_SUPERVISOES WHERE LOCACAO.TBL_SUPERVISOES.ID_SUPERVISAO = u.ID_SUPERVISAO)id_gerencia

from USUARIOS.TBL_USUARIOS u,

/*colab1 */
(select  count(codigo) qtd, colab1 colab, 1 a
from kaizens k1 
".$periodo."
group by k1.colab1

union

/*colab2 */
select count(codigo) qtd, colab2 colab, 2 a
from kaizens k2 
".$periodo."
group by k2.colab2

union

/*colab3 */
select count(codigo) qtd, colab3 colab, 3 a
from kaizens k3
".$periodo."
group by k3.colab3

union

/*colab4*/
select count(codigo) qtd, colab4 colab, 4 a
from kaizens k4 
".$periodo."
group by k4.colab4

union

/*colab5 */
select count(codigo) qtd, colab5 colab, 5 a
from kaizens k5 
".$periodo."
group by k5.colab5

) t
where t.colab = u.ID_USUARIO AND u.BT_ATIVO=1
group by u.ID_USUARIO, u.NM_USUARIO, u.ID_SUPERVISAO
order by 1 desc)tbl $locacao" ;


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
