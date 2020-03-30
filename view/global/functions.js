	
	function msgalert(msg){	
		document.getElementById("msgalert").innerHTML = msg;
		$("#modalmsgalert").modal("show");
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
		
	function isNumberKey(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
			
		//só permite numeros
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;	    
		return true;
	}
	
	function isNumberKey2(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode			
		if (charCode == 44) return true; //aceita ,
		
		//só permite numeros
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;	    
		return true;
	}
	
	function formatahora(id, evt){		
		var x = document.getElementById(id).value;		
		var charCode = (evt.which) ? evt.which : event.keyCode	   		
		
		//Só aceita se for número, senão descarta
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;		
		else{
			//Acrescenta barras
			if (x.length == 2){
				document.getElementById(id).value = x.concat(":");}
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
    
    function formatadata(data){		
		if (data.length >0){
            var dia = data.substr(0, 2);
            var mes = data.substr(3, 2);			
            var ano = data.substr(6, 4);
            strdate = ano + "-" +  mes + "-" + dia; 
            return strdate;
        }else return "NULL";
    }
	
	async function login(){		
		$("div#divLoading").addClass('show');					
		$.ajax({
            type: "POST",
            url: "/gvpetros/classes/autenticar.php",
            data : $("#form_login").serialize(),
            dataType: "json",
            success: function (data) {                    
				var success = data['success']; 							               
                if(success == "erro"){                                            
                    display_msg(1);
                    $("div#divLoading").removeClass('show');
                    return false;
                }
                if(success == "autorizacao") {                        
                    display_msg(2);
                    $("div#divLoading").removeClass('show');
                    return false;                                
                }
                if(success == "ok") {       
					confirma_login(true);
					return true;                                
                }
				alert("Erro inesperado. Por favor aguarde enquanto trabalhamos nisso.");
				$("div#divLoading").removeClass('show');
				return false;
            }
        });//end ajax             
        return false;     
	} 
	
	function display_msg(opcao){
        if (opcao == 0) {
            document.getElementById("msg_return").style.display = "none";
            return;
        }        
        if (opcao == 1) document.getElementById("msg_return").innerHTML = "Usuário ou senha inválidos";        
        if (opcao == 2) document.getElementById("msg_return").innerHTML = "Usuário não autorizado";         
        document.getElementById("msg_return").style.display = "block";        
	}  
	
	//TIMEOUT DE INATIVIDADE
	var idleTime = 0;			//Increment the idle time counter every 10s.
	function timerIncrement() {
		idleTime = idleTime + 1;
		if (idleTime > 11) { // 120 segundos / 2 minutos
			window.location.reload();
		}
	}