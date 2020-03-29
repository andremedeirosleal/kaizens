<!DOCTYPE html>
<html >
<head>
	<!-- HEADERS PADROES -->
    <?php include($_SERVER['DOCUMENT_ROOT']."/kaizens/global/headers_comuns.php");?>

    <!-- FUNCOES JS COMUNS -->
    <script src="/kaizens/global/funcoes.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="/kaizens/view/css/login.css" >
</head>

<script language="javascript">	
	//função que verifica o capslock
	function checar_caps_lock(e){
		kc = e.keyCode?e.keyCode:e.which;
		sk = e.shiftKey?e.shiftKey:((kc == 16)?true:false);
		if(((kc >= 65 && kc <= 90) && !sk)||((kc >= 97 && kc <= 122) && sk))
			document.getElementById('divalert').style.visibility = 'visible';
		else
			document.getElementById('divalert').style.visibility = 'hidden';
	}		
</script>

<script>  
    function confirma_login(status){        
        if (!status)return false;
        window.location="/kaizens/index.php";       
    }
</script>
<body>  
    <div class="content">
        <form id="form_login" onsubmit="return false">
            <div class="contact-form">
                <center><img src="/kaizens/libs/images/logos/pcs2.png" class="avatar"></center>
                <p id="lb_user">Usuário</p>
                <input type="text" id="user" name="user" placeholder="Entre com usuário" onkeyup="display_msg(0)">
                <p>Senha</p>
                <input type="password" id="password" name="password" placeholder="Senha de acesso" onkeyup="display_msg(0)"> 
                <center><div id="msg_return">Usuário ou senha inválidos </div></center>
                <input type="submit" name="" onclick="login()" value="Login">
            </div>
        </form>
    </div>
    <div id="divLoading"></div>
</body>
</html>
