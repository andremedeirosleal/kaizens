<?php 
header('Content-Type:text/html;charset=utf-8'); 
//include($_SERVER['DOCUMENT_ROOT']."/kaizens/connections/kaizens_prd.php");
//include($_SERVER['DOCUMENT_ROOT']."/kaizens/classes/funcoes.php");
//noerrors();
//checalogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>   
  	<!-- HEADERS COMUNS -->
    <?php include($_SERVER['DOCUMENT_ROOT']."/kaizens/view/global/headers_comuns.php");?>
   
    <!-- FUNCOES JS COMUNS -->
	<!-- <script src="/kaizens/view/global/funcoes.js"></script>	 -->
	
	<!-- css -->
	<link rel="stylesheet" href="css/cadastrar.css" >
</head>

<body>
	<!-- MENU -->
    <?php include($_SERVER['DOCUMENT_ROOT']."/kaizens/view/menu.php");?>    
	
	<!-- USERS MODAL-->
	<?php include($_SERVER['DOCUMENT_ROOT']."/kaizens/view/global/modal-users.php");?>
    
    <div class="container-fluid">
		<div align="center">
			<div class="card card-kaizen" >
				<!-- TITLE ROW -->
				<div class="row">
					<div class="col col-align-left logo-response">
						<img src="/kaizens/lib/images/logos/kaizen.png" class="img-left"/>				
					</div>
					<div class="col-8 col-100">
						<div class="row"	>
							<div class="col col-align-right lb lb-sup">
								<label >Título:</label> 
							</div>
							<div class="col col-align-left">
								<input class="form-control in-form" type="text" id="in_title" name="in_title"/>	
							</div>						
						</div>							
					</div>
					<div class="col col-align-right">
						<img src="/kaizens/lib/images/logos/kaizen.png" class="img-right"/>			
					</div>
				</div>

				<!-- DETAIL ROW -->
				<div class="row row-margin-top">					
					<div class="col ">
						<div class="row">
							<div class="col col-align-right lb">
								<label >Objetivo:</label> 
							</div>
							<div class="col col-align-left">
								<input class="form-control in-form" type="text" id="in_objective" name="in_objective"/>	
							</div>						
						</div>							
					</div>
					<div class="col ">
						<div class="row"	>
							<div class="col col-align-right lb lb-sup">
								<label >Supervisão:</label> 
							</div>
							<div class="col col-align-left">
								<select id="in_supervision" name="in_supervision" class="form-control in-form">
									<option selected value="2">Convidado</option>
								</select>
							</div>						
						</div>							
					</div>					
				</div>

				<!-- PHOTOS ROW -->
				<div class="row row-margin-top row-photos">
					<div class="col">
						<div class="row">
							<button class="btn btn-light btn-system-white btn-upload"><i class="fas fa-upload"></i> Upload foto "Antes"</button>
						</div>
						<div class="row">
							<div class="col div-img-before">
								<img id="img_before" name="img_before" src="/kaizens/lib/images/other/nao_havia.png"/>
							</div>
						</div>					
					</div>
					<div class="col">
						<div class="row">
							<button class="btn btn-light btn-system-white btn-upload"><i class="fas fa-upload"></i> Upload foto "Após"</button>
						</div>
						<div class="row">
							<div class="col div-img-after">
								<img id="img_after" name="img_after" src="/kaizens/lib/images/other/blank.png"/>
							</div>
						</div>
					</div>
				</div>
				

				<!-- DESC ROW -->
				<div class="row row-margin-top desc-row">					
					<div class="col col-textarea">
						<label> Descrição do antes:</label>
						<textarea id="in_desc_before" name="in_desc_after" rows="4" class="form-control"></textarea>
					</div>
					<div class="col col-textarea">
					<label class="lb-sup"> Descrição do após: </label>
						<textarea id="in_desc_before" name="in_desc_after" rows="4" class="form-control"></textarea>
					</div>
				</div>

				<!-- COLLAB PHOTOS & GAIN ROW -->
				<div class="row row-margin-top row-gain">	
					<div class="col col-photos">
						<div class="row">
							<div class="col col-photos">
								<div class="row lb-collab">Colab. 1</div>
								<div class="row">
									<select onclick="call_modal(1)" class="form-control sl-collab" id="in_collab1" name="in_collab1"></select>
								</div>
								<div class="row">
									<img class="img-collab" src="/kaizens/lib/images/other/blank.png"/>
								</div>
							</div>
							<div class="col col-photos">
								<div class="row lb-collab">Colab. 2</div>
								<div class="row">
									<select onclick="call_modal(2)" class="form-control sl-collab" id="in_collab1" name="in_collab1"></select>
								</div>
								<div class="row">
									<img class="img-collab" src="/kaizens/lib/images/other/blank.png"/>
								</div>
							</div>
							<div class="col col-photos">
								<div class="row lb-collab">Colab. 3</div>
								<div class="row">
									<select onclick="call_modal(3)" class="form-control sl-collab" id="in_collab1" name="in_collab1"></select>
								</div>
								<div class="row">
									<img class="img-collab" src="/kaizens/lib/images/other/blank.png"/>
								</div>
							</div>
							<div class="col col-photos">
								<div class="row lb-collab">Colab. 4</div>
								<div class="row">
									<select onclick="call_modal(4)" class="form-control sl-collab" id="in_collab1" name="in_collab1"></select>
								</div>
								<div class="row">
									<img class="img-collab" src="/kaizens/lib/images/other/blank.png"/>
								</div>
							</div>
							<div class="col col-photos">
								<div class="row lb-collab">Colab. 5</div>
								<div class="row">
									<select onclick="call_modal(5)" class="form-control sl-collab" id="in_collab1" name="in_collab1"></select>
								</div>
								<div class="row">
									<img class="img-collab" src="/kaizens/lib/images/other/blank.png"/>
								</div>
							</div>							
						</div>
					</div>
					<div class="col-4 col-photos">
						<div class="row gain-title" >Ganhos estimados</div>
						<div class="row gain-title" >
							<div class="form-check">
								<label class="form-check-label lb">
									<input id="in_time" name="in_time" type="checkbox" class="form-check-input" value="">Tempo
								</label>
							</div>					
						</div>
						<div class="row gain-title" >
							<div class="form-check">
								<label class="form-check-label lb">
									<input id="in_distance" name="in_distance"  type="checkbox" class="form-check-input" value="">Distância
								</label>
							</div>					
						</div>
						<div class="row gain-title" >
							<div class="form-check">
								<label class="form-check-label lb">
									<input id="in_quality" name="in_quality" type="checkbox" class="form-check-input" value="">Qualidade
								</label>
							</div>					
						</div>
						<div class="row gain-title" >
							<div class="form-check">
								<label class="form-check-label lb">
									<input id="in_productivity" name="in_productivity"  type="checkbox" class="form-check-input" value="">Produtividade
								</label>
							</div>					
						</div>
						<div class="row gain-title" >
							<div class="form-check">
								<label class="form-check-label lb">
									<input id="in_cost" name="in_cost" type="checkbox" class="form-check-input" value="">Custo
								</label>
							</div>					
						</div>						
					</div>
				</div>

				<!-- BUTTONS ROW -->
				<div class="row row-margin-top row-margin-bottom">					
					<div class="col">
						<!-- <button class="btn btn-danger" onclick="cancel()"><i class="fas fa-times"></i> Cancelar</button> -->
						<button class="btn btn-success btn-system-green"><i class="fas fa-save"></i> Salvar</button>
						<br>
					</div>
				</div>
			</div>
		</div>
    </div>
   
</body>

<script>
	function cancel(){
		var confirmate = confirm("Deseja realmente cancelar o registro?");
		if (confirmate) location='cadastrar.php';
	}

	function call_modal(index){
		$("#modal_users").modal('show');
	}
</script>


</html>