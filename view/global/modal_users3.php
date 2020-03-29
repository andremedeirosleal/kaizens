<!-- DATATABLES HEADERS -->
<?php include($_SERVER['DOCUMENT_ROOT']."/kaizens/view/global/datatables_headers.php");?>

<style>
    #table_users td, #table_users th{
        cursor:pointer;
    }
</style>

<!--Modal-->	
<div class="modal" tabindex="-1" role="dialog" id="modal_users">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">		  
		  	<div class="modal-body">
          	<input type="text" autocomplete="off" class="form-control" style="margin-bottom:8px" id="search_users" placeholder="Digite o nome que deseja pesquisar"  >  
          	<table align="center" width="100%" class="cell-border hover nowrap tb_modal" id="table_users" cellspacing="0" >
                <thead>                
                </thead>
                <tbody>					
                </tbody>
            </table>			
		  	</div>
			<div class="modal-footer">
				<br><div align="center"><button align="middle" class="btn btn-primary msgalert-fechar btn-system-green" data-dismiss="modal">Fechar</button></div>
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
			$('#sl_usuarios').html('');
			$('#sl_usuarios').append($('<option>').text(email_selecionado).attr('value', email_selecionado));
			email_usuario = email_selecionado;
			table_dados.ajax.url(temp_fileajax+"&w=" + email_selecionado).load(function() {
				$("div#divLoading").removeClass('show');				
			});
			$("#modal_users").modal("hide");				
		}
	});
    
    //busca de usuarios
	$('#search_users').keyup(function(){
		table_users.search($(this).val()).draw() ;
    })
    
    function focus_usuarios(){        
        setTimeout(function(){ document.getElementById("search_users").focus(); }, 1000);
    }
</script>