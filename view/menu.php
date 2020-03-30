<html lang="en">
<style>
	#drp_user{
		position: absolute;
    	top: 100%;
    	left: 1!important;
		right: 0 !important; 
	}	
		
</style>
<body>	
	<link rel="stylesheet" href="/kaizens/view/css/menu.css" >

	<!--MENU-->	
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="/kaizens">
		  <!-- <img src="/kaizens/lib/images/logos/gears-logo.png" class="logo"/> -->
		  Central de Kaizens
	  </a>
	  <button id="menu" class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon navbar-dark"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
		  <li class="nav-item"> <a class="nav-link" href="/kaizens/view/dashboard.php">DASHBOARD</a> </li>	  
		  <li class="nav-item"> <a class="nav-link" href="/kaizens/view/insert.php">CADASTRAR</a> </li>	 		  
		  <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				CONSULTAR
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" href="/kaizens/view/list.php" ><i class="fa fa-list"></i> Lista</a>												
				<a class="dropdown-item" href="/kaizens/view/panel.php" ><i class="fa fa-map-pin"></i> Painel</a>												
			</div>
		  </li>
		  <?php
			//OPÇÕES PARA ADMINISTRADORES			
			if (isset($_SESSION['ID_USER'])){
				$permitido = checapermissao(1);	
				if ($permitido)echo '<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					ADMIN
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="/kaizens/web/pcs/usuarios.php" ><i class="fa fa-user"></i> Usuários</a>												
						<a class="dropdown-item" href="/kaizens/web/pcs/logs_controle_producao.php" ><i class="fa fa-history"></i> Logs do Controle de Produção</a>												
						<a class="dropdown-item" href="#" onclick="$(\'#modalsedes\').modal(\'show\');"><i class="fa fa-industry"></i> Selecionar sede</a>				
					</div>
			  	</li>';				
			}
		  ?>		  
		</ul>
		<ul class="form-inline my-2 my-lg-0">		
		  <?php 
			//checa se usuario esta logado
			if (isset($_SESSION['NM_USER'])) {
				echo
				'<li class="nav-item dropdown" style="list-style-type: none;">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					USUÁRIO <i class="fas fa-user"></i>
					</a>
					<div id="" class="dropdown-menu" aria-labelledby="navbarDropdown"  >								  												
						<a class="dropdown-item" href="/kaizens/index.php?logout=yes"><i class="fa fa-sign-out-alt"></i> Log Out</a>
					</div>					
				</li>';
			}else 
				echo '<a class="nav-link"  href="/kaizens/classes/login.php" title="Efetuar login"><i class="fas fa-user"> </i> Guest</a>';				
			?>
		</ul>
	  </div>
	</nav>		
</body>
</html>