<?php 
header('Content-Type: application/json; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php");
include($_SERVER['DOCUMENT_ROOT']."/classes/funcoes.php");
session_start();

//EMPREGADO
$w = $_GET['w'];
$ano = $_GET['a'];

//QUERY DADOS		
mysqli_select_db($con, "KAIZENS");
$sql = "
SELECT total, mes, ano FROM (
select colab1, colab2, colab3, colab4, colab5, count(codigo)total, month(data)mes, year(data)ano from kaizens where colab1 = $w
and year(data)=$ano
group by colab1, mes, ano

union

select colab1, colab2, colab3, colab4, colab5, count(codigo)total, month(data)mes, year(data)ano from kaizens where colab2 = $w
and year(data)=$ano
group by colab2, mes, ano

union

select colab1, colab2, colab3, colab4, colab5, count(codigo)total, month(data)mes, year(data)ano from kaizens where colab3 = $w
and year(data)=$ano
group by colab3, mes, ano

union

select colab1, colab2, colab3, colab4, colab5, count(codigo)total, month(data)mes, year(data)ano from kaizens where colab4 = $w
and year(data)=$ano
group by colab3, mes, ano

union

select colab1, colab2, colab3, colab4, colab5, count(codigo)total, month(data)mes, year(data)ano from kaizens where colab5 = $w
and year(data)=$ano
group by colab3, mes, ano
)tbl order by ano, mes" ;


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
