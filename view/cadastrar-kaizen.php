<?php 
session_start();
header('Content-Type:text/html;charset=utf-8'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- HEADERS COMUNS -->
    <?php include($_SERVER['DOCUMENT_ROOT']."/kaizens/view/global/headers_comuns.php");?>
<style>
	
</style>
	
<script language="javascript">
	function CaixaAlta(){
		var x = document.getElementById("nome").value;
		document.getElementById("nome").value = x.toUpperCase();
	}						

	function Xnome1(){		
		var x = document.getElementById("nome1").value; 
			
		if (x != 0)
			document.getElementById("foto1").src = "foto_user.php?codigo=".concat(document.getElementById("nome1").value) ;										
		else
			document.getElementById("foto1").src = "Kaizens/Blank.png";
		}

	function Xnome2(){		
		var x = document.getElementById("nome2").value 
		if (x != 0)
			document.getElementById("foto2").src = "foto_user.php?codigo=".concat(document.getElementById("nome2").value) ;										
		else
			document.getElementById("foto2").src = "Kaizens/Blank.png";
		}

	function Xnome3(){		
		var x = document.getElementById("nome3").value 
		if (x != 0)
			document.getElementById("foto3").src = "foto_user.php?codigo=".concat(document.getElementById("nome3").value) ;										
		else
			document.getElementById("foto3").src = "Kaizens/Blank.png";
		}

	function Xnome4(){		
		var x = document.getElementById("nome4").value 
		if (x != 0)
			document.getElementById("foto4").src = "foto_user.php?codigo=".concat(document.getElementById("nome4").value) ;										
		else
			document.getElementById("foto4").src = "Kaizens/Blank.png";
		}

	function Xnome5(){		
		var x = document.getElementById("nome5").value 
		if (x != 0)
			document.getElementById("foto5").src = "foto_user.php?codigo=".concat(document.getElementById("nome5").value) ;										
		else
			document.getElementById("foto5").src = "Kaizens/Blank.png";
		}

	function ResetVars(){
		var confirma = confirm("Deseja mesmo resetar o formulário?");
		if (confirma) window.location ="cadastro_kaizens.php";		
	}		
		
	
	function Fsubmit(foto){	
	
		if (foto == 'antes'){				
			document.getElementById("acao").value = "antes";		
		}
		
		if (foto == 'apos'){
			document.getElementById("acao").value ="apos";
		}		
		
		document.forms["form1"].submit();	
	}
	
	function ValidaForm(){
		var prossegue = 1;
		var contachecks = 0;
		
		var titulo = document.getElementById("titulo").value;
		var gerencia = document.getElementById("gerencia").value;
		var supervisao = document.getElementById("supervisao").value;
		var objetivo = document.getElementById("objetivo").value;
		var data = document.getElementById("data").value ;
		
		var saude = document.getElementById("saude").checked ;
		var seg = document.getElementById("seg").checked ;
		var pessoas = document.getElementById("pessoas").checked ;
		var quali = document.getElementById("quali").checked ;
		var prod = document.getElementById("prod").checked ;		
		var custos = document.getElementById("custos").checked ;
		var nd = document.getElementById("nd").checked ;
		
		var espera = document.getElementById("espera").checked ;
		var superprod = document.getElementById("superprod").checked ;
		var transp = document.getElementById("transp").checked ;
		var invent = document.getElementById("invent").checked ;
		var movi = document.getElementById("movi").checked ;
		var process = document.getElementById("process").checked ;
		var defeito = document.getElementById("defeito").checked ;
		var meio_ambiente = document.getElementById("meio_ambiente").checked ;
		
		//var valor = document.getElementById("valor").value;
		var objetivo = document.getElementById("objetivo").value ;
		var sit_antes = document.getElementById("sit_antes").value ;
		var sit_apos = document.getElementById("sit_apos").value ;		
		//var resultado = document.getElementById("resultado").value ;
				
		var fotoapos = "<?php if (isset($_REQUEST['FotoApos'])) echo ("temfoto"); else echo(""); ?>";
		
		var nome1 = document.getElementById("nome1").value ;
		var nome2 = document.getElementById("nome2").value ;
		var nome3 = document.getElementById("nome3").value ;
		var nome4 = document.getElementById("nome4").value ;
		var nome5 = document.getElementById("nome5").value ;
		
		var riscseg_antes = document.getElementById("riscseg_antes").value ;
		var riscseg_apos = document.getElementById("riscseg_apos").value ;
		var riscseg_ganho = document.getElementById("riscseg_ganho").value ;
		
		var qtdstq_antes = document.getElementById("qtdstq_antes").value ;
		var qtdstq_apos = document.getElementById("qtdstq_apos").value ;
		var qtdstq_ganho = document.getElementById("qtdstq_ganho").value ;
		
		var dist_antes = document.getElementById("dist_antes").value ;
		var dist_apos = document.getElementById("dist_apos").value ;
		var dist_ganho = document.getElementById("dist_ganho").value ;
		
		var esp_antes = document.getElementById("esp_antes").value ;
		var esp_apos = document.getElementById("esp_apos").value ;
		var esp_ganho = document.getElementById("esp_ganho").value ;
		
		var finan_antes = document.getElementById("finan_antes").value ;
		var finan_apos = document.getElementById("finan_apos").value ;
		var finan_ganho = document.getElementById("finan_ganho").value ;
		
		var tempo_antes = document.getElementById("tempo_antes").value ;
		var tempo_apos = document.getElementById("tempo_apos").value ;
		var tempo_ganho = document.getElementById("tempo_ganho").value ;
		
		var outro_antes = document.getElementById("outro_antes").value ;
		var outro_apos = document.getElementById("outro_apos").value ;
		var outro_ganho = document.getElementById("outro_ganho").value ;
		var outro_desc = document.getElementById("outro_desc").value ;
		
		
		if (titulo.length < 2){
			msgalert("Preencha o campo TÍTULO corretamente.");
			document.getElementById("titulo").focus();
			prossegue = 0;	
			return false;}
			

		if (prossegue == 1){
			if (objetivo.length < 1){
				msgalert("Preencha o campo OBJETIVO corretamente.");
				document.getElementById("objetivo").focus();
				prossegue = 0;	
				return false;
				}	
			}
		
		if (prossegue == 1){
			if (gerencia.length < 1){
				msgalert("Preencha o campo GERÊNCIA corretamente.");
				document.getElementById("gerencia").focus();
				prossegue = 0;	
				return false;
				}	
			}
		
		if (prossegue == 1){
			if (supervisao.length < 1){
				msgalert("Preencha o campo ÁREA APLICADA corretamente.");
				document.getElementById("supervisao").focus();
				prossegue = 0;	
				return false;
				}	
			}
			
		
		if (prossegue == 1){
			if (data.length < 1){
				msgalert("Preencha o campo DATA corretamente.");
				document.getElementById("data").focus();
				prossegue = 0;
				return false;	
				}	
			}
		
		
		//checa se nenhum check box esta marcado
		if (prossegue == 1){
			if (saude == false && seg == false && pessoas == false &&  quali == false){
				if (prod == false && nd == false && custos == false){
					msgalert("Marque pelo menos uma das opções de FMDS.");
					document.getElementById("saude").focus();
					prossegue = 0;	
					return false;
					}	
				}
			}

		if (prossegue == 1){
			if (espera == false && superprod == false && transp == false &&  invent == false){
				if (movi == false && process == false && defeito == false && meio_ambiente == false){
					msgalert("Marque pelo menos uma das opções de DESPERDÍCIO.");
					document.getElementById("saude").focus();
					prossegue = 0;	
					return false;
					}	
				}
			}
				
		if (prossegue == 1){
			if (objetivo.length < 5){
				msgalert("Preencha corretamente o campo OBJETIVO.");
				document.getElementById("objetivo").focus();
				prossegue = 0;	
				return false;
				}	
			}
		
		
		if (prossegue == 1){
			if (sit_antes.length <5){
				msgalert("Preencha corretamente o campo SITUAÇÃO DE ANTES.");
				document.getElementById("sit_antes").focus();
				prossegue = 0;	
				return false;
				}	
			}
		
		if (prossegue == 1){
			if (sit_apos.length < 5){
				msgalert("Preencha corretamente o campo AÇÃO REALIZADA.");
				document.getElementById("sit_apos").focus();
				prossegue = 0;	
				return false;
				}	
			}
			
		
			
		if (prossegue == 1){
			if (nome1 == 0 && nome2  == 0 && nome3  == 0 && nome4  == 0 && nome5  == 0){
				msgalert("Preencha pelo menos um COLABORADOR.");
				document.getElementById("nome1").focus();
				prossegue = 0;	
				return false;
				}	
			}

		if (prossegue == 1){
			if (titulo.indexOf("'") != -1 || titulo.indexOf("`") != -1 || titulo.indexOf('"') != -1){
				msgalert("Caracteres não permitidos no campo TÍTULO:   '   ou   `   ou   " + '"');
				document.getElementById("titulo").focus();
				prossegue = 0;	
				return false;
				}	
			}		

		if (prossegue == 1){
			if (objetivo.indexOf("'") != -1 || objetivo.indexOf("`") != -1 || objetivo.indexOf('"') != -1){
				msgalert("Caracteres não permitidos no campo OBJETIVO:   '   ou   `   ou   " + '"');
				document.getElementById("objetivo").focus();
				prossegue = 0;	
				return false;
				}	
			}		
		if (prossegue == 1){
			if (sit_antes.indexOf("'") != -1 || sit_antes.indexOf("`") != -1 || sit_antes.indexOf('"') != -1){
				msgalert("Caracteres não permitidos no campo SITUAÇÃO ANTES:   '   ou   `   ou   " + '"');
				document.getElementById("sit_antes").focus();
				prossegue = 0;	
				return false;
				}	
			}			
			
		if (prossegue == 1){
			if (sit_apos.indexOf("'") != -1 || sit_apos.indexOf("`") != -1 || sit_apos.indexOf('"') != -1){
				msgalert("Caracteres não permitidos no campo AÇÃO REALIZADA:   '   ou   `   ou   " + '"');
				document.getElementById("sit_apos").focus();
				prossegue = 0;	
				return false;
				}	
			}		
			
				
		
		if (prossegue == 1){
			if (riscseg_antes.length > 0 || riscseg_apos.length > 0 ){
				if (riscseg_antes.length < 1 || riscseg_apos.length < 1)
					{
					msgalert("É preciso preencher o 'ANTES' e 'APÓS' do campo 'RISCO DE SEGURANÇA'.");
					document.getElementById("riscseg_antes").focus();
					prossegue = 0;	
					return false;
					}
				}
			}
		
		if (prossegue == 1){
			if (qtdstq_antes.length > 0 || qtdstq_apos.length > 0 || qtdstq_ganho.length > 0){
				if (qtdstq_antes.length < 1 || qtdstq_apos.length < 1 || qtdstq_ganho.length < 1)
					{
					msgalert("É preciso preencher os três campos de 'QUANTIDADE ESTOQUE'.");
					document.getElementById("qtdstq_antes").focus();
					prossegue = 0;	
					return false;
					}
				}
			}
		
		if (prossegue == 1){
			if (dist_antes.length > 0 || dist_apos.length > 0 || dist_ganho.length > 0){
				if (dist_antes.length < 1 || dist_apos.length < 1 || dist_ganho.length < 1)
					{
					msgalert("É preciso preencher os três campos de 'DISTÂNCIA'.");
					document.getElementById("dist_antes").focus();
					prossegue = 0;	
					return false;
					}
				}
			}
		
		if (prossegue == 1){
			if (esp_antes.length > 0 || esp_apos.length > 0 || esp_ganho.length > 0){
				if (esp_antes.length < 1 || esp_apos.length < 1 || esp_ganho.length < 1)
					{
					msgalert("É preciso preencher os três campos de 'ESPAÇO'.");
					document.getElementById("esp_antes").focus();
					prossegue = 0;	
					return false;
					}
				}
			}

		if (prossegue == 1){
			if (finan_antes.length > 0 || finan_apos.length > 0 || finan_ganho.length > 0){
				if (finan_antes.length < 1 || finan_apos.length < 1 || finan_ganho.length < 1)
					{
					msgalert("É preciso preencher os três campos de 'FINANCEIRO'.");
					document.getElementById("finan_antes").focus();
					prossegue = 0;	
					return false;
					}
				}
			}
		
		if (prossegue == 1){
			if (tempo_antes.length > 0 || tempo_apos.length > 0 || tempo_ganho.length > 0){
				if (tempo_antes.length < 1 || tempo_apos.length < 1 || tempo_ganho.length < 1)
					{
					msgalert("É preciso preencher os três campos de 'TEMPO'.");
					document.getElementById("tempo_antes").focus();
					prossegue = 0;	
					return false;
					}
				}
			}
		
		if (prossegue == 1){
			if (outro_antes.length > 0 || outro_apos.length > 0 || outro_ganho.length > 0 || outro_desc.length > 0){
				if (outro_antes.length < 1 || outro_apos.length < 1 || outro_ganho.length < 1 || outro_desc.length < 1)
					{
					msgalert("É preciso preencher os quatro campos de 'OUTRO'.");
					document.getElementById("outro_desc").focus();
					prossegue = 0;	
					return false;
					}
				}
			}
			
		if (prossegue == 1){
			if (riscseg_antes.length <1 && qtdstq_antes.length<1 && dist_antes.length<1 && finan_antes.length<1 && outro_antes.length<1){
				msgalert("Preencha pelo menos um tipo de ganho.");
				document.getElementById("riscseg_antes").focus();
				prossegue = 0;	
				return false;
			}				
		}	
		
		if (prossegue == 1){			
			if (finan_antes.length >0){									 
				finan_antes = finan_antes.replace(",",".");
				document.getElementById("finan_antes").value = finan_antes;					
				}	
			}
		
		if (prossegue == 1){			
			if (finan_apos.length > 0){									 
				finan_apos = finan_apos.replace(",",".");
				document.getElementById("finan_apos").value = finan_apos;					
				}	
			}		
		
		if (prossegue == 1){			
			if (finan_ganho.length > 0){									 
				finan_ganho = finan_ganho.replace(",",".");
				document.getElementById("finan_ganho").value = finan_ganho;					
				}	
			}	

			if (prossegue == 1){			
				if (tempo_antes.length >0){									 
					tempo_antes = tempo_antes.replace(",",".");
					document.getElementById("tempo_antes").value = tempo_antes;					
				}else{
					tempo_antes = 0;
					document.getElementById("tempo_antes").value = tempo_antes;
				}
			}
		
			if (prossegue == 1){			
				if (tempo_apos.length > 0){									 
					tempo_apos = tempo_apos.replace(",",".");
					document.getElementById("tempo_apos").value = tempo_apos;					
				}else{
					tempo_apos = 0;
					document.getElementById("tempo_apos").value = tempo_apos;					
				}
			}		
		
			if (prossegue == 1){			
				if (tempo_ganho.length > 0){									 
					tempo_ganho = tempo_ganho.replace(",",".");
					document.getElementById("tempo_ganho").value = tempo_ganho;					
				}else{
					tempo_ganho = 0;
					document.getElementById("tempo_ganho").value = tempo_ganho;					
				}	
			}

				
		//Se passou por todos os critérios então Post
		if (prossegue == 1){			
			document.getElementById("acao").value = "salvar"}			
	}
	
	

	function isNumberKey(evt){
    	var charCode = (evt.which) ? evt.which : event.keyCode	    
		
		//44 = ','   
		if (charCode == 44){ 
			return true;}
		else{
			if (charCode > 31 && (charCode < 48 || charCode > 57))
	        	return false;
			}		
	    return true;
	}
	
	function isNumberKey2(evt){
    	var charCode = (evt.which) ? evt.which : event.keyCode	    
		
		//NÃO PERMITE CARACTERES DE PONTO OU VIRGULA
		//44 = ',' 
		//46 = '.'
		if (charCode == 44 || charCode == 46){ 
			return false;}
		else{
			if (charCode > 31 && (charCode < 48 || charCode > 57))
	        	return false;
			}		
	    return true;
	}
	
	function DataBarras(id, evt){		
		var x = document.getElementById(id).value;		
		var charCode = (evt.which) ? evt.which : event.keyCode	   		
		
		//Só aceita se for número, senão descarta
		if (charCode > 31 && (charCode < 48 || charCode > 57))
	        return false;		
		else{
			//Acrescenta barras
			if (x.length == 2 || x.length == 5){
				document.getElementById(id).value = x.concat("/");}
			return true;
			}			
				
		}
		
	//função que captura e escreve no select usuarios o usuario escolhido no pesquisar
	function Ver(linha){
		var x = linha.parentNode.parentNode.parentNode.cells;				
		document.getElementById(caller).value = x[0].id;			
		
		if (caller == "nome1") Xnome1();
		if (caller == "nome2") Xnome2();
		if (caller == "nome3") Xnome3();
		if (caller == "nome4") Xnome4();
		if (caller == "nome5") Xnome5();
	}

	function RemoverColaborador(nome, foto){
		if (caller == "nome1"){		
		document.getElementById("foto1").src = "Kaizens/Blank.png";
		$('#nome1').html('');		
		}if (caller == "nome2"){
		document.getElementById("foto2").src = "Kaizens/Blank.png";
		$('#nome2').html('');
		}if (caller == "nome3"){
		document.getElementById("foto3").src = "Kaizens/Blank.png";
		$('#nome3').html('');
		}if (caller == "nome4"){
		document.getElementById("foto4").src = "Kaizens/Blank.png";
		$('#nome4').html('');
		}if (caller == "nome5"){
		document.getElementById("foto5").src = "Kaizens/Blank.png";
		$('#nome5').html('');
		}
	}
		
		
	function CalcGanho(campo){
		var x ;
		var y ;	
					
		if (campo == "qtdstq_ganho"){
			x = document.getElementById("qtdstq_antes").value;
			y = document.getElementById("qtdstq_apos").value;
			if(x.length >0 && y.length>0){
				document.getElementById(campo).value = Math.abs(y - x);
			}
		}
		
		if (campo == "dist_ganho"){
			x = document.getElementById("dist_antes").value;
			y = document.getElementById("dist_apos").value;
			if(x.length >0 && y.length>0){
				document.getElementById(campo).value = Math.abs(y - x);
			}
		}
		
		if (campo == "esp_ganho"){
			x = document.getElementById("esp_antes").value;
			y = document.getElementById("esp_apos").value;
			if(x.length >0 && y.length>0){
				document.getElementById(campo).value = Math.abs(y - x);
			}
		}
		
		if (campo == "finan_ganho"){
			x = document.getElementById("finan_antes").value;
			y = document.getElementById("finan_apos").value;
			if(x.length >0 && y.length>0){
				document.getElementById(campo).value = Math.abs(y - x) + ",00";
				
			}
		}
		
		if (campo == "tempo_ganho"){
			x = document.getElementById("tempo_antes").value;
			y = document.getElementById("tempo_apos").value;
			if(x.length >0 && y.length>0){
				document.getElementById(campo).value = Math.abs(y - x);				
			}
		}
		
	}
	
	function LoadSupervisao(sel){
		var nomesupervisao = sel.options[sel.selectedIndex].text;
		document.getElementById("nomesupervisao").value = nomesupervisao;
	}
	
	//caminho para ajax de usuarios
	var file_usuarios = '/kaizens/ajax/usuarios_ajax.php';
	
	//função que exibe o datepicker no input dataprev
	$(document).ready(function () {
	    //configura datepicker
        /*$('#data').datepicker({
			format: "dd/mm/yyyy",
			language: "pt-BR",
			startDate: 'd',
			endDate: 'd',
			todayHighlight: true
        });	
		$('#data').datepicker().on('changeDate', function (ev) {
			$('.datepicker').hide();
		});*/
		
		//carrega usuarios com parâmetro inicial de só com usuarios da gereencia do usuario logado
		table_usuarios = $('#table_usuarios').DataTable( {			
			"ajax": file_usuarios + "?g=0",
			dom: 'rtlip',
			paginate: true,
			filter: true,	
			colReorder: true,			
			columns: [				
				{ "title":"Código","data": "ID_USUARIO" },
				{ "title":"Matrícula","data": "CD_MATRICULA" },
				{ "title":"Nome","data": "NM_USUARIO" },				
				{ "title":"Gerência","data": "NM_GERENCIA" },	
				{ "title":"Supervisão","data": "NM_SUPERVISAO" }	
			]
		});
		
		//evento onclick tabela usuarios
		$('#table_usuarios tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				//	$(this).removeClass('selected');
				}
			else {
				table_usuarios.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var linha = table_usuarios.row( this ).index();								
				var codigo = table_usuarios.cell(linha, 0).data();
				var nome = table_usuarios.cell(linha, 2).data();
				
				//adiciona codigo e nome ao select de nome
				$('#' + caller).append($('<option>').text(nome).attr('value', codigo));
				document.getElementById(caller).value = codigo;
								
				//verifica quem chamou a pesquisa.				
				if (caller == "nome1") Xnome1();
				if (caller == "nome2") Xnome2();
				if (caller == "nome3") Xnome3();
				if (caller == "nome4") Xnome4();
				if (caller == "nome5") Xnome5();				
				
				$("#modalpesquisar").modal("hide");				
			}
		} );

		//busca de usuarios
		$('#busca_usuarios').keyup(function(){
			table_usuarios.search($(this).val()).draw() ;
		})

	
	});

	function exibe_gerencias(codigo){
		table_usuarios.ajax.url(file_usuarios + "?g=" + codigo).load();		
	}
	
	//Função responsável por pesquisar palavra na table e mostrar
	function myFunction() {
	  var input, filter, table, tr, td, i;
	  var nadaencontrado = false;
	  input = document.getElementById("pesquisar");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("TableUsers");
	  
	  tr = table.getElementsByTagName("tr");
	  
	  for (i = 0; i < tr.length; i++) {
		nadaencontrado = false;
	    td = tr[i].getElementsByTagName("td")[0];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        nadaencontrado = true;
	      } else {
	        tr[i].style.display = "none";
			
	      }
	    } 
		
		if (nadaencontrado == false){
			td = tr[i].getElementsByTagName("td")[1];
			if (td) {
			  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				nadaencontrado = true;
			  } else {
				tr[i].style.display = "none";
				
			  }
			}
		}
		
		if (nadaencontrado == false){
			td = tr[i].getElementsByTagName("td")[2];
			if (td) {
			  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				nadaencontrado = true;
			  } else {
				tr[i].style.display = "none";
				
			  }
			}
		}
		 
		if (nadaencontrado == false){
			td = tr[i].getElementsByTagName("td")[3];
			if (td) {
			  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				nadaencontrado = true;
			  } else {
				tr[i].style.display = "none";
				
			  }
			}
		}
		
		
		if (nadaencontrado == true)
			tr[i].style.display = "";

		
	  }
	}
	</script>
</head>
<body>
<!--DIV QUE EXIBE GIF DE LOADING-->
<div class="loader"></div>

<!--Modal PIRÂMIDE DE SEGURANÇA -->	
<div class="modal alert" id="modalseg" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">	
	<div class="modal-dialog" style="width:480px">	
		<div class="modal-content">	
			<div class="modal-header">
				<h5 class="modal-title" id="lineModalLabel">Pirâmide de segurança</h5>	
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>	
				
			</div>	
			<div class="modal-body">	
				<img src="/kaizens/images/piramide_seg.png" width="400px" height="277px"/>							
			</div>	
		</div>	
	</div>	
</div>	


<!--Modal AREAS APLICAVEIS -->	
<div class="modal fade alert" id="modaldatas" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">	
	<div class="modal-dialog modal-lg">	
		<div class="modal-content">	
			<div class="modal-header">
				<h5 class="modal-title" id="lineModalLabel">Pesquisa por datas</h5>	
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>	
				
			</div>	
			<div class="modal-body">	
				<form id="formdatas" name="formdatas" method="post" action="index.php">	
					<div class="form-group">	
						<label for="exampleInputEmail1">Data Início</label>	
						<input type="text" class="form-control" maxlength="10" name="Xdataini" id="Xdataini" placeholder="__/__/____" style="text-transform:uppercase" autofocus onKeyPress="return DataBarras('Xdataini', event)" onChange="FormataData('Xdataini')">	
					</div>	
				  	
					<div class="form-group">	
						<label for="datafim">Data Fim   </label>						
						<input type="text" class="form-control" maxlength="10" name="Xdatafim" id="Xdatafim" placeholder="__/__/____" style="text-transform:uppercase" autofocus onKeyPress="return DataBarras('Xdatafim', event)" onChange="FormataData('Xdatafim')">	
					</div>		   					
					<div id="msgdatas" align="center" Style="color:red;font-size:12px; visibility:hidden; font-weight:bold">Campo 'DATA INÍCIO' não pode ficar em branco.</div>	
					<hr>	
					<button type="button" style="width:150px" title="Filtrar pelas datas selecionadas" class="btn btn-success dropdown-toggle center-block" onclick="return ValidaDatas()">Filtrar</button>							
				</form>								
			</div>	
		</div>	
	</div>	
</div>	




<!--Modal USUARIOS-->
<div class="modal fade alert"  id="modalpesquisar" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" Style="width:1000px">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="lineModalLabel">Pesquisa por usuário</h5>	
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>	
				
			</div>
			<div class="modal-body">				
				<div class="form-group" align="center">												
					<div align="center" style="color:gray; font-weight: bold;" ><a href="#" onClick="RemoverColaborador(caller)" title="Remover Colaborador" data-dismiss="modal"><img src="images/Delete.png" width="20px" height="20px">Remover Colaborador</a>  </div></td>										
					<select placeholder="Selecione Gerência" onchange="exibe_gerencias(this.value)" class="form-control" id="usuarios_gerencia" name="usuarios_gerencia" style="width:200px;" >																					
					</select>
					
					<input type="text" class="form-control" Style="width:461px" id="busca_usuarios" placeholder="Digite o nome que deseja pesquisar"  autofocus >
				</div>			
				
				<table width="950px" class="order-column hover compact nowrap" id="table_usuarios">
					<thead>
					</thead>
					<tbody>
					</tbody>						
				</table>
			</div>
		</div>
	</div>
</div>
 
<form name="form1" action="cadastro_kaizens.php" method="post" enctype="multipart/form-data">
	<div align="center">
		<div align="center" class="panel panel-default" >
				<div class="panel-body">
		
				<table class="tabelaSize" >
					<tr>
						<td class="logos">
							<img  src="../IMAGES/logo_vale.gif">
						</td>
						<td>
							<div align="center">
								<input type="text" name="titulo" class="form-control" placeholder="Digite o título" maxlength="250" style="width:700px; text-align:center; font-weight:bold" id="titulo" value="<?php echo $titulo; ?>" >
							</div>
						</td>
						<td class="logos">
							<img src="<?php echo $img_titulo;?>">
						</td>
					</tr>
				</table>
								
				<table class="tabelaSize">
					<tr>
						<td>
							<div align="left"><strong>Objetivo: </strong>
								<input type="text" class="form-control" name="objetivo" maxlength="250" id="objetivo" value="<?php echo ($objetivo); ?>">
							</div>
						</td>
						<td>
							<div align="left"><strong>Data:</strong>
								<input type="text" maxlength="10" disabled class="form-control" name="data" id="data" value="<?php echo ($data); ?>" onKeyPress="return DataBarras('data', event)" onChange="FormataData()">
							</div>
						</td>
					</tr>

					<tr>
						<td>
							<div>
								<strong> Gerência:</strong>   							
								<select name="gerencia" class="form-control" id="gerencia" onchange="setID_SUPERVISAO(this.value)">            														
								</select>								
							</div>
						</td>
						<td>
							<div >
								<strong>Área aplicada: </strong>									  
								<select name="supervisao" class="form-control" id="supervisao" onchange="LoadSupervisao(this)">								
								</select>							  
							</div>
						</td>
					</tr>
				</table>
				
				
				<table class="tabelaSize">
					<tr>
						<td>
							<tr>
								<td><strong> FMDS:</strong></td>
								<td>Sa&uacute;de 		<img id="img_saude" src="<?php echo ($img_saude); ?>" 		onClick="Check_Saude()"></td>
								<td>Seguran&ccedil;a 	<img id="img_seg" src="<?php echo ($img_seg); ?>" 			onClick="Check_Seg()"></td>
								<td>Pessoas 			<img id="img_pessoas" src="<?php echo ($img_pessoas); ?>" 	onClick="Check_Pessoas()"></td>
								<td>Qualidade 			<img id="img_quali" src="<?php echo ($img_quali); ?>" 		onClick="Check_Quali()"></td>
								<td>Produtividade 		<img id="img_prod" src="<?php echo ($img_prod); ?>" 		onClick="Check_Prod()"></td>
								<td>Custos 				<img id="img_custos" src="<?php echo ($img_custos); ?>" 	onClick="Check_Custos()"></td>
								<td>Meio ambiente			<img id="img_meio_ambiente" src="<?php echo ($img_meio_ambiente); ?>" 		onClick="Check_meio_ambiente()"></td>
								<td>N/D 				<img id="img_nd" src="<?php echo ($img_nd); ?>" 			onClick="Check_Nd()"></td>
							</tr>
						</td>
					</tr>
				</table>
				
				<hr class="meuhr">
				<table class="tabelaSize">
					<tr>
						<td>
							<tr>
								<td><strong> Desperdício: </strong></td>
								<td>Espera 							<img id="img_espera" src="<?php echo ($img_espera); ?>" 					onClick="Check_Espera()"></td>
								<td>Sup. Produ&ccedil;&atilde;o  	<img id="img_superprod" src="<?php echo ($img_superprod); ?>" 				onClick="Check_Superprod()"></td>
								<td>Transporte 						<img id="img_transp" src="<?php echo ($img_transp); ?>" 					onClick="Check_Transp()"></td>
								<td>Invent&aacute;rio 				<img id="img_invent" src="<?php echo ($img_invent); ?>" 					onClick="Check_Invent()"></td>
								<td>Movimento 						<img id="img_movi" src="<?php echo ($img_movi); ?>" 						onClick="Check_Movi()"></td>
								<td>Proces. excessivo 				<img id="img_process" src="<?php echo ($img_process); ?>" 					onClick="Check_Process()"></td>
								<td>Defeito 						<img id="img_defeito" src="<?php echo ($img_defeito); ?>" 					onClick="Check_Defeito()"></td>								
							</tr>
						</td>
					</tr>
				</table>

		      	<table class="tabelaSize">
			        <tr>
			          <td class="tabelaMetade">
							<label class="custom-file-input1" for="imagemAntes"></label>
			                <input name="imagemAntes" accept="image/*" id="imagemAntes" type="file"/>
			          </td>
			          <td class="tabelaMetade">
			                <label class="custom-file-input2" for="imagemApos"></label>
			                <input name="imagemApos" accept="image/*" id="imagemApos" type="file"/>
			          </td>
			        </tr>
			        <tr >
			          <td class="tabelaMetade"  height="250">
						<?php
							if ($imageAntes == "" ){
							  	echo("<div id='imageAntes'><img src='Kaizens/nao_havia.png'></div>");
							}else{ 
							  	echo("<div id='imageAntes'></div> ");
							}
						 ?>			                
			          </td>
			          <td class="tabelaMetade" height="250">
			                <div id="imageApos" style="border: 1px solid #A5A5A9; height:250px; cursor:default "></div>  
			          </td>
			        </tr>
		      	</table>
					
				<table class="tabelaSize" style="margin-top:10px">
					<tr>
						<td class="tabelaMetade">
							<div align="left">
								<strong>Situação Antes:</strong>					  
								<textarea name="sit_antes" rows="4" class="form-control" id="sit_antes" maxlength="500"><?php echo ($sit_antes); ?></textarea>
							</div>
						</td>
						<td class="tabelaMetade">
							<div align="left">
								<strong>Ação Realizada:</strong>
								<textarea name="sit_apos" rows="4" class="form-control" id="sit_apos" maxlength="500"><?php echo ($sit_apos); ?></textarea>
							</div>
						</td>
					</tr>
				</table>

				<table width="100%" class="tabelaSize">
					<tr>
						<td width="50%" align="center" valign="top">
							<div align="left">
								<strong>Colaboradores:</strong>
							</div>
							<table width="100%" height="106" border="0" cellspacing="0">
								<tr>
									<td width="" height="">
										<font>
											<select name="nome1"  id="nome1" onclick="Caller('nome1')" data-toggle="modal"  data-target="#modalpesquisar">
												
											
											</select>
										</font>
									</td>
								
									<td width="">
										<font>
											<select name="nome2" id="nome2" onclick="Caller('nome2')" data-toggle="modal"  data-target="#modalpesquisar">
												
												
											</select>
										</font>
									</td>
									<td width="">
										<font>
											<select name="nome3" id="nome3" onclick="Caller('nome3')" data-toggle="modal"  data-target="#modalpesquisar">
												
												
											</select>
										</font>
									</td>
									<td width="">
										<font>
											<select name="nome4" id="nome4" onclick="Caller('nome4')" data-toggle="modal"  data-target="#modalpesquisar" >
																								
																					
											</select>
										</font>
									</td>
									<td width="">
										<font>
											<select name="nome5" id="nome5" onclick="Caller('nome5')" data-toggle="modal"  data-target="#modalpesquisar">
												
											
											</select>
										</font>
									</td>
								</tr>
								<tr>
									<td><div align="center"><img id="foto1" name="foto1" src="Kaizens/Blank.png"/></div></td>
									<td><div align="center"><img id="foto2" name="foto2" src="Kaizens/Blank.png"/></div></td>
									<td><div align="center"><img id="foto3" name="foto3" src="Kaizens/Blank.png"/></div></td>
									<td><div align="center"><img id="foto4" name="foto4" src="Kaizens/Blank.png"/></div></td>
									<td><div align="center"><img id="foto5" name="foto5" src="Kaizens/Blank.png"/></div></td>
								</tr>
							</table>
						</td>
						<td width="50%" align="center" valign="top">
							<div align="left">								
								<table width="100%" class="tabelaMenor" align>
									<tr>
										<td> <strong>Resultado Alcançado</strong> 				
										</td>
										
										<td> <strong>Antes</strong>
										</td>
										
										<td> <strong>Depois</strong>
										</td>
										
										<td> <strong>Ganho</strong>
										</td>				
									</tr>
								
									<tr>
										<td>Segurança Pessoal
										</td>
										
										<td >
											<div align="center">
												<select  name="riscseg_antes" id="riscseg_antes" onchange="$('#modalseg').modal('show')">
													<option value=""></option>
													<option value="Muito alto">Muito alto</option>
													<option value="Alto">Alto</option>
													<option value="Médio">Médio</option>
													<option value="Baixo">Baixo</option>
													<option value="Eliminado">Eliminado</option>
													<?php echo "<option selected value=" .$riscseg_antes. ">" .$riscseg_antes.  "</option>"; ?>							
												</select>
											</div>
										</td>
										
										<td>
											<div align="center">
												<select name="riscseg_apos" id="riscseg_apos">
													<option value=""></option>
													<option value="Muito alto">Muito alto</option>
													<option value="Alto">Alto</option>
													<option value="Médio">Médio</option>
													<option value="Baixo">Baixo</option>
													<option value="Eliminado">Eliminado</option>
													<?php echo "<option selected value=" .$riscseg_apos. ">" .$riscseg_apos.  "</option>"; ?>							
												</select>
											</div>
										
										</td>
										
										<td>
											<div align="center">
												<input type="text" readonly name="riscseg_ganho" id="riscseg_ganho" style="width:0px; heigth:4px; text-align:center;border:none">											
											</div>
										</td>				
									</tr>
									
									<tr>
										<td>Quantidade Estoque
										</td>
										
										<td><div align="center"><input onchange="CalcGanho('qtdstq_ganho')" type="text" name="qtdstq_antes" id="qtdstq_antes" maxlength="8" style="border:none; width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $qtdstq_antes; ?>" onKeyPress="return isNumberKey2(event)" ></div>				
										</td>
										
										<td><div align="center"><input onchange="CalcGanho('qtdstq_ganho')" type="text" name="qtdstq_apos" id="qtdstq_apos" maxlength="8" style="border:none; width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $qtdstq_apos; ?>" onKeyPress="return isNumberKey2(event)"></div>				
										</td>
										
										<td><div align="center"><input readonly type="text" name="qtdstq_ganho" id="qtdstq_ganho" maxlength="8" style="border:none; width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $qtdstq_ganho; ?>" onKeyPress="return isNumberKey2(event)"></div>				
										</td>				
									</tr>
								
									<tr>
										<td>Distância (m)
										</td>
										
										<td><div align="center"><input onchange="CalcGanho('dist_ganho')" type="text" name="dist_antes" id="dist_antes" maxlength="8" style="border:none; width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $dist_antes; ?>" onKeyPress="return isNumberKey2(event)"></div>				
										</td>
										
										<td><div align="center"><input onchange="CalcGanho('dist_ganho')" type="text" name="dist_apos" id="dist_apos" maxlength="8" style="border:none; width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $dist_apos; ?>" onKeyPress="return isNumberKey2(event)"></div>				
										</td>
										
										<td><div align="center"><input readonly type="text" name="dist_ganho" id="dist_ganho" maxlength="8" style="border:none; width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $dist_ganho; ?>" onKeyPress="return isNumberKey2(event)"></div>				
										</td>			
									</tr>
									
									<tr>
										<td>Espaço (m²)
										</td>
										
										<td><div align="center"><input onchange="CalcGanho('esp_ganho')" type="text" name="esp_antes" id="esp_antes" maxlength="8" style="width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $esp_antes; ?>" onKeyPress="return isNumberKey2(event)"></div>				
										</td>
										
										<td><div align="center"><input onchange="CalcGanho('esp_ganho')" type="text" name="esp_apos" id="esp_apos" maxlength="8" style="width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $esp_apos; ?>" onKeyPress="return isNumberKey2(event)"></div>				
										</td>
										
										<td><div align="center"><input readonly type="text" name="esp_ganho" id="esp_ganho" maxlength="8" style="width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $esp_ganho; ?>" onKeyPress="return isNumberKey2(event)"></div>				
										</td>				
									</tr>
									
									<tr>
										<td>Financeiro (R$/ano)
										</td>
										
										<td><div align="center"><input  type="text" name="finan_antes" id="finan_antes" maxlength="8" style="width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $finan_antes; ?>" onKeyPress="return isNumberKey2(event)" onChange="CalcGanho('finan_ganho')" ></div>				
										</td>
										
										<td><div align="center"><input  type="text" name="finan_apos" id="finan_apos" maxlength="8" style="width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $finan_apos; ?>" onKeyPress="return isNumberKey2(event)" onChange="CalcGanho('finan_ganho')"></div>				
										</td>
										
										<td><div align="center"><input readonly type="text" name="finan_ganho" id="finan_ganho" maxlength="8" style="width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $finan_ganho; ?>" onKeyPress="return isNumberKey2(event)" ></div>				
										</td>				
									</tr>
									
									<tr>
										<td>Tempo (minutos)
										</td>
										
										<td><div align="center"><input  type="text" name="tempo_antes" id="tempo_antes" maxlength="8" style="width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $tempo_antes; ?>" onKeyPress="return isNumberKey(event)" onChange="CalcGanho('tempo_ganho')" ></div>				
										</td>
										
										<td><div align="center"><input  type="text" name="tempo_apos" id="tempo_apos" maxlength="8" style="width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $tempo_apos; ?>" onKeyPress="return isNumberKey(event)" onChange="CalcGanho('tempo_ganho')"></div>				
										</td>
										
										<td><div align="center"><input readonly type="text" name="tempo_ganho" id="tempo_ganho" maxlength="8" style="width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $tempo_ganho; ?>" onKeyPress="return isNumberKey(event)" ></div>				
										</td>				
									</tr>
									
									<tr>
										<td><div align="left">Outros: &nbsp <input type="text" name="outro_desc" id="outro_desc" maxlength="50" style="width:210px; heigth:4px; text-align:left; border:none" value="<?php echo $outro_desc; ?>" ></div>								
										</td>
										
										<td><div align="center"><input  type="text" name="outro_antes" id="outro_antes" maxlength="15" style="width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $outro_antes; ?>" ></div>				
										</td>                           
										                                
										<td><div align="center"><input  type="text" name="outro_apos" id="outro_apos" maxlength="15" style="width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $outro_apos; ?>" ></div>				
										</td>                           
										                                
										<td><div align="center"><input  type="text" name="outro_ganho" id="outro_ganho" maxlength="15" style="width:60px; heigth:4px; text-align:center;border:none"  value="<?php echo $outro_ganho; ?>" ></div>				
										</td>				
									</tr>
								</table>					  
							</div>
						</td>						
					</tr>
				</table>
			</div>
		</div>
	</div>

	

<div class="esconder">
	<input name="acao" id="acao" type="hidden">
	<input name="FotoAntes" id="FotoAntes" type="hidden"  value="<?php echo ($fotoantes); ?>">
	<input name="FotoApos" id="FotoApos" type="hidden"  value="<?php echo ($fotoapos); ?>">
	<input type="checkbox" name="saude" id="saude" style="visibility:hidden" <?php if (isset($_REQUEST['saude'])) {echo ("checked");} ?>>
	<input type="checkbox" name="seg" id="seg" style="visibility:hidden" <?php if (isset($_REQUEST['seg'])) {echo ("checked");} ?>>
	<input type="checkbox" name="pessoas" id="pessoas" style="visibility:hidden" <?php if (isset($_REQUEST['pessoas'])) {echo ("checked");} ?>>
	<input type="checkbox" name="quali" id="quali" style="visibility:hidden" <?php if (isset($_REQUEST['quali'])) {echo ("checked");} ?> >
	<input type="checkbox" name="prod" id="prod"  style="visibility:hidden"	<?php if (isset($_REQUEST['prod'])) {echo ("checked");} ?>>
	<input type="checkbox" name="custos" id="custos" style="visibility:hidden" 	<?php if (isset($_REQUEST['custos'])) {echo ("checked");} ?> onChange="MostraValor()">
	<input type="checkbox" name="nd" id="nd" style="visibility:hidden" 	<?php if (isset($_REQUEST['nd'])) {echo ("checked");} ?>>
	<input type="checkbox" name="espera" id="espera" style="visibility:hidden"<?php if (isset($_REQUEST['espera'])) {echo ("checked");} ?>>
	<input type="checkbox" name="superprod" id="superprod" style="visibility:hidden"<?php if (isset($_REQUEST['superprod'])) {echo ("checked");} ?>>
	<input type="checkbox" name="transp" id="transp" style="visibility:hidden"<?php if (isset($_REQUEST['transp'])) {echo ("checked");} ?>>
	<input type="checkbox" name="invent" id="invent" style="visibility:hidden"<?php if (isset($_REQUEST['invent'])) {echo ("checked");} ?> >
	<input type="checkbox" name="movi" id="movi" style="visibility:hidden"<?php if (isset($_REQUEST['movi'])) {echo ("checked");} ?> >
	<input type="checkbox" name="process" id="process" style="visibility:hidden"<?php if (isset($_REQUEST['process'])) {echo ("checked");} ?> >
	<input type="checkbox" name="defeito" id="defeito" style="visibility:hidden"<?php if (isset($_REQUEST['defeito'])) {echo ("checked");} ?>>
	<input type="checkbox" name="meio_ambiente" id="meio_ambiente" style="visibility:hidden"<?php if (isset($_REQUEST['meio_ambiente'])) {echo ("checked");} ?>>
	<input id="LoadAntes" name="LoadAntes" type="file" accept="image/*" style="visibility: hidden; width:1px" onChange="Fsubmit('antes')">
	<input id="LoadApos" name="LoadApos" type="file" accept="image/*" style="visibility: hidden; width:1px"  onChange="Fsubmit('apos')">
	<input type="hidden" name="nomegerencia" id="nomegerencia" value="<?php echo $row_nomegerencia['nome'] ?>" >
	<input type="hidden" name="nomesupervisao" id="nomesupervisao" value="<?php echo $nomesupervisao; ?>" >
	<input type="hidden" name="nao_kaizen" id="nao_kaizen" value="<?php echo $nao_kaizen; ?>" >	
</div>
	
	<div align="center">
		<!--input class="btn btn-default btnvale " type="reset" value="Resetar" onClick="ResetVars()"-->
		<input class="btn btn-default btnvale " type="submit" value="Salvar" onClick="return ValidaForm()">
	</div>
	<br><br><br><br>
</form>

<script type="text/javascript">
	window.onload = function() {
		$(".loader").fadeOut("slow");
	}
	

	$("#imagemAntes").on('change', function () {
 
    if (typeof (FileReader) != "undefined") {
 		var tamanhoArquivo = parseInt(document.getElementById("imagemAntes").files[0].size);
        if(tamanhoArquivo > 250000){ 
            alert("O tamanho máximo permitido é 250 KB.");
        } else {

        var image_holder_antes = $("#imageAntes");
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

	$("#imagemApos").on('change', function () {
 		var tamanhoArquivo = parseInt(document.getElementById("imagemApos").files[0].size);
        if(tamanhoArquivo > 250000){ 
            alert("O tamanho máximo permitido é 250 KB.");
        } else {	 
	    if (typeof (FileReader) != "undefined") {
	 
	        var image_holder = $("#imageApos");
	        image_holder.empty();
	 
	        var reader = new FileReader();
	        reader.onload = function (e) {
	            $("<img />", {
	                "src": e.target.result,
	                "class": "thumb-image"
	            }).appendTo(image_holder);
	        }
	        image_holder.show();
	        reader.readAsDataURL($(this)[0].files[0]);
	    } else{
	        alert("Este navegador nao suporta FileReader.");
	    }
	}
});

		
</script>


<?php 
	echo '<script type="text/javascript">document.getElementById("titulo").focus();</script>';
	
	//preenche campo data com hoje no primeiro instante
	if (!isset($_REQUEST['data'])){
		echo '<script type="text/javascript"> 
			var dia = "";
			var mes = "";
			var ano = "";
			var strtdate = "";
			
			now = new Date;
			dia = now.getDate();
			if (dia < 10) dia = "0" + dia;
			
			mes = now.getMonth() + 1;
			if (mes < 10) mes = "0" + mes;
						
			ano = now.getFullYear();
			
			strdate = dia + "/" +  mes + "/" + ano; 
			document.getElementById("data").value = strdate;
		  </script>';
		  }

	
	if (isset($_REQUEST['nome1'])){
		echo '<script type="text/javascript">Xnome1();</script>';
	}
	if (isset($_REQUEST['nome2'])){
		echo '<script type="text/javascript">Xnome2();</script>';
	}
	if (isset($_REQUEST['nome3'])){
		echo '<script type="text/javascript">Xnome3();</script>';
	}
	if (isset($_REQUEST['nome4'])){
		echo '<script type="text/javascript">Xnome4();</script>';
	}
	if (isset($_REQUEST['nome5'])){
		echo '<script type="text/javascript">Xnome5();</script>';
	}
	
	if (isset($_REQUEST['custos'])){
		echo '<script type="text/javascript">
			 document.getElementById("img_custos").src = "Kaizens/Checked.png";
			 document.getElementById("custos").checked = true;
			 document.getElementById("DivValor").style.visibility ="visible";	
			 </script>';
	}
?>	

</body>
</html>
