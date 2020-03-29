<!-- DATATABLES HEADERS -->
<?php include($_SERVER['DOCUMENT_ROOT']."/kaizens/view/global/datatables_headers.php");?>

<style>
    #table_users td, #table_users th{
        cursor:pointer;
    }
</style>
<select class="form-control" id="sl_users" onclick="" style='display:inline; cursor:pointer' data-toggle="modal" placeholder="Selecione email para filtrar" data-target="#modal_users" style="width:300px">
    <option value="">Clique aqui para filtrar por usuario </option>
</select>

<!--Modal-->	
<div class="modal" tabindex="-1" role="dialog" id="modal_users">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		  
		  <div class="modal-body">
          <input type="text" autocomplete="off" class="form-control" style="margin-bottom:8px" id="busca_usuarios" placeholder="Digite o nome que deseja pesquisar"  >  
          	<table align="center" width="100%" class="cell-border hover nowrap tb_modal" id="table_users" cellspacing="0" >
                <thead>                
                </thead>
                <tbody>					
                </tbody>
            </table>			
		  </div>
		  <div class="modal-footer">
			<br><div align="center"><button align="middle" class="btn btn-primary msgalert-fechar" data-dismiss="modal">Fechar</button></div>
		  </div>
		</div>
	</div>
</div>	

<script>    
	//carrega usuarios
    var table_users = $('#table_users').DataTable( {			
		ajax: "/kaizens/json/users_json.php",
		dom: 'rtip',
		paginate: true,
		filter: true,	
		colReorder: true,			
		columns: [				
			{ "title":"NOME","data": "nm_user" },	
			{ "title":"E-MAIL","data": "ds_email" },	
			{ "title":"SUPERVISÃO","data": "ds_supervision" },	
			{ "title":"GERÊNCIA","data": "ds_manager" },	
		]
    });

    //evento onclick tabela usuarios
	$('#table_users tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('selected') ) {
			//	$(this).removeClass('selected');
		}
		else {
			table_users.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var linha = table_users.row( this ).index();								
			var email_selecionado = table_users.cell(linha, 0).data();	
			table_dados.clear().draw();
			$("div#divLoading").addClass('show');
			$('#sl_users').html('');
			$('#sl_users').append($('<option>').text(email_selecionado).attr('value', email_selecionado));
			email_usuario = email_selecionado;
			table_dados.ajax.url(temp_fileajax+"&w=" + email_selecionado).load(function() {
				$("div#divLoading").removeClass('show');				
			});
			$("#modal_users").modal("hide");				
		}
	});
    
    //busca de usuarios
	$('#busca_usuarios').keyup(function(){
		table_users.search($(this).val()).draw() ;
    })
    
    function focus_usuarios(){        
        setTimeout(function(){ document.getElementById("busca_usuarios").focus(); }, 1000);
    }
</script>