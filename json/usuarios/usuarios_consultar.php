<?php
header('Content-Type:text/html;charset=utf-8');					//Configuração de idioma

session_start();

if (!isset($_SESSION['ID_USUARIO'])) echo "<script>location='/classes/login.php';</script>'";

//captura a supervisao do usuario se nenhum parametro foi passado ainda
$_SESSION['ID_SUPERVISAO_USUARIO'] = $_SESSION['ID_SUPERVISAO'];


$gerencia = $_SESSION['ID_GERENCIA'];	


include($_SESSION['menu']);										//inclui menu do caller

checalogin();

mysqli_select_db($con, 'USUARIOS');

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta charset="utf-8">
	<script language="javascript">
	var codigoselecionado = 0;
	var table;
	var ajaxfile = '/classes/usuarios/usuarios_ajax.php';
	
	var gerencia = "<?php echo $gerencia;?>";


	window.onload = function() {
		setTimeout(function(){	
			document.getElementById("gerencia").value = "<?php echo $gerencia;?>";
		},500);	
	}
	setgerencia();			
		
	//carrega as gerencias
	function setgerencia(){			
		var str = "";
		$('#gerencia').html('');
		$.getJSON("/classes/locacao/gerencias_ajax.php?w="+str, function(result){
			$('#gerencia').append($('<option>').text("Todas").attr('value', ""));	
			for(i = 0; i< result.data.length; i++){   
				$('#gerencia').append($('<option>').text(result.data[i].NM_GERENCIA).attr('value', result.data[i].ID_GERENCIA));					
			}				
		});	
				
	}

	function filtragerencia(ger){									
		if (ger.length >0)
			table.ajax.url(ajaxfile + "?g="+ger).load();
		else	
			table.ajax.url(ajaxfile).load();
	}	
	
	
	$(document).ready(function() {		
		//define o menu ativo		
		$("#mnusuarios").addClass("active");
		
		//carrega DataTable com as opções que escolhi
		table = $('#TableDados').DataTable( {												
			dom: 'WBrtlip', 
			"ajax": ajaxfile + "?g=<?php echo $_SESSION['ID_GERENCIA'];?>",
			displayLength: 10,
			paginate: true,
			colReorder: false,
			processing:true,
			filter: true,
			"columnDefs": [ {"targets": 0,"orderable": false} ],
			"order":[[1, "desc"]],			
			columns: [
				{ "title":" ","data": "ID_USUARIO", "render": function ( data, type, row, meta ) { return '<a target="_blank" href="#" data-toggle="modal" data-target="#modalopcoes" onclick="linhaselecionada('+data+')" title="Ver opções do registro"><span class="glyphicon glyphicon-edit"/></a>';} },
				{ "title":"Código", "data": "ID_USUARIO"},
				{ "title":"Matrícula","data": "CD_MATRICULA" },
				{ "title":"Nome","data": "NM_USUARIO" },
				{ "title":"Gerência","data": "NM_GERENCIA" },
				{ "title":"Supervisão","data": "NM_SUPERVISAO" },
				{ "title":"Turma","data": "DS_TURMA" },
				{ "title":"E-mail","data": "DS_EMAIL" }										
			],
			buttons: [
				{extend:'copyHtml5', text:'<span class="glyphicon glyphicon-paste"/>', titleAttr:'Copiar registros para Clipboard'},
				//{extend: 'collection',text: '<span class="glyphicon glyphicon-download-alt"/>',buttons: [ 'csv', 'excel', 'pdf' ], titleAttr:'Exportar registros para arquivo'},						
				{extend:'excel', text:'<span class="glyphicon glyphicon-download-alt"/>', titleAttr:'Download dos registros em excel'},
				{extend:'print', text:'<span class="glyphicon glyphicon-print"/>', titleAttr:'Imprimir registros'},
				{extend:'colvis', text:'<span class="glyphicon glyphicon-list-alt"/>', titleAttr:'Escolher colunas a serem exibidas'}
			],			
			initComplete: function () {						
				var x = 0;
				this.api().columns().every( function () {
					var column = this;
					var select = $('<select class="form-control slfilter" id="slfilter'+x+'"><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex($(this).val());			 
							column.search( val ? '^'+val+'$' : '', true, false ).draw();
						} );
			 
					column.data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
					
					x++;
				} );
				document.getElementById('slfilter0').style.visibility = "hidden";
			},
			"language": {"processing": "<img src='/sgm/images/loader.gif'/ >" }
		});

		
		//evento onclick da table
		$('#TableDados tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
			//	$(this).removeClass('selected');
			}
			else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				linhaselecionada = table.row( this ).index();						
				status();
			}
		} );


		
		//assosia a barra de pesquisa com a minha personalizada
		oTable = $('#TableDados').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
		$('#pesquisar').keyup(function(){
			oTable.search($(this).val()).draw() ;
		})
			
	} );
	
	function editar(){								
		var codigo = table.cell(linhaselecionada, 1).data();
		window.open("/classes/usuarios/usuarios_editar.php?codedit=" +codigo, "_blank");		
	}
	
	function permissoes(){								
		var codigo = table.cell(linhaselecionada, 1).data();
		window.open("/classes/usuarios/usuarios_permissoes.php?codedit=" +codigo, "_blank");		
	}
		
	function limpafiltros(){			
		//limpa textos dos selects
		var sl = "";
		for (x=1; x< 27; x++){
			sl = "#slfilter" + x;
			$(sl).val("");	
		}		
		table.ajax.url("usuarios_ajax.php").load();	
		table.search('').columns('').search('').draw();
	}
	
	
	
	function linhaselecionada(codigo){		
		codigoselecionado = codigo;
	}	
	
	
	function excluir(){		
		var confirma ="";
		var codigo = table.cell(linhaselecionada, 1).data();
		
		//Confirma antes de chamar exclusao   		
		confirma = confirm("DESEJA REALMENTE EXCLUIR O REGISTRO "+ codigo+"?");
		if (confirma == true){							
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var str = this.response;
					
					if(str.indexOf('sucesso') > -1){
						limpafiltros();
						alert("Registro excluído com sucesso."); 					
						return true;
					}
					
					if (str.indexOf('erro') > -1){
						alert("Erro ao tentar excluir o registro. \nClique em ajuda no menu principal para mais informações.\n\n");
						return true;
					}
					
					if (str.indexOf('acesso') > -1){
						alert("Seu acesso não possui permissão para excluir registros.\nClique em ajuda no menu principal para mais informações.");
						return true;
					}
					
					alert(str);
				}
			}
			xmlhttp.open("GET","controles_ajax.php?acao=excluir&codigo="+codigo,true);
			xmlhttp.send();			
		}				
	}
	
	function desativar(){		
		var confirma ="";
		var codigo = table.cell(linhaselecionada, 1).data();
		
		//Confirma antes de chamar exclusao   		
		confirma = confirm("DESEJA REALMENTE DESATIVAR O REGISTRO "+ codigo+"?\n\nObservação:\nDesativar o usuário não o exclui mas impede que seja visualizado nas consultas.");
		if (confirma == true){							
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var str = this.response;
					
					if(str.indexOf('sucesso') > -1){
						limpafiltros();
						msgalert("Registro desativado com sucesso."); 					
						return true;
					}
					
					if (str.indexOf('erro') > -1){
						msgalert("Erro ao tentar desativar o registro. \nClique em ajuda no menu principal para mais informações.\n\n");
						return true;
					}
					
					if (str.indexOf('acesso') > -1){
						msgalert("Seu acesso não possui permissão para desativar registros.\nClique em ajuda no menu principal para mais informações.");
						return true;
					}
					
					alert(str);
				}
			}
			xmlhttp.open("GET","controles_ajax.php?acao=desativar&codigo="+codigo,true);
			xmlhttp.send();			
		}				
	}
	
	</script>
</head>
<body> 	
	
	<!--Modal OPÇÕES-->
	<div class="modal alert" id="modalopcoes" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="false" data-backdrop="false">
		<div class="modal-dialog" style="">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lineModalLabel">Opções</h5>
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>					
				</div>
				<div class="modal-body">
					<button class="btn btn-default" data-dismiss="modal" onclick="editar()">Editar</button>		
					<button class="btn btn-default" data-dismiss="modal" onclick="permissoes()">Permissões</button>
					<button class="btn btn-default" data-dismiss="modal" onclick="desativar()">Desativar</button>						
					<button class="btn btn-default" data-dismiss="modal" onclick="excluir()">Excluir</button>						
				</div>
			</div>
		</div>
	</div>
	
	
	
	
	<!-- CABEÇALHO -->	
	<div align="center" style="padding-left:6px; padding-right:6px">
		<div align="center" class="panel panel-default" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 10px 0 rgba(0, 0, 0, 0.15); margin-top:5px; text-align:center">
			
			<div align="center" class="panel-heading" style="text-align:center; background-color:#e6e6e6; height:50px" >
				<table border="0" class="" style=" background-color:#e6e6e6; padding:0px; margin:0px; color:Gray; padding:0px; margin:0px">
					<tr >	
						<td align="left" width="50">
							<button class="btn btn-default" style="margin-left:5px" onclick="limpafiltros()" title="Aplica/remove filtros" ><span class="glyphicon glyphicon-filter"></span></button>
						</td>
						<td align="center" >					
							<div align="left" style="padding-right:15px"><strong style="font-size:16px;">Gerencia<strong>	</div>
						</td>
						<td>
							<div align="center">		
								<select class="form-control" style="width:200px" name="gerencia" id="gerencia" onchange="filtragerencia(this.value)">													
								</select>
							</div>
						</td>
						<td align="left" >					
							<div class="form-group has-feedback" align="left" style="margin:0px; margin-left:10px; padding:0px;" >					
								<input type="text" id="pesquisar" name="pesquisar" class="form-control has-feedback" placeholder="Pesquisar texto" style="width:250px;"  >					
								<i style="color:gray" class="glyphicon text-default glyphicon-search form-control-feedback"></i>					
							</div>															
						</td>	
						<td align="center" >					
							<div align="left" style="padding-left:15px"><strong style="font-size:16px; font-weight:boldered;">Usuários cadastrados<strong>	</div>
						</td>
						<td>
							<div id="filtros">
							</div>
						</td>
					</tr>						
				</table>	
			</div>
			<div class="panel-body">	
				<!-- TABELA -->		
				<div class="panel-body text-center" style="margin:0px; padding:0px">		
					<div class="table-responsive" >						
						<form method="post" action="cons_kaizens.php" id="form_tab" name="form_tab">
							<table id="TableDados" name="TableDados" align="center" border="0" class="display cell-border order-column hover compact" >
								<thead>						  								
								</thead>
								<tbody>											
								</tbody>
								<tfoot>
									<th/>
									<th/>
									<th/>
									<th/>
									<th/>
									<th/>
									<th/>
									<th/>
								</tfoot>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>