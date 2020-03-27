<?php 	
	include($_SERVER['DOCUMENT_ROOT']."/classes/funcoes.php");
	noerrors();
	checalogin();
	header('Content-Type:text/html;charset=utf-8');
	include($_SERVER['DOCUMENT_ROOT']."/classes/conexao.php");	
	include($_SERVER['DOCUMENT_ROOT']."/classes/rodape.php");		//inclui conexão com banco
	
	session_start();

	$_SESSION['caller'] = "/kaizens/index.php";	
	$_SESSION['menu'] = $_SERVER['DOCUMENT_ROOT']."/kaizens/menu.php";
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Central de Kaizens</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/images/icon.ico" /> 
	
	<!--bootstrap-->
	<link rel="stylesheet" type="text/css" href="/lib/bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="/lib/jquery/jquery-2.2.4.min.js"></script>    
	<script type="text/javascript" src="/lib/bootstrap/js/bootstrap.min.js"></script> 

	<!--DATATABLE-->	 
	<!--script type="text/javascript" language="javascript" src="/lib/jquery/jquery-2.2.4.js"></script-->
	<!--script type="text/javascript" language="javascript" src="/lib/jquery/jquery-3.2.1.min.js"></script--> 	
	<link rel="stylesheet" type="text/css" href="/lib/datatables-1.10.16/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="/lib/datatables-1.10.16/media/css/jquery.dataTables.min.css">	  
	<script type="text/javascript" language="javascript" src="/lib/datatables-1.10.16/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="/lib/datatables-1.10.16/media/js/jquery.dataTables.min.js"></script>  
	<link rel="stylesheet" type="text/css" href="/lib/datatables-1.10.16/Buttons-1.5.1/css/buttons.dataTables.min.css"> 
	<script type="text/javascript" language="javascript" src="/lib/datatables-1.10.16/Buttons-1.5.1/js/dataTables.buttons.min.js"></script>  	     
	<script type="text/javascript" language="javascript" src="/lib/datatables-1.10.16/JSZip-2.5.0/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="/lib/datatables-1.10.16/pdfmake-0.1.32/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="/lib/datatables-1.10.16/pdfmake-0.1.32/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="/lib/datatables-1.10.16/Buttons-1.5.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="/lib/datatables-1.10.16/Buttons-1.5.1/js/buttons.print.min.js"></script>
	<script type="text/javascript" language="javascript" src="/lib/datatables-1.10.16/Buttons-1.5.1/js/buttons.colVis.min.js"></script>

	<!--DATAPICKER-->
	<link rel="stylesheet" type="text/css" href="/lib/bootstrap/BSDatepicker/css/datepicker.css">
	<script type="text/javascript" src="/lib/datepicker/js/bootstrap-datepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/lib/datepicker/css/bootstrap-datepicker.min.css"/>
	
	<!--FONT AWESOME-->
	<link href="/lib/bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="/lib/bootstrap/font-awesome/css/font-awesome.css" rel="stylesheet">
	
	<!--GRAFICOS-->
	<script src="/lib/vendor/chart.js/Chart.min.js"></script>
	<style>
		/*cores
		verde escuro:#007E7A
		verde claro:#009D98
		dourado:#ECB11F
		verde linha: rgba(0,107,104,1)
		cinza claro: #F8F9FA
		cinza border: #cccccc
		*/
			
		
		/*cor do menu principal - verde escuro*/
		.navbar ul li a, .navbar-brand{	color: white !important;}
		.navbar-brand:hover{ background-color:#009D98 !important;} 
		.navbar ul li a:hover{background-color:#009D98 !important}	
		.navbar{
			background-color: #007E7A; 
			box-shadow: 2px 2px 2px 0 rgba(0, 0, 0, 0.7);
			
		}	
		
		
		/*configuração do Brand*/
		.navbar-brand{padding-left:30px;}		
		
		/*dropdown cores*/
		.navbar .nav li.dropdown.open > .dropdown-toggle, 
		.navbar .nav li.dropdown.active > .dropdown-toggle, 
		.navbar .nav li.dropdown.open.active > .dropdown-toggle {background-color: #009D98;}		
		.dropdown-menu li a, .dropdown-submenu li a{color:white !important;}		
		.dropdown-menu, .dropdown-submenu{background-color: #007E7A !important;}		
		.dropdown-submenu > a:focus, 
		.dropdown-submenu > a:hover, 
		.dropdown-submenu:focus>a, r, 
		.dropdown-submenu:hover>a,
		.dropdown-menu > li a:hover,
		.dropdown-menu > li a:focus { 
			background-color: #009D98 !important; 
			background-image: none !important; 
			filter: none !important; 
			text-decoration: none !important; 
			border: none !important; 
			color:white !important;
		}
		
		/*cor do divisor*/
		.divider{background-color:white !important;	}
		
		/*botão responsivo do navbar*/
		.navbar .navbar-toggle{background-color: #007E7A !important;}
		.navbar-toggle > .icon-bar{	background-color: white !important;	}		
		.navbar-toggle:hover{background-color: #009D98 !important;	}
		.navbar-toggle  {border: 1px solid white !important; background-color: #007E7A !important;}				
		
		/*Botão padrão vale*/
		.btnvale, #btnvale{
			background-color: #007E7A !important;		
			border: none !important;
			color: white !important;
			box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.5);
			outline:none !important;			
		}
		.btnvale:hover, #btnvale:hover{background-color: #009D98 !important; }			
		.btnvale:active, #btnvale:active {
			box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
		}
		
		/*configurações do rodapé*/
		.navbar-fixed-bottom li a{line-height:0 !important; font-size:12px !important; }
		.navbar-fixed-bottom{
			height:23px !important;						 
			min-height:0px !important;						
			border-top-color:white!important;
			background:white !important;							 
			font-size:12px !important;	
			color:white !important;
			padding-right:30px !important; 
			padding-left:10px !important;	
			padding-top:2px !important;
			border-top-color:none !important;
			padding-bottom:none !important;	
			background-color:#007E7A !important;			
		}		
		
		/*Configurações dos dropdowns para submenu*/
		.dropdown-submenu{ position: relative !important; }
		.dropdown-submenu>.dropdown-menu{
		  top:0 !important;
		  left:100% !important;
		  margin-top:-6px !important;
		  margin-left:-1px !important;
		  -webkit-border-radius:0 6px 6px 6px !important;
		  -moz-border-radius:0 6px 6px 6px !important;
		  border-radius:0 6px 6px 6px !important;
		}
		.dropdown-submenu>a:after{
		  display:block !important;
		  content:" " !important;
		  float:right !important;
		  width:0 !important;
		  height:0 !important;
		  border-color:transparent !important;
		  border-style:solid !important;
		  border-width:5px 0 5px 5px !important;
		  border-left-color:#cccccc !important;
		  margin-top:5px;margin-right:-10px !important;
		}
		.dropdown-submenu:hover>a:after{
		  border-left-color:#555 !important;
		}
		.dropdown-submenu.pull-left{ float: none !important; }
		.dropdown-submenu.pull-left>.dropdown-menu{
		  left: -100% !important;
		  margin-left: 10px !important;
		  -webkit-border-radius: 6px 0 6px 6px !important;
		  -moz-border-radius: 6px 0 6px 6px !important;
		  border-radius: 6px 0 6px 6px !important;
		}
		
		/*cor das setas*/
		/*.dropdown-submenu > a:after{border-left-color: #ffffff !important}*/
		.dropdown-submenu:hover > a:after{border-left-color: #ffffff !important}
		
		/*configuração para responsividade*/
		@media (min-width: 768px) { }
		@media (min-width: 992px) { }
		@media (min-width: 1200px){	}
		
	
		/*configurações dos datatables e tables*/
		td,th{font-size:14px;}			
		.glyphicon-edit{
			font-size:20px;
			color: black;
		}		
		/*selects das datatables*/
		.slfilter{
			height:20px;
			min-height:0px !important;
			padding:0px !important;
			margin:0px !important;
			border-radius:5px;
		}		
		/*botoes das datatables*/
		.dt-button{
			/*height:25px !important;
			width:25px !important;
			min-margin:0px !important;
			min-padding:0px !important;
			padding:0px !important;			
			align:center;
			text-align:center;*/
			margin:0px !important;
			border-radius: 4px !important;	
			height:30px !important;
			padding:5px !important;
		}	
		/*configuração para campos largos das datatables*/
		.campolargo{
		  max-width: 300 !important;
		  overflow: hidden !important;
		  text-overflow: ellipsis !important;
		  white-space: nowrap !important;
		}
		/*botoes de paginação*/
		.previous, .next, .paginate_button {
			height:25px;
			min-margin:0px !important;
			min-padding:0px !important;
			padding:0px !important;
			margin:5px !important;
			align:center;
			text-align:center;		
		}		
		/*selects length (quantidade de exibição do datatable)*/
		select[name="TableDados_length"]{
			margin-right: 30px;	
			border-radius:5px;
		}
		/*toolbar dos datatables*/
		.toolbar{
			float:left;
			margin-right:30px;			
		}
		#toolbar{
			border-radius:5px;
		}
		
		/*datepicker*/
		.datepicker{
			background-color:#ffffff !important;
		}
		.ui-datepicker{ z-index:1151 !important; }	
			body.modal-open .datepicker {
			z-index: 1200 !important;
		}
		
		/*barra de titulos e localização*/
		.breadcrumb{
			box-shadow: 2px 2px 2px 0 rgba(0, 0, 0, 0.5);
			border-color:gray !important;
			padding:10px !important;				
			margin:15px!important;		
			text-decoration:none !important;
		}
		
		/*nav-tabs*/
		.nav{
			padding-top:0px !important;
			margin-top:0px !important;
		}
		.nav-tabs a{		
			color:gray !important;	
			outline: none !important;
		}
		/*adiciona shadow a tab selecionada (evento on click)*/
		.selected{
			box-shadow: 2px -1px 1px rgba(0, 0, 0, 0.2) !important;			
		}
		
		/*panel default (usado nos datatables)*/
		.panel-default{
			box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.5);
			margin-top:0px; 
			border-top:none !important; 
			border-radius:0px !important; 
			text-align:center;
		}
		
		.grande-tab{
			background-color:white;
			border:1px solid #dddddd;			
			box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.5);
			margin-top:0px; 
			border-top:none !important; 
			border-radius:0px !important; 
			text-align:center;				
		}
		
		
		
		/*inputs*/
		input:focus, textarea:focus, select:focus{
			background:#FFFFEE !important;				
		}
		input{
			border-radius:5px;
		}
			
		/*tables*/
		table{cursor:pointer;}
		
		/*remove linha superior na classe table*/
		.table{	margin:0px; }
		.table tr:first-child td{border-top: none;}
		
		/*radio buttons*/
		.radiobt{
			padding-left:15px;
			width:150px;			
		}
		
		/*Modais*/
		.modal-header{
			height:30px !important;
			padding:0px !important;
			margin:0px !important;
			padding-left:13px !important;
			background-color: #007E7A;			
			border-top-left-radius:5px !important;
			border-top-right-radius:5px !important;
		}	
		.modal-header h5{
			color:white;
			font-size: 16px !important;
			font-weight:bold !important;
			padding-top:5px;			
		}
		.modal-header .close{
			padding:0px !important;
			margin:0px !important;
			position:relative;
			top:-26px;
			padding-right:10px !important;
			font-size: 25px !important;
		}
		.scroll-to-top{
			z-index:9999 !important;
		}
		
		#modalmsgalert{
			z-index:9999 !important;
		}
		
		.loader {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url('images/carregando.gif') 50% 50% no-repeat rgb(249,249,249);
		}
	</style>
	<script language="javascript">		
		    
		    
		(function($){
			//Configurações do dropdown para resposta do menu ao mousemove
			$(document).ready(function(){
				$('ul.dropdown-menu [data-toggle=dropdown]').on('mousemove', function(event) {
					event.preventDefault(); 
					event.stopPropagation(); 
					$(this).parent().siblings().removeClass('open');
					$(this).parent().addClass('open');
				});
				
				$('li.dropdown-menu [data-toggle=dropdown]').on('mouseout', function(event) {
					$(this).parent().removeClass('open');
				});
			});
		})(jQuery);
		
		function Help(){msgalert("Para suporte ou sugestões, envie um email para: \n'suporte.tovm@vale.com' ou para a lista 'L-TOVM'");}
		
		function msgalert(msg){	
			document.getElementById("msgalert").innerHTML = msg;
			$("#modalmsgalert").modal("show");
		}
		
		
		function Verifica_Hora(campo){
		   var campo = document.getElementById(campo);
		   hrs = (campo.value.substring(0,2));
		   min = (campo.value.substring(3,5));
		   estado = "";
		   if ((hrs < 00 ) || (hrs > 23) || ( min < 00) ||( min > 59)){
			  estado = "errada";
		   }
		   if (campo.value == "") {
			  estado = "errada";
		   }
		   
		   if (estado == "errada") {
			  campo.value = "";
			  campo.focus();
		   }
		}
		
		function formata_hora(id, evt){				
			var x = document.getElementById(id).value;		
			var charCode = (evt.which) ? evt.which : event.keyCode	   		
			
			//Só aceita se for número, senão descarta
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;		
			else{
				//Acrescenta barras
				if (x.length == 2){
					document.getElementById(id).value = x.concat(":");
				}
				return true;
			}		
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
		
		function ValidaData(campo){
			var x = document.getElementById(campo).value
			var dia = x.substring(0,2);
			var mes = x.substring(3,5);
			var ano = x.substring(6,x.length);
			var continua = true;
			
			//valida dia
			if (dia > 31) continua = false;
			
			//valida mes
			if (mes > 12) continua = false;
			
			//valida ano
			if (continua == true){
				if (ano.length == 2 || ano.length == 4){
					
					if (ano.length == 2 && ano > 14){
						ano = "20".concat(ano);
						x = dia.concat("/").concat(mes).concat("/").concat(ano);
						document.getElementById(campo).value = x;					
						}
					else{
						if (ano < 15) continua = false;}				
								
					if (ano.length == 4 && ano < 2015){continua = false;}
					}						    
				else{continua = false;}				
				}
				
			if (continua == false) document.getElementById(campo).value = ""; 			
		}
		
		
		//substitui caracteres de retorno de carro (break line) por <br> e elimina ' e "
		function settextOUT(dado){		
			//dado = dado.replace("\r\n", "<br>");
			dado = dado.replace(/\r/g, "<br>");
			dado = dado.replace(/\n/g, "<br>");
			dado = dado.replace(/\'/g, "");
			dado = dado.replace(/\"/g, "");
			dado = dado.replace(/\#/g, " ");
			dado = dado.replace(/\\/g, " ");
			dado = dado.replace(/\//g, " ");
			dado = dado.replace(/\&/g, " e ");
			dado = dado.replace(/^\s+|\s+$/gm,'');
			return dado;	
		}
		
		function checavazio(dado){			
			if (dado.length > 0) {
				return dado;
			}else{ 
				return "NULL";
			}
		}
		
		//substitui <br> por caracter de retorno de carro (break line)
		function settextIN(dado){
			do {
				dado = dado.replace("<br>", "\r");	
			}while (dado.indexOf("<br>") > -1);			
			return dado;
		}
		
		function formatadata(data){
			if (data.length >0){
				var dia = data.substr(0, 2);
				var mes = data.substr(3, 2);			
				var ano = data.substr(6, 4);
				strdate = ano + "-" +  mes + "-" + dia; 
				return strdate;
			}else return "NULL";
		}
		
		//conta caracteres do campo para exibição
		function contachar(campo, tamanho){
			var atual = campo.length;				
			document.getElementById('contachar').innerHTML = tamanho - atual;
		}
		
		//compara datas		
		function comparadatas(data1, data2){			
			if (data2.length < 1){
				data2 = new Date(Date.now()).toLocaleString();	//data de hoje
			}
			var d1 = new Date(data1);
			var d2 = new Date(data2);			
			if (d1 < d2) return('menor');			
			if (d1 > d2) return('maior');
			if (data1 == data2) return('igual');			
		}
		
		function hoje(){
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
			return strdate;			
		}
	</script>
</head>
<body>

<!--Modal MSGALERT-->
<div class="modal" id="modalmsgalert" name="modalmsgalert" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="false" data-backdrop="true" >
	<div class="modal-dialog" >
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="lineModalLabel">Central de Kaizens</h5>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>					
			</div>
			<div  class="modal-body">
				<div align="left" id="msgalert"></div>
				<br>
				<div align="center"><button align="middle" class="btn btn-default btnvale" data-dismiss="modal">Fechar</button></div>
			</div>
		</div>
	</div>
</div>

<div class="navbar"> 
	<div class="container-fluid">		
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/kaizens">Central de Kaizens</a>
		</div>
		
		<div class="collapse navbar-collapse" id="navbar-collapse-1">
			<ul class="nav navbar-nav">			
				
				<li class="dropdown">
					<a  href="#" class="dropdown-toggle" data-toggle="dropdown">Cadastrar <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="/kaizens/cadastro_kaizens.php">Kaizen</a></li>
						<li class="temp"><a class="a" href="/kaizens/ideias.php">Ideia</a></li>		
						<li class="temp"><a class="a" href="/kaizens/cadastro_kaizens.php?n=1">Condição Normal</a></li>						
					</ul>
				</li>
		  
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultar <b class="caret"></b></a>
					<ul class="dropdown-menu">																		
						<li class="dropdown dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Kaizens</a>
							<ul class="dropdown-menu">
								<li><a href="/kaizens/cons_kaizens.php">Em forma de lista</a></li>
								<li><a href="/kaizens/preview.php">Em forma de miniaturas (preview)</a></li>								
							</ul>
						</li>
						
						<li class="dropdown dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Condição Normal</a>
							<ul class="dropdown-menu">
								<li><a href="/kaizens/cons_kaizens.php?n=1">Em forma de lista</a></li>
								<li><a href="/kaizens/preview.php">Em forma de miniaturas (preview)</a></li>								
							</ul>
						</li>
						
						<li class="dropdown dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Gráficos</a>
							<ul class="dropdown-menu">
								<li><a href="/kaizens/graficos_gerencias.php">Gerências e Supervisões </a> </li>
								<li><a href="/kaizens/graficos_efvm.php">EFVM</a></li> 								
							</ul>
						</li>
						
						<li class="divider"></li>
						<li class="dropdown dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Replicações</a>
							<ul class="dropdown-menu">
								<li><a href="/kaizens/preview.php?replicados=1">Para toda EFVM </a> </li>
								<li><a href="/kaizens/preview.php?replicados=2">Para minha gerência</a></li> 
								<li><a href="/kaizens/preview.php?replicados=3">Para minha supervisão</a></li> 
								<li class="divider"></li>
								<li><a href="/kaizens/replicacoes.php" class="parent">Relatório de replicações</a></li>
							</ul>
						</li>
						
						<li class="dropdown dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Empregados</a>
							<ul class="dropdown-menu">
								<li><a href="/kaizens/destaques.php">Destaques</a></li>
								<li><a class="a" href="/kaizens/destaqueslista.php">Registros por empregado</a></li>															
							</ul>
						</li>
						
						<li class="dropdown dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Recomendações</a>
							<ul class="dropdown-menu">
								<li><a href="/kaizens/preview.php?share=1">Para toda EFVM </a> </li>
								<li><a href="/kaizens/preview.php?share=2">Para minha gerência</a></li> 
								<li><a href="/kaizens/preview.php?share=3">Para minha supervisão</a></li> 
								<li class="divider"></li>
								<li><a href="/kaizens/recomendacoes.php" class="parent">Relatório de recomendações</a></li>
							</ul>
						</li>
						<li class="dropdown dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Saúde e Segurança</a>
							<ul class="dropdown-menu">
								<li><a href="/kaizens/autorizados_ss.php">Técnicos Autorizados </a> </li>
								<li><a href="/kaizens/aprovacoes_ss.php">Relatório de aprovações</a></li> 
							</ul>
						</li>
						<li class="dropdown dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Equipe técnica</a>
							<ul class="dropdown-menu">
								<li><a href="/kaizens/autorizados_tec.php">Técnicos Autorizados </a> </li>
								<li><a href="/kaizens/aprovacoes_tec.php">Relatório de aprovações</a></li> 
							</ul>
						</li>
						
						<li class="divider"></li>
						<li class="dropdown dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Outros</a>
							<ul class="dropdown-menu">
								<li><a href="/classes/locacao/supervisoes.php">Supervisões cadastradas </a> </li>
								<li><a href="/classes/locacao/gerencias.php">Gerências cadastradas</a></li> 
							</ul>
						</li>						
					</ul>
				</li>
				
				
				
				<li id="mnusuarios" class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuários <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="/classes/usuarios/usuarios_cadastrar.php">Cadastrar</a></li>
						<li><a href="/classes/usuarios/usuarios_consultar.php">Consultar</a></li>
						<li class="divider"></li>
						<li><a title="Editar os dados do meu cadastro" href="/classes/usuarios/usuarios_editar.php?codedit=<?php echo $_SESSION['ID_USUARIO'];?>">Meu cadastro</a></li>
					</ul>
				</li>
			  
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Ajuda <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#" onclick="Help()">Suporte</a></li>
					</ul>
				</li>
			</ul>
			
			<ul class="nav navbar-nav navbar-right">				
				<li>
					<?php  
					if(isset($_SESSION['NM_USUARIO']) && strlen($_SESSION['NM_USUARIO'])>0)
						echo ("<a href='/classes/login.php' style='font-style:italic' title='Trocar de usuário' class='usuarioLogado'><span class='glyphicon glyphicon-user'></span>&nbsp;" .$_SESSION['NM_USUARIO']. "</a>");
					else{
						echo ("<a href='/classes/login.php' class=''><span class='glyphicon glyphicon-user'></span>&nbspEfetuar Login</a>");       
					}
					?>
				</li>          
			</ul>		  
		</div>	
	</div>
</div>

</body>
</html>