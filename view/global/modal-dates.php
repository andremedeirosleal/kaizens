	<script>
		var strdatas="";
		function filtra_datas(){						
			var str = "";	
			var dataini = (document.getElementById("dataini").value); 				
			var datafim = (document.getElementById("datafim").value);   
				
			//data ini e data fim
			if (dataini.length <10 || datafim.length < 10){	
				msgalert("Preencha DATA INÍCIO e DATA FIM corretamente.");
				return "erro";
			}
			
			if (dataini == 'dd/mm/aaaa' <10 || datafim == 'dd/mm/aaaa'){	
				msgalert("Preencha DATA INÍCIO e DATA FIM corretamente.");
				return "erro";
			}
			str = "&di=" + dataini + "&df=" + datafim;
			strdatas = str;		
			$("#modaldatas").modal('hide');
			return str;				
		}
		
		function datas(){
			var datasok = filtra_datas(); 							      
        	if (datasok != "erro") filtrar();		
		}
	</script>
	
	<!-- MODAL DATAS -->
	<div class="modal" tabindex="-1" role="dialog" id="modaldatas">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title">Selecione o período</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
          <form id="formdatas" name="formdatas" method="post" onsubmit="return false" autocomplete="off">
				<div align="center">
					<table class="" border="0" width="100%">
						<tr>
							<td width="" colspan="2">
								<div class="form-group">
									<label for="dataini">Data início</label>
									<input type="date" class="form-control" maxlength="10" name="dataini" id="dataini" placeholder="__/__/____"  >
								</div>
							</td>
						</tr>
						<tr>
							<td width="" colspan="2">
								<div class="form-group">
									<label for="datafim">Data fim  </label>					
									<input type="date" class="form-control" maxlength="10" name="datafim" id="datafim" placeholder="__/__/____" >
								</div>	
							</td>
						</tr>															
					</table>
				</div>		
				<center><button type="button" id="btn_filtrar_datas" style="width:150px" title="Filtrar pelas datas selecionadas" class="btn btn-success btn-system-green center-block" onclick="datas()">Filtrar</button></center>																	
			</form>				
		  </div>		  
		</div>
	  </div>
	</div>