<?php 
//Configuração de idioma
header('Content-Type:text/html;charset=utf-8');
include($_SERVER['DOCUMENT_ROOT']."/classes/funcoes.php");
include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php");

//Não exibe warnings
error_reporting(0);
ini_set("display_errors", 0 );
session_start();

?>

<!DOCTYPE html>
<html >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Trocar Senha</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="/images/icon.ico" />
	
    <link href="/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/lib/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/lib/bootstrap/font-awesome/css/font-awesome.min.css" />
    <script type="text/javascript" src="/lib/jquery/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="/lib/bootstrap/js/bootstrap.min.js"></script>
		
	<script language="javascript">
		//Verifica se é Internet Explorer e da um alerta.
		var IE = "";
		IE = (document.documentMode);	
		if (IE >0)

		function isNumberKey(evt){
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
			return true;
			}
			
		function CaixaAlta(){
			var x = document.getElementById("nome").value;
			document.getElementById("nome").value = x.toUpperCase();
			}	
		
		function valida_dados(){						
			var senha = document.getElementById("senha").value;
			var senha2 = document.getElementById("senha2").value;				
			
			if(forca <100){
				alert("A senha precisa atender a todos os requisitos.\nConsulte ajuda para detalhes.");	
				document.getElementById("senha").focus();
				return false;
			}
			
			if (senha.length < 10){
				alert("Preencha o campo 'SENHA' corretamente.");	
				document.getElementById("senha").focus();
				return false;
			}
			
			if (senha != senha2){
				alert("Repetição de senha não confere.");				
				document.getElementById("senha2").focus();
				return false;
			}			
		}

		function Help(){
			var str = "";
			str += "Regras para senha\n\n";
			str += "Ter letras maiúsculas\n";
			str += "Ter letras minúsculas\n";
			str += "Ter números\n";
			str += "Ter caracteres especiais\n";
			str += "Ter no mínimo 10 caracteres\n\n\n";
			str += "Para suporte ou sugestões, envie um email para: \nSuporte.Tovm@Vale.com";
			alert(str);
		}
		
		//função que verifica o capslock
		function checar_caps_lock(e){
			kc = e.keyCode?e.keyCode:e.which;
			sk = e.shiftKey?e.shiftKey:((kc == 16)?true:false);
			if(((kc >= 65 && kc <= 90) && !sk)||((kc >= 97 && kc <= 122) && sk))
				document.getElementById('divalert').style.visibility = 'visible';
			else
				document.getElementById('divalert').style.visibility = 'hidden';
		}	
		
		var forca = 0;
		function verifica(){
			senha = document.getElementById("senha").value;
			forca = 0;
			mostra = document.getElementById("mostra");

			if(senha.match(/[a-z]+/)){forca += 20;}				//letras minusculas
			if(senha.match(/[A-Z]+/)){forca += 20;}				//letras maiusculas
			if(senha.match(/[0-9]+/)){forca += 20;}				//numeros
			if(senha.match(/[!-)]+/)){ forca += 20;}else		//primeira sequencia de caracteres especiais
			if(senha.match(/[@,¨,*,\-,+,=]+/)){forca += 20;}	//segunda sequencia de caracteres especiais
			if(senha.length >= 10){forca += 20;}
			return mostra_res();
		}
		function mostra_res(){
			if(forca < 50){
				mostra.innerHTML = '<tr><td><div class="bgred" style="width:'+forca+'px"> '+forca+'% </td></td></tr>';
			}else if((forca >= 50) && (forca < 80)){
				mostra.innerHTML = '<tr><td><div class="bgyellow" style="width:'+forca+'px"> '+forca+'% </td></tr>';
			}else if((forca >= 80) && (forca < 100)){
				mostra.innerHTML = '<tr><td><div class="bgblue" style="width:'+forca+'px"> '+forca+'% </tr>';
			}else if(forca >= 100){
				mostra.innerHTML = '<tr><td><div class="bggreen" style="width:100%"> '+forca+'% </tr>';
			}
		}


	    $(window).load(function(){				
			setTimeout(function(){	
				document.getElementById("senha").value = "";
				document.getElementById("senha").focus();				
			},500);
			
			var msg_sucesso = 'SENHA ALTERADA COM SUCESSO!\n\nATENÇÃO!\nEmprestar senhas vai contra as políticas de segurança da Vale.';
			var msg_erro = 'Houve um erro ao alterar sua senha.\nFavor contactar o suporte.';
			
			//salva alteração e exibe mensagem
			<?php if (isset($_REQUEST['acao']) && $_REQUEST['acao'] == "salvar"){				
				$senha = hash('gost',$_REQUEST['senha'].$codigo_hash);
				$id = $_REQUEST['id_usuario'];
				$sql = "UPDATE USUARIOS.TBL_USUARIOS set DS_SENHA = '$senha' WHERE ID_USUARIO = $id";
				mysqli_select_db($con,'USUARIOS');
				$query = mysqli_query($con, $sql);
				if ($query) echo "alert(msg_sucesso);";
				else echo "alert(msg_erro);";
				echo "location='/portal/';";
			}else{ 				
				echo "$('#modalsenha').modal('show');";					
			}?>				
		});
		
	</script>
</head>


<body>
<div class="modal fade alert" id="modalsenha" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel">Trocar a Senha</h3>
        </div>
        <div class="modal-body">
            
			<form id="form1" name="form1" autocomplete="off" method="post" onsubmit="return valida_dados()" action="trocar_senha.php">
				<div class="form-group">
					<label for="">Senha   </label>
					<table align="right" border=1 class="tb_nivel" id="mostra"></table>
					<input type="password"  autocomplete="off" class="form-control" name="senha" id="senha" placeholder="Entre com a Senha" onkeyup="javascript:verifica()" onKeyPress="checar_caps_lock(event)">					
				</div>
				  
				<div class="form-group">
					
					<label for="">Repita a senha  </label>
					<input type="password" class="form-control" id="senha2" placeholder="Repita a senha" onKeyPress="checar_caps_lock(event)">
					<div align="center"  id="divalert" style="visibility: hidden; color:#FF0000">CAPS LOCK ATIVADO</div>
				</div> 
				
				<input type="hidden" name="id_usuario" id="id_usuario" value = "<?php echo $_REQUEST['id_usuario']; ?>"/>
				<input type="hidden" name="acao" id="acao" value = "salvar"/>
				
				<button id="btnvale" style="width:200px;height:30px; margin-top:14px" class="btn btn-primary center-block" >Salvar</button>				
			</form>				

			<div>				
				<div align="center">
					<div class="btn-group" style="padding-top:10px" align="center">								
						<a href="#" title="Ajuda" class="btn btn-default" onclick="Help()">Ajuda</a>				
						<a href="/index.php" title="Seguir para Portal TO" class="btn btn-default">Portal TO</a>
					</div>
				</div>
			</div>			
        </div>
    </div>
  </div>
</div>

<style>
	.center {
		margin-top:50px;   
	}

	.modal-header {
		padding-bottom: 5px;
	}

	.modal-footer {
			padding: 0;
	}
		
	.modal-footer .btn-group button {
		height:40px;
		border-top-left-radius : 0;
		border-top-right-radius : 0;
		border: none;
	}
		
	.modal-footer .btn-group:last-child > button {
		border-right: 0;
	}

	.btn-default{width:80px; text-align:center;}
	#btnvale{background-color:#007D6B;Border-color:gray; color:white; }
	#btnvale:hover{background-color: #009D98; }
	
	
	.tb_nivel td{text-align:center; width:102px; font-size:12px; border:1px solid black;}	
	.bgred{background-color: rgba(255,0,0,0.7); color:white;}
	.bgyellow{background-color: rgba(255,255,0,1); color:black;}
	.bgblue{background-color: rgba(0,0,255,0.6);color: white}
	.bggreen{background-color: rgba(0,255,0,0.5); color: black;}	
</style>
</body>
</html>

