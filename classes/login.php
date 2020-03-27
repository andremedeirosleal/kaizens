<?php 
//Não exibe warnings
error_reporting(0);
ini_set("display_errors", 0 );
session_start();

//Configuração de idioma
header('Content-Type:text/html;charset=utf-8');
?>


<html >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Login</title>
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
	alert("ALERTA!\n\nAlgumas funcionalidades deste sistema não funcionam bem no 'INTERNET EXPLORER'.\n\É recomendado utilizar o 'FIREFOX' ou 'CRHOME'." );
	
	
	function isNumberKey(evt){
    	var charCode = (evt.which) ? evt.which : event.keyCode
	    if (charCode > 31 && (charCode < 48 || charCode > 57))
	        return false;
	    return true;
		}
	
	function ChecaCaller(){
		window.alert("chamou");
	}
	
	
	function CaixaAlta(){
		var x = document.getElementById("nome").value;
		document.getElementById("nome").value = x.toUpperCase();
		}	
	
	function ValidaLogin()
	{
		var continuar = 1;		
		var x = document.getElementById("nome").value;		
		var Tuser = x.length;
		var y = document.getElementById("senha").value;		
		var Tsenha = y.length;
		
		<!--valida usuário-->
		if (Tuser < 1)
			{
			continuar = 0;			
			window.alert("Dige sua matrícula com 8 dígitos (incluindo 01).");		
			document.getElementById("matricula").focus();									
			}
			
		<!--valida senha-->			
		if (continuar == 1)
			{
			if (Tsenha < 1)
				{
				continuar = 0;						
				window.alert("Campo SENHA não pode ficar em branco.");				
				document.getElementById("senha").focus();							
				}						
			}	
		
		if (continuar < 1)
			{			
			return false;
			}		
	
	}

	function Help(){window.alert("Para suporte ou sugestões, envie um email para: \nSuporte.Tovm@Vale.com");}
	
	//função que verifica o capslock

	function checar_caps_lock(e){
		kc = e.keyCode?e.keyCode:e.which;
		sk = e.shiftKey?e.shiftKey:((kc == 16)?true:false);
		if(((kc >= 65 && kc <= 90) && !sk)||((kc >= 97 && kc <= 122) && sk))
			document.getElementById('divalert').style.visibility = 'visible';
		else
			document.getElementById('divalert').style.visibility = 'hidden';
	}
	
	
	function RecuperaSenha(){
		//alert('Entre em contato com seu apoio ou envie e-mail para "Suporte.Tovm@Vale.com".');
		var matricula = document.getElementById("matricula").value;
		
		if (matricula.length < 8){
			alert("Preencha sua matrícula e clique novamente em: 'ESQUECI A SENHA'.");
			document.getElementById("matricula").focus();
		}else{
			window.location ="mail.php?mat=" + matricula;
		}			
	}

	</script>
	
	<script>
	    $(window).load(function(){
			$('#squarespaceModal').modal('show');
			setTimeout(function(){					
				document.getElementById("matricula").focus();				
			},500);
		});
	</script>
</head>


<body>
<div class="modal fade alert" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel">Login</h3>
        </div>
        <div class="modal-body">
            <form id="formLogin" name="formLogin" method="post" action="/classes/autenticar.php">
              <div class="form-group">
                <label for="exampleInputEmail1">Matrícula</label>
                <input type="text" maxlength="8" class="form-control" name="matricula" id="matricula" placeholder="Entre com sua mátricula (8 digitos)" onKeyPress="return isNumberKey(event)" autofocus onKeyUp="CaixaAlta()">
              </div>
              
              <div class="form-group">
                <label for="exampleInputPassword1">Senha   </label>
                <input type="password" class="form-control" name="senha" id="senha" placeholder="Entre com a Senha" onKeyPress="checar_caps_lock(event)">
                <div align="center"  id="divalert" style="visibility: hidden; color:#FF0000">CAPS LOCK ATIVADO</div>
			  </div>
   
				
              	<button type="submit" id="btnvale" style="width:200px;height:30px; margin-top:14px" title="Validar usuário" class="btn btn-primary center-block" onkeypress="return ValidaLogin()">Login</button>
			</form>	
			

			<div >
				<br>
				<div align="center">
					<div class="btn-group" style="padding-top:10px" align="center">				
						<a href="#" title="Esqueci a senha" class="btn btn-default" style="width:200px;color:blue" onclick="RecuperaSenha()">Esqueci a senha</a>
						<a href="/classes/usuarios/usuarios_cadastrar.php" title="Criar meu cadastro" class="btn btn-default" style="width:200px">Não tenho cadastro</a>
						<a href="#" title="Ajuda" class="btn btn-default" onclick="Help()">Ajuda</a>				
						<a href="/index.php" title="Seguir para Portal TO" class="btn btn-default">Portal TO</a>
					</div>
				</div>
			</div>			
        </div>
    </div>
  </div>
</div>


<script>

$('#squarespaceModal').on('hidden.bs.modal', function (e) { 
	$('#squarespaceModal').modal('show');	
})

</script>



<script language="javascript">	
	ValidaForm(){
		var matricula =  document.getElementById("matricula").value;
		
		if (matricula.length < 8) alert ("Preencha o campo 'MATRÍCULA' com oito dígitos (incluindo o 01).");
		return false
	}
</script>

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

</style>
<!-- Popup Modal Window - END -->

</body>
</html>
