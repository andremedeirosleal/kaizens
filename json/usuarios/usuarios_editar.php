<?php
header('Content-Type:text/html;charset=utf-8');					//Configuração de idioma

session_start();

include($_SESSION['menu']);										//inclui menu do caller

mysqli_select_db($con, 'USUARIOS');

noerrors();


//Checa permissão de administrador de usuarios
$permissao = checapermissao(3);
if ($permissao == false){
	//Checa permissão de administrador de Kaizens (podem alterar usuarios da própria gerência);
	$permissao = checapermissao(1);	
	if ($permissao == false){	
		//Checa permissao e se o usuario logado é o mesmo a ser editado
		$permissao = checausuario($_REQUEST['codedit']);		
		if (!$permissao){
			echo '<script type="text/javascript">alert("Seu acesso não possui permissão para essa ação.")</script>';	
			echo '<script type="text/javascript">window.location="'  .$_SESSION['caller']. '"</script>';
		}
	}else{
		//Checa se usuario é da mesma gerência
		/*$permissao = false;
		$sql = "SELECT LOCACAO.TBL_GERENCIAS.ID_GERENCIA as ID_GERENCIA  
		FROM TBL_USUARIOS
		inner join LOCACAO.TBL_SUPERVISOES ON TBL_USUARIOS.ID_SUPERVISAO = LOCACAO.TBL_SUPERVISOES.ID_SUPERVISAO
		inner join LOCACAO.TBL_GERENCIAS on LOCACAO.TBL_GERENCIAS.ID_GERENCIA = LOCACAO.TBL_SUPERVISOES.ID_GERENCIA
		WHERE TBL_USUARIOS.ID_USUARIO =" .$_REQUEST['codedit'];
		
		$query = mysqli_query($con, $sql);
		$row = mysqli_fetch_assoc($query);
		if ($row['ID_GERENCIA'] == $_SESSION['ID_GERENCIA']) $permissao = true;
				
		if (!$permissao){
			echo '<script type="text/javascript">alert("Seu acesso permite editar apenas usuários da mesma gerência.")</script>';
			return;
		} */		
	}
}else{
	echo '<script type="text/javascript">window.location="/classes/usuarios/usuarios_editar_adm.php?codedit='.$_REQUEST['codedit'].'"</script>';

}


//Mantém os dados dos campos durante o submit da foto, se não for salvar
if (isset($_REQUEST['codedit']) && strlen($_REQUEST['codedit']) >0){
	//codigo edit ok
}else{
	echo '<script type="text/javascript">alert("' . "CÓDIGO INVÁLIDO." . '")</script>';	
	echo '<script type="text/javascript">window.location="'  .$_SESSION['caller']. '"</script>';
}

//ENCONTRA A GERENCIA DA SUPERVISAO DO USUARIO
$query_ger = "SELECT
TBL_USUARIOS.ID_USUARIO,
TBL_USUARIOS.NM_USUARIO,
TBL_USUARIOS.CD_MATRICULA,
TBL_USUARIOS.ID_SUPERVISAO,
TBL_USUARIOS.DS_SENHA,
TBL_USUARIOS.DS_EMAIL,
TBL_USUARIOS.ID_TURMA,
TBL_USUARIOS.ID_CENTRO_TRABALHO,
TBL_USUARIOS.NR_SAP,
TBL_USUARIOS.TP_FOTO_USUARIO,
LOCACAO.TBL_GERENCIAS.ID_GERENCIA as ID_GERENCIA, LOCACAO.TBL_GERENCIAS.NM_GERENCIA as  NM_GERENCIA, 
LOCACAO.TBL_SUPERVISOES.ID_SUPERVISAO, LOCACAO.TBL_SUPERVISOES.NM_SUPERVISAO
FROM TBL_USUARIOS
inner join LOCACAO.TBL_SUPERVISOES ON TBL_USUARIOS.ID_SUPERVISAO = LOCACAO.TBL_SUPERVISOES.ID_SUPERVISAO
inner join LOCACAO.TBL_GERENCIAS on LOCACAO.TBL_GERENCIAS.ID_GERENCIA = LOCACAO.TBL_SUPERVISOES.ID_GERENCIA
WHERE TBL_USUARIOS.ID_USUARIO = " .$_REQUEST['codedit'];
$query = mysqli_query($con, $query_ger) or die(mysql_error());
$row_dados = mysqli_fetch_assoc($query);
$gerencia= $row_dados['ID_GERENCIA'];
$ID_SUPERVISAO= $row_dados['ID_SUPERVISAO'];

//checa se existe o usuario
if ($row_dados['ID_USUARIO'] > 0){
	//ok
}else{
	echo '<script type="text/javascript">alert("' . "CÓDIGO INVÁLIDO." . '")</script>';	
	echo '<script type="text/javascript">window.location="'  .$_SESSION['caller']. '"</script>';
}

//checa se existe foto no cadastro
if (strlen($row_dados['TP_FOTO_USUARIO'])>0)
	$foto = "/classes/usuarios/usuarios_foto_visualizar.php?codigo=".$_REQUEST['codedit'];
else
	$foto = "/images/blank.png";

?>

<html>
<head>
	<meta charset="utf-8">
	<link href="/classes/style.css" rel="stylesheet" type="text/css">  
		
	<script language="javascript">	
		//define o menu ativo			
		$("#mnusuarios").addClass("active");
		setgerencia();				
		setID_SUPERVISAO('"<?php echo $gerencia;?>"');	

		var ger = "<?php echo $gerencia;?>";
		var sup = "<?php echo $ID_SUPERVISAO;?>";
		set_centro_trabalho(sup);	
		
		function redirecionar(){			
			window.location="<?php echo $_SESSION['caller']; ?>";
			return false;
		}
		
		function CaixaAlta(){
			var x = document.getElementById("nome").value;
			document.getElementById("nome").value = x.toUpperCase();
			}

		function isNumberKey(evt){
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
			return true;
			}
		
		
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
			
			if (checamatricula())
				return false;
			
			
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
				window.alert("Insira um e-mail válido.");
				document.getElementById("DS_EMAIL").focus();
				return false;				
			}else{
				if (email.length < 10) {
					window.alert("Insira um e-mail válido.");
					document.getElementById("DS_EMAIL").focus();
								
					return false;				
				}
			}
						
			return true; 		
		}
		
		function checamatricula(){
			var mat = document.getElementById("CD_MATRICULA").value;
			$.getJSON("/classes/usuarios/usuarios_ajax?m="+mat, function(result){				
				alert(result.data[0][1]);				
			});		
			return false;
		}
		
		//carrega as gerencias
		function setgerencia(){			
			var str = "";			
			$('#gerencia').html('');
			$.getJSON("/classes/locacao/gerencias_ajax.php?w="+str, function(result){
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
		
			
		window.onload = function() {		
			setTimeout(function(){					
				document.getElementById("gerencia").value = ger;					
				document.getElementById("ID_SUPERVISAO").value = sup;		
				document.getElementById("ID_TURMA").value = "<?php echo $row_dados['ID_TURMA'];?>";					
				
				//Se for GESEG exibe dados do SAP
				if (ger == 1){					
					document.getElementById("sgm").style.display = "inline-block";
					document.getElementById("ID_CENTRO_TRABALHO").value = "<?php echo $row_dados['ID_CENTRO_TRABALHO'];?>";
				}
			},500);				
		};	
	</script>
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
		img{
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 10px 0 rgba(0, 0, 0, 0.15);
			height:120;
			width:100;
		}
		#sgm{display:none}
	</style>
</head>
<body> 
<div align="center">
	<div align="center" class="panel panel-default" style="width:620px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 10px 0 rgba(0, 0, 0, 0.15); margin-top:30px; text-align:center">
		<div align="center" class="panel-heading" style="width:620px; text-align:center">
			<div class="panel-body">

				<form name="form1" method="post" action="controles_ajax.php" enctype="multipart/form-data">
					<p align="center"><span class="titulo">Edição de Usuário</span></p>
					<table width="474" height="140" border="0" align="center" bordercolor="#CCCCCC">
						<tr>
							<th width="468" scope="col">
								<table width="465" border="0" align="center">
									<tr>
										<td width="207" height="30" class="field_name"><div align="right" class="field_name"><strong>Nome &nbsp</strong></div></td>
										<td width="203" height="30"><input class="form-control" type="text" maxlength="50" name="NM_USUARIO" id="NM_USUARIO" style="width:200px" value="<?php echo $row_dados['NM_USUARIO'];?>"    onKeyUp="CaixaAlta()" /></td>
										<td width="123" height="30">							
											<div align="center"> <label class="custom-file-input1" for="TP_FOTO_USUARIO" ></label></div>
										</td>
									</tr>
									<tr>
										<td class="field_name" height="30"><div align="right" class="field_name"><strong>Matrícula &nbsp</strong></div></td>
										<td><input type="text" class="form-control" maxlength="8"  name="CD_MATRICULA" id="CD_MATRICULA" style="width:200px" value="<?php echo $row_dados['CD_MATRICULA'];?>" onKeyPress="return isNumberKey(event)" /></td>
										<td rowspan="5">
											<div align="center" id="foto">
												<img src="<?php echo $foto;?>" />												
											</div>
										</td>
									</tr>
									<tr>
										<td class="field_name" height="30"><div align="right" class="field_name"><strong>Gerência &nbsp</strong></div></td>
										<td>
											<select onchange="setID_SUPERVISAO(this.value)" class="form-control" id="gerencia" style="width:200px;" >																					
											</select>				
										</td>
									</tr>		  
									<tr>
										<td class="field_name" height="30"><div align="right" class="field_name"><strong>Supervisão &nbsp</strong></div></td>
										<td>
											<select class="form-control" name="ID_SUPERVISAO" id="ID_SUPERVISAO" style="width:200px;">																															
											</select>
										</td>
									</tr>								  
									<tr>
										<td height="30" class="field_name"><div align="right" class="field_name"><strong>Senha &nbsp</strong></div></td>
										<td><input class="form-control" type="password" maxlength="50" name="DS_SENHA" id="DS_SENHA" style="width:200px" value="<?php echo $row_dados['DS_SENHA'];?>"/></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" class="field_name"><div align="right" class="field_name"><strong>Repita a senha &nbsp</strong></div></td>
										<td><input class="form-control" type="password" maxlength="50" id="senha2" style="width:200px" value="<?php echo $row_dados['DS_SENHA'];?>"/></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" class="field_name"><strong>E-mail &nbsp</strong></td>
										<td><input class="form-control" type="text" maxlength="100" name="DS_EMAIL"  id="DS_EMAIL" style="width:200px" value="<?php echo $row_dados['DS_EMAIL'];?>"/></td>
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
														<td><input class="form-control"  name="NR_SAP"  onKeyPress="return isNumberKey(event)" id="NR_SAP" style="width:200px" value="<?php echo $row_dados['NR_SAP'];?>" /></td>
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
					<input type="hidden" name="acao" id="acao" value="editar"/>					
					<input type="hidden" name="ID_USUARIO" id="ID_USUARIO" value="<?php echo $_REQUEST['codedit']; ?>"/>					 
					<button class="btn btn-primary btnvale" id="btnvale" align="middle" style="width:200px;height:30px" type="submit" onClick="return ValidaForm()">Salvar</button><!--onClick="return ValidaForm()"-->
					<button class="btn btn-primary btnvale" id="btnvale" align="middle" style="width:200px;height:30px" type="button" onClick="return redirecionar()">Cancelar</button>					
				</form>
			</div>
		</div>
	</div>
</div>

</body>
</html>