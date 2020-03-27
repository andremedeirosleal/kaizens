<?php 
header('Content-Type:text/html;charset=utf-8');					//Configuração de idioma
session_start();
//include($_SESSION['menu']);										//inclui menu do caller
?>
<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<link href="/classes/style.css" rel="stylesheet" type="text/css">      
	
	<!--bootstrap-->
	<link rel="stylesheet" type="text/css" href="/lib/bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="/lib/js/jquery-3.2.1.min.js"></script>    
	<script type="text/javascript" src="/lib/bootstrap/js/bootstrap.min.js"></script> 
	
	<style type="text/css">				
		.form-control {
			height: 27px;
			font-size:12px;
		}
		.field_name{
			color:gray;
		}
		.titulo{
			font-size:16px;
			font-weight:bold;
		}	
		
		.img-usuario{
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 10px 0 rgba(0, 0, 0, 0.15);
			height:120px !important;
			width:100px !important;
		}
		
		.btnvale, #btnvale{
			background-color: #007E7A ;
			width: 150px;
			height: 32px;
			border-radius:5px;
			border: none !important;
			color: white !important;
		}
		.btnvale:hover, #btnvale:hover{
			background-color: #009D98 ;	
			color:white !important;
		}
		
		.thumb-image1{
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 10px 0 rgba(0, 0, 0, 0.15);
			height:120px !important;
			width:100px !important;
		}
	</style>
	
<script language="javascript">
	setgerencia();				
	
	function setgerencia(){			
		var str = "";
		$('#gerencia').html('');
		$.getJSON("/classes/locacao/gerencias_ajax.php?w="+str, function(result){
			$('#gerencia').append($('<option>').text("").attr('value', ""));
			for(i = 0; i< result.data.length; i++){   
				$('#gerencia').append($('<option>').text(result.data[i].NM_GERENCIA).attr('value', result.data[i].ID_GERENCIA));					
			}
		});
	}
	
	//carrega as gerencias
	setturmas();
	function setturmas(){			
		var str = "";
		$('#ID_TURMA').html('');
		$.getJSON("/classes/locacao/turmas_ajax.php"+str, function(result){			
			for(i = 0; i< result.data.length; i++){   
				$('#ID_TURMA').append($('<option>').text(result.data[i].DS_TURMA).attr('value', result.data[i].ID_TURMA));					
			}
		});
	}
	
	function setID_SUPERVISAO(str){			
		$('#ID_SUPERVISAO').html('');
		$.getJSON("/classes/locacao/supervisoes_ajax.php?w="+str, function(result){
			for(i = 0; i< result.data.length; i++){ 					
				$('#ID_SUPERVISAO').append($('<option>').text(result.data[i].NM_SUPERVISAO).attr('value', result.data[i].ID_SUPERVISAO));				
			}
		});
		
		//carrega centro de trabalho da supervisao (somente geseg)
		if (Number(str) == 1) {
			$('#sgm').css('display', 'inline-block');
			set_centro_trabalho(1);	//seta para bordo, que é o primeiro da lista
		}else $('#sgm').css('display', 'none');
	}
	
	function set_centro_trabalho(str){				
		var ger = document.getElementById("gerencia").value;		
		if (ger ==1){			
			$('#ID_CENTRO_TRABALHO').html('');
			str = "/classes/locacao/centros_trabalhos_ajax.php?w="+str;
			$.getJSON(str, function(result){			
				for(i = 0; i< result.data.length; i++){   
					$('#ID_CENTRO_TRABALHO').append($('<option>').text(result.data[i].DS_CENTRO_TRABALHO).attr('value', result.data[i].ID_CENTRO_TRABALHO));					
				}
			});
		}
	}
	
	function redirecionar(){
			window.location="<?php echo $_SESSION['caller']; ?>";
		}

	function CaixaAlta(){
		var x = document.getElementById("NM_USUARIO").value;
		document.getElementById("NM_USUARIO").value = x.toUpperCase();
		}

	function isNumberKey(evt){
    	var charCode = (evt.which) ? evt.which : event.keyCode
	    if (charCode > 31 && (charCode < 48 || charCode > 57))
	        return false;
	    return true;
		}

	var matcadastrada;		
	function ValidaForm(){				
		var str = "";				
		var senha1 = document.getElementById("DS_SENHA").value;
		var senha2 = document.getElementById("senha2").value;
		var ID_SUPERVISAO = document.getElementById("ID_SUPERVISAO").value;
		var email = document.getElementById("DS_EMAIL").value;
		var nome = document.getElementById("NM_USUARIO").value;
		var mat = document.getElementById("CD_MATRICULA").value;
		
		if (nome.length < 2){			
			window.alert("Preencha o campo 'NOME' com mais caracteres.");
			document.getElementById("NM_USUARIO").focus();
			return false;
		}
		
		if (mat.length < 8){			
			window.alert("Preencha o campo 'MATRÍCULA' com 8 digitos (incluindo 01).");
			document.getElementById("CD_MATRICULA").focus();
			return false;
		}
		
		
		checamatricula();
		if (matcadastrada == true){
			return false;
		}
		
		if (ID_SUPERVISAO==" " ){			
			window.alert("Preenca corretamente o campo 'SUPERVISAO'.");
			document.getElementById("ID_SUPERVISAO").focus();				
			return false;
		}		
		
		if (senha1 != senha2){			
			window.alert("Repetição da senha não conferiu.");
			document.getElementById("senha2").focus();				
			return false;
		}		

		if(email.length > 10 && email.indexOf('@vale.com')== -1 ){
			window.alert("Insira um E-MAIL válido.");
			document.getElementById("DS_EMAIL").focus();
			return false;				
		}else{
			if (email.length < 10) {
				window.alert("Insira um E-MAIL válido.");
				document.getElementById("DS_EMAIL").focus();					
				return false;				
			}
		}

		return true;		
	}
			
	$(document).ready(function() {
		$("#TP_FOTO_USUARIO").on('change', function () { 			
			if (typeof (FileReader) != "undefined") {
				var tamanhoArquivo = parseInt(document.getElementById("TP_FOTO_USUARIO").files[0].size);
				if(tamanhoArquivo > 250000){ 
					alert("O tamanho máximo permitido é 250 KB.");
				} else {

				var image_holder_antes = $("#foto");
				image_holder_antes.empty();
		 
				var reader = new FileReader();
				reader.onload = function (e) {
					$("<img />", {
						"src": e.target.result,
						"class": "thumb-image1"
					}).appendTo(image_holder_antes);
				}
				image_holder_antes.show();
				reader.readAsDataURL($(this)[0].files[0]);}
			} else{
				alert("Este navegador nao suporta FileReader.");
			}
		});
	});
</script>
</head>
<body> 
<div align="center">
	<div align="center" class="panel panel-default" style="width:620px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 10px 0 rgba(0, 0, 0, 0.15); margin-top:30px; text-align:center">
		<div align="center" class="panel-heading" style="width:620px; text-align:center">
			<div class="panel-body">

				<form name="formdados" method="post" action="controles_ajax.php" enctype="multipart/form-data">
					<p align="center"><span class="titulo">Cadastro de Usuário </span></p>
					<table width="474" height="140" border="0" align="center" bordercolor="#CCCCCC">
						<tr>
							<th width="468" scope="col">
								<table width="465" border="0" align="center">
									<tr>
										<td width="207" height="30" class="field_name"><div align="right" class="field_name"><strong>Nome &nbsp</strong></div></td>
										<td width="208" height="30"><input class="form-control" type="text" maxlength="50" name="NM_USUARIO" id="NM_USUARIO" style="width:200px"  onKeyUp="CaixaAlta()" /></td>
										<td width="208" height="30">										
											<div align="center"><label class="custom-file-input1" for="TP_FOTO_USUARIO" ></label></div>
										</td>
									</tr>
									<tr>
										<td class="field_name" height="30"><div align="right" class="field_name"><strong>Matrícula &nbsp</strong></div></td>
										<td><input type="text" class="form-control"  maxlength="8" name="CD_MATRICULA" id="CD_MATRICULA" autocomplete="off" style="width:200px" onKeyPress="return isNumberKey(event)" /></td>
										<td rowspan="5">
											<div align="center" id="foto">
												<img class="img-usuario" src="/images/blank.png"/>
											</div>
										</td>
									</tr>
									<tr>
										<td class="field_name" height="30"><div align="right" class="field_name"><strong>Gerência &nbsp</strong></div></td>
										<td>
											<select onchange="setID_SUPERVISAO(this.value)" class="form-control" id="gerencia" required style="width:200px;" >																					
											</select>				
										</td>
									</tr>		  
									<tr>
										<td class="field_name" height="30"><div align="right" class="field_name"><strong>Supervisão &nbsp</strong></div></td>
										<td>
											<select onchange="set_centro_trabalho(this.value)" class="form-control" name="ID_SUPERVISAO" id="ID_SUPERVISAO" required style="width:200px;">																														
											</select>
										</td>
									</tr>
									<tr>
										<td class="field_name" height="30"><div align="right" class="field_name"><strong>Senha &nbsp</strong></div></td>
										<td><input class="form-control"  type="password" maxlength="50" name="DS_SENHA" id="DS_SENHA" style="width:200px" /></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" class="field_name"><div align="right" class="field_name"><strong>Repita a senha &nbsp</strong></div></td>
										<td><input class="form-control"  type="password" maxlength="10" id="senha2" style="width:200px" /></td>
									</tr>
									<tr>
										<td align="right" valign="middle" class="field_name" height="30"><strong>E-mail &nbsp</strong></td>
										<td><input class="form-control"  type="text" maxlength="100" name="DS_EMAIL" required id="DS_EMAIL" style="width:200px" /></td>
									</tr>
									<tr>
										<td align="right" valign="middle" class="field_name" height="30"><strong>Turma &nbsp</strong></td>
										<td><select class="form-control"  name="ID_TURMA"  id="ID_TURMA" style="width:200px" /></td>
									</tr>
									
									<tr>
										<td colspan=3>
											<div id="sgm">
												<table width="100%" align="center">
													<tr >
														<td colspan=2>
															<hr/>
															<center><b>Dados SAP</b></center>
														</td>
													</tr>
													<tr >
														<td align="right" valign="middle" class="field_name" height="30"><strong>Centro de Trabalho &nbsp</strong></td>
														<td><select class="form-control"  name="ID_CENTRO_TRABALHO"  id="ID_CENTRO_TRABALHO" style="width:200px" /></td>
													</tr>
													<tr >
														<td align="right" valign="middle" class="field_name" height="30"><strong>Matrícula SAP &nbsp</strong></td>
														<td><input class="form-control"  name="NR_SAP"  onKeyPress="return isNumberKey(event)" id="NR_SAP" style="width:200px" /></td>
													</tr>
												</table>
											</div>
										</td>
									</tr>
								</table>
							</th>
						</tr>
					</table>
					<br>
					<input id="TP_FOTO_USUARIO" name="TP_FOTO_USUARIO" type="file" accept="image/*" style="visibility: hidden; width:1px"/>				
					<input type="hidden" name="acao" id="acao" value="incluir"/>					
					<input type="hidden" name="ID_USUARIO" id="ID_USUARIO" value="<?php echo $_REQUEST['codedit']; ?>"/>					 
					<button class="btn btn-primary btnvale" id="btnvale" align="middle" style="width:200px;height:30px" type="submit" onClick="return ValidaForm()">Salvar</button><!--onClick="return ValidaForm()"-->
					<button class="btn btn-primary btnvale" id="btnvale" align="middle" style="width:200px;height:30px" type="button" onClick="location='/index.php'">Cancelar</button>					
				</form>	
			</div>
		</div>
	</div>		
</div>
	<style>
		#sgm{display:none}
	</style>
</body>
</html>