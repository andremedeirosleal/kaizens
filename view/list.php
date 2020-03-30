<?php 
header('Content-Type:text/html;charset=utf-8'); 
include($_SERVER['DOCUMENT_ROOT']."/kaizens/connections/kaizens_prd.php");
include($_SERVER['DOCUMENT_ROOT']."/kaizens/classes/funcoes.php");
noerrors();
//checalogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>   
  	<!-- HEADERS COMUNS -->
    <?php include($_SERVER['DOCUMENT_ROOT']."/kaizens/view/global/headers-comuns.php");?>
    
	<!-- DATATABLES HEADERS -->
	<?php include($_SERVER['DOCUMENT_ROOT']."/kaizens/view/global/datatables-headers.php");?>

    <!-- FUNCOES JS COMUNS -->
    <script src="/kaizens/view/global/functions.js"></script>
	
</head>
<script>
    var table_dados;		
	var fileajax = '/kaizens/json/registers-json.php';	
	var temp_fileajax = fileajax;		
	var email_usuario = "";		
	var codigo_registro;
	var novo;					
	var linha;				

	$(document).ready(function() {							
		//calcula tamanho da table em relação ao height do screen 
		var screenh = screen.height * 40 / 100;			
		temp_fileajax = fileajax + "?o=7";				
		table_dados = $('#table_dados').DataTable({						
			dom: 'flBrtip',
			"ajax": temp_fileajax,
			displayLength: 100,
			"lengthMenu": [[ 100], [100]],	
			scrollY:screenh ,				
			scrollX:true,
			paginate: true,
			colReorder: true,
			retrieve: true,
			filter: true,				
			processing:true,
			//"order": [[ 1, "asc" ],[5, "asc"]],	//ordena por prioridade e data
			"columnDefs": [				
				{"width": "5px", "targets": [0,1,] },
				//{"className": "dt-center", "targets": "_all"},
				//{"className": "dt-left", "targets": [12,15]},
				//{"targets": [1,12,18,19,20,21,22],"visible": false},
			],											
			columns: [				
			/*0*/   { "title":"CÓDIGO","data": "id_register" },									
			/*0*/   { "title":"DATA","data": "dt_creation" },									
			/*1*/ 	{ "title":"USUÁRIO","data": "nm_user" },									
			/*2*/	{ "title":"TÍTULO","data": "ds_title" },									
			/*3*/	{ "title":"OBJETIVO","data": "ds_goal" },									
			/*4*/	{ "title":"GERÊNCIA","data": "ds_manager" },		
			/*5*/	{ "title":"SUPERVISÃO","data": "ds_supervision" },				
			],								
			buttons: [									
				{extend:'print', text:'<i class="fa fa-print "></i> Iprimir', titleAttr:'Imprimir registros'},
				{extend:'excel', text:'<i class="fa fa-download"></i> Excel',title: 'Registros', titleAttr:'Download dos registros em excel'},					
			],			
			"language": {"processing": "<img src='/kaizens/libs/images/gifs/spinner.gif'/ >" }			
		});		

		//evento on doubleclick da table
		$('#table_dados tbody').on( 'dblclick', 'tr', function () {
			table_dados.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			linha = table_dados.row( this ).index();
			show_dados();   			
		} );

		//evento on click da table
		$('#table_dados tbody').on( 'click', 'td', function () {
			table_dados.$('tr.selected').removeClass('selected');
			var row = table_dados.row( this ).node();		
			$(row).addClass( 'selected' );									
		});

		//TIMEOUT DE INATIVIDADE		
		var idleInterval = setInterval(timerIncrement, 10000); // 10 segundos		
		$(this).mousemove(function (e) { idleTime = 0; 	});
		$(this).keypress(function (e) { idleTime = 0; 	});
    });				


	function show_dados(){
        // codigo_registro =  table_dados.cell(linha, 0).data();		
        // document.getElementById("ID").value =  codigo_registro;
        // document.getElementById("VOLUME").value =  table_dados.cell(linha, 6).data().replace(" lts","");
        // document.getElementById("QUANTIDADE").value =  table_dados.cell(linha, 7).data();
        // document.getElementById("DS_COR").value =  table_dados.cell(linha, 10).data();
        // document.getElementById("CD_INTERNO").value =  table_dados.cell(linha, 11).data();
        // document.getElementById("TIPO").value =  table_dados.cell(linha, 12).data();
        // document.getElementById("CLIENTE").value =  table_dados.cell(linha, 14).data();
        // document.getElementById("PRIORIDADE").value =  table_dados.cell(linha, 1).data();
		// document.getElementById("MOTIVO_EXCLUSAO").value = "";
		// document.getElementById("MOTIVO_URGENCIA").value =  "";
		// document.getElementById("input_motivo").value =  table_dados.cell(linha, 19).data();

		// calc_total_producao();                
		// $("#modaldados").modal("show"); 
		// setTimeout(function(){ document.getElementById("VOLUME").focus(); }, 100);
    }
	
    function filtrar(datas){
		var opcao = document.getElementById("sl_opcoes").value;	
		var str = "";
		
		//OPÇÕES DE FILTRO						
		if (opcao == 6 ) {	//por datas
			if (strdatas.length==0){
				$("#modaldatas").modal("show");	
				return;
			}
		}else {
			str += "&o="+ opcao;			
			strdatas="";
		}
						
		str += strdatas;	
		alert(fileajax+"?"+str);	
		table_dados.clear().draw();		
		table_dados.ajax.url(fileajax+"?"+str).load();			
    }

	function envia_dados_form(){       
        $("div#divLoading").addClass('show'); 
		$.ajax({
            type: "POST",
            url: "/kaizens/models/kaizen_model.php",
            data : $("#form1").serialize(), 
            dataType: "json",
            success: function (data) {                                    
                var success = data['success'];                                             
                $("div#divLoading").removeClass('show');
                
				if(success == "erro"){  
                    msgalert("<h6>Erro ao salvar registro.</h6><br>Por favor aguarde enquanto trabalhamos nisso.");
                    return;
                }
                if(success == "salvo") {                        
                    alert("DADOS SALVOS COM SUCESSO!");
                    $("#modaldados").modal("hide");                    
                    table_dados.ajax.url(temp_fileajax).load();
					novo = false;
                    return;
                }
                if(success == "permissao") {                        
                    alert("ACESSO NEGADO. USUÁRIO SEM PERMISSÃO PARA ESSA OPERAÇÃO.");
                    $("#modaldados").modal("hide");
                    return;
                }
                if(success == "login") {                        
                    alert("POR FAVOR EFETUE LOGIN NOVAMENTE.");
                    $("#modaldados").modal("hide");
                    return;
                }     
				if(success == "excluido") {                        
                    alert("REGISTRO EXCLUÍDO COM SUCESSO.");
                    $("#modaldados").modal("hide");
					table_dados.ajax.url(temp_fileajax).load();
                    return;
                }  
				if(success == "cancelado") {                        
                    alert("SOLICITAÇÃO DE PRODUÇÃO CANCELADA COM SUCESSO.");
                    $("#modaldados").modal("hide");
					table_dados.ajax.url(temp_fileajax).load();
                    return;
                }  
				if(success == "concluido") {                        
                    alert("PRODUÇÃO CONCLUÍDA COM SUCESSO.");
                    $("#modaldados").modal("hide");
					table_dados.ajax.url(temp_fileajax).load();
                    return;
                } 
                msgalert("<B style='color:red'>ERRO INESPERADO.</b><br>"+success);                             
            }
        });//end ajax 
    }
	
	function excluir(){
		var confirma = confirm("Deseja realmente 'EXCLUIR' o registro?");
		if (!confirma) return;
		document.getElementById("FUNCAO").value = "excluir";
		//call_form_login();	//solicita login antes de enviar dados
		envia_dados_form(); 
	}
	
    window.onload=function(){
        var opcoes = '<label for="sl_opcoes" style="margin-left:30px; ">Filtros </label>';
		opcoes += '<select id="sl_opcoes" class="" style="width:100px; margin-left:3px;" onchange="filtrar(this.value)">';
		// opcoes += '<option value=1>Todos</option>';
		opcoes += '<option value=2>Hoje</option>';
		opcoes += '<option value=3>Ontem</option>';
		opcoes += '<option value=4>Mês</option>';
		opcoes += '<option value=5>Mês passado</option>';
		opcoes += '<option selected value=9>Todos do ano</option>';							
		opcoes += '<option value=6>Entre datas</option>';						
		opcoes += '</select>';
		
		setTimeout(function(){ 
			document.getElementById("table_dados_length").innerHTML += opcoes;        	
		}, 1000);	
	}
	

</script>
<style>
	.fa-edit{
		font-size:18px !important;
	}
	.color_red{background-color:red !important; color:white; font-weight: bold;}
	.color_orange{background-color:orange !important; color:white; font-weight: bold;}
	.color_yellow{background-color:yellow !important; font-weight: bold;}
	.color_green{background-color:rgba(0,255,0,1) !important; font-weight: bold;}

	/* td{cursor:pointer} */
	
	.flex-container label{
		margin-top:10px !important;        		
		margin-bottom:0px !important;        		
	}	
	.row{margin-left:0px;}
	.mr{
		margin-right:15px !important;
	}
	.modal-footer{border-top:0px; height:50px; line-height:50px}

	.btn_new{
		color:white!important;		
		background-color:#29549f !important;
		background-image: none !important;
		border: 1px solid #29549f !important;
		text-shadow: none !important;
	}
</style>
<body>
	<div id="divLoading"></div>

	<!--Modal DADOS-->	
	<div class="modal" tabindex="-1" role="dialog" id="modaldados" data-backdrop="static" data-keyboard="false">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title">REGISTROS</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <form id="form1" onsubmit="return false" autocomplete="off">
		  <div class="modal-body">            
            <div class="flex-container form-group form-control">
				<div class="row">
					<div>
						<label for="VOLUME">Volume (lts)</label>
						<input class="form-control   mr" style="width:90px" type="text" maxlength="6" name="VOLUME" id="VOLUME" onKeyPress="return isNumberKey2(event);" onchange="calc_total_producao()"/>			
					</div>
					<div>
						<label for="QUANTIDADE">Qtd</label>
						<input class="form-control   mr" style="width:70px"   type="text" maxlength="5" name="QUANTIDADE" id="QUANTIDADE" onKeyPress="return isNumberKey(event);" onchange="calc_total_producao()" />			
					</div>
					<div>
						<label for="TOTAL">TOTAL (lts)</label>
						<input class="form-control   mr" disabled style="width:100px"   type="text" id="TOTAL" />			
					</div>
					<div>
						<label for="AMOSTRA_COR">Amostra de cor?</label>
						<select class="form-control  "    type="text" name="AMOSTRA_COR" id="AMOSTRA_COR" >
							<option value="Não">Não</option>
							<option value="Sim">Sim</option>
						</select>		
					</div>
				</div>
                <div class="row">
					<div>
						<label for="DS_COR">Descrição da cor</label>
						<input class="form-control mr"   type="text" maxlength="50" name="DS_COR" id="DS_COR"  />			
					</div>
					<div style="margin-left:15px;">
						<label for="CD_INTERNO">Código interno</label>
						<input class="form-control" style="width:100px" type="text" maxlength="50" name="CD_INTERNO" id="CD_INTERNO"/>			
					</div>
                </div>  
                
				<div class="row">					
					<div>
						<label for="TIPO">Tipo</label>
						<select class="form-control mr"   type="text" name="TIPO" id="TIPO" ></select>		
					</div> 
					<div style="margin-left:15px;">
						<label for="PRIORIDADE">Prioridade</label>
						<select class="form-control"   type="text" name="PRIORIDADE" id="PRIORIDADE" ></select>		
					</div>
				</div>
				<div>
                    <label for="CLIENTE">Cliente</label>
                    <input class="form-control"   type="text" maxlength="50" name="CLIENTE" id="CLIENTE" />			
                </div>
				
            </div> 
            <input type="hidden" id="MOTIVO_EXCLUSAO" name="MOTIVO_EXCLUSAO" value=""/>
            <input type="hidden" id="MOTIVO_URGENCIA" name="MOTIVO_URGENCIA" value=""/>
            <input type="hidden" id="FUNCAO" name="FUNCAO" value=""/>
            <input type="hidden" id="ID" name="ID" value=""/>
		  </div>
		  <div class="modal-footer">		  
			<div align="center"><button type="button" align="left" id="btn_excluir" onclick="excluir()" class="btn btn-sm btn-danger" >Excluir</button></div>
			<div align="center"><button type="button" align="left" id="btn_cancelar" onclick="cancelar()" class="btn btn-sm btn-warning" >Cancelar</button></div>
			<div align="center"><button type="submit" align="middle" id="btn_salvar" onclick="salvar()" class="btn btn-sm btn-primary" >Salvar</button></div>
			<div align="center"><button align="middle" id="btn_fechar" class="btn btn-sm btn-outline-info" data-dismiss="modal">Fechar</button></div>		  	
		  </div>
		</form>
		</div>
	  </div>
	</div>

	<!-- MODAL DATAS -->
	<?php include($_SERVER['DOCUMENT_ROOT']."/kaizens/view/global/modal-dates.php");?>
	
	<!-- HEADER AND MENU -->
    <?php include($_SERVER['DOCUMENT_ROOT']."/kaizens/view/menu.php");?>
        
    <div class="container-fluid">
        <div class="card main-card" style="width: 18rem;">
            <div class="card-body">
				<h6 class="card-title"><i class="fa fa-area-chart"></i>LISTA DE REGISTROS</h6>
                <table align="center" width="100%" class="cell-border row-border hover compact nowrap" id="table_dados" cellspacing="0" >
                    <thead>                
                    </thead>
                    <tbody >					
                    </tbody>
                </table>
            </div>
        </div>
    </div>    

</body>
</html>