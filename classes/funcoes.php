<?php 
$codigo_hash = "@utomaca0";

//FUNCOES GENERICAS MAIS UTILIZADAS 
function checalogin(){
	session_start();
	//Verifica se o usuario está logado, senão solicita o login	
	if (isset($_SESSION['ID_USUARIO'])){	  
		return true;
	}else{			
		$html = '<html><body>
				<script type="text/javascript">
					alert("POR FAVOR, EFETUE LOGIN.");
					window.location="/classes/login.php";
				</script>
				</body></html>';	
		echo $html;
		return false;
	}	
}



//Impede a exibição de warnings do php
function noerrors(){	
	error_reporting(0);
	ini_set("display_errors", 0 );
}



//Verifica se usuário possui a permissao especificada
function checapermissao($ID_PERMISSAO){	
	//$ID_PERMISSAO é o código no banco de dados referente a permissão pesquisada no array de permissões (é carregado ao efetuar login)
	checalogin();
		
	$permitido = false;
	foreach($_SESSION['permissoes'] as $x){		
		if ($x == $ID_PERMISSAO){	
			return true;				
		}
	}
	if ($permitido == false) return false; 	
}



//compara se o usuario logado é o mesmo pesquisado
function checausuario($codigo){
	checalogin();
	if ($_SESSION['ID_USUARIO'] != $codigo){
		return false;
	}else return true;
}
?>
